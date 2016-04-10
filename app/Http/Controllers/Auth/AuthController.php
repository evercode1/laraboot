<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\AuthTraits\ManagesSocial;
use Socialite;
use App\Exceptions\ConnectionNotAcceptedException;
use App\Exceptions\EmailNotProvidedException;
use App\Exceptions\NoActiveAccountException;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins, ManagesSocial;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $redirectAfterLogout = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest', ['except' => ['logout', 'handleProviderCallback', 'redirectToProvider']]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $data['is_subscribed'] = empty($data['is_subscribed']) ? 0 : 1;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'is_subscribed' => $data['is_subscribed'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        $socialUser = $this->userFromSocialite();


        $facebookEmail = $socialUser->getEmail();


        if ($this->socialUserHasNoEmail($facebookEmail)) {

            throw new EmailNotProvidedException;
        }

        if ($this->socialUserAlreadyLoggedIn()) {

            $this->checkIfAccountSyncedOrSync($socialUser);

        }

        // set authUser from socialUser

        $authUser = $this->setAuthUser($socialUser);

        $this->loginAuthUser($authUser);

        $this->logoutIfUserNotActiveStatus();

        return $this->redirectUser();

    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();


        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {

            $this->logoutIfUserNotActiveStatus();

            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param $authUser
     */
    private function loginAuthUser($authUser)
    {
        Auth::login($authUser, true);
    }

    private function logoutIfUserNotActiveStatus()
    {
        if ( ! Auth::user()->isActiveStatus()) {

            Auth::logout();

            throw new NoActiveAccountException;


        }
    }

    //overwrite the method from the RedirectrsUsers trait

    public function redirectPath()
    {

        if (Auth::user()->isAdmin()){

            return 'admin';
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */

    public function redirectToProvider()
    {

        return Socialite::driver('facebook')->redirect();
        //->scopes(['public_profile', 'email'])->redirect();
    }

    /**
     * @param $socialUser
     * @return User
     * @throws \App\Exceptions\CredentialsDoNotMatchException
     * @throws \App\Exceptions\EmailAlreadyInSystemException
     */
    private function setAuthUser($socialUser)
    {
        $authUser = $this->findOrCreateUser($socialUser);

        return $authUser;
    }

    /**
     * @return mixed
     * @throws ConnectionNotAcceptedException
     */
    private function userFromSocialite()
    {
        try {

            $socialUser = Socialite::driver('facebook')->user();

            return $socialUser;

        } catch (Exception $e) {

            throw new ConnectionNotAcceptedException;
        }

        return $socialUser;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $data['is_subscribed'] = empty($data['is_subscribed']) ? 0 : 1;
        $data['terms'] = empty($data['terms']) ? 0 : 1;

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'is_subscribed' => 'boolean',
            'password' => 'required|confirmed|min:6',
            'terms' => 'accepted'
        ]);
    }


}
