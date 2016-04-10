<?php
namespace App\Http\AuthTraits;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Exceptions\EmailNotProvidedException;
use App\Exceptions\EmailAlreadyInSystemException;
use App\Exceptions\AlreadySyncedException;
use Redirect;
use App\Exceptions\CredentialsDoNotMatchException;


trait ManagesSocial
{

    /**
     * @param $facebookUser
     * @return mixed
     */
    private function accountSynced($facebookUser)
    {

        if ($this->authUserEmailMatches($facebookUser)){

            return $this->verfiyUserIds($facebookUser);
        }

        return false;

    }

    private function authUserEmailMatches($facebookUser)
    {

        return $facebookUser->email == Auth::user()->email;
    }


    private function checkIfAccountSyncedOrSync($facebookUser)
    {
        //if you are logged in and accountSynced is true, you are already synced

        if ($this->accountSynced($facebookUser)){


            throw new AlreadySyncedException;

        } else {

            // check for email match

            if ( ! $this->authUserEmailMatches($facebookUser)) {

                throw new CredentialsDoNotMatchException;
            }

            // if emails match, then sync accounts

            $this->syncUserAccountWithSocialData($facebookUser);

            alert()->success('Confirmed!', 'You are now synced...');

            return $this->redirectUser();


        }


    }


    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        // is email already in table?
        // if email is in table, does the facebook id match?
        // if there is a match, return $authUser, if not throw exception

        if ( $authUser = User::where('email', $facebookUser->email)->first()){


            if ( ! $authUser->facebook_id == $facebookUser->id){

                throw new EmailAlreadyInSystemException;
            }

            return $authUser;

        }

        // check to see if existing user already has facebook id

        if ($this->idAlreadyExists($facebookUser)){


            throw new CredentialsDoNotMatchException;
        }



        //create user, if not already exists and email does not already exist.

        $password = $this->makePassword();

        return User::create([
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'password' => $password,
            'status_id' => 10,
            'facebook_id' => $facebookUser->id,
            'avatar' => $facebookUser->avatar
        ]);
    }

    /**
     * @param $facebookUser
     * @return mixed
     */
    private function idAlreadyExists($facebookUser)
    {
        return User::where('facebook_id', '=', $facebookUser->id)->exists();
    }

    /**
     * @return string
     */
    private function makePassword()
    {
        $passwordParts = rand() . str_random(12);
        $password = bcrypt($passwordParts);

        return $password;
    }

    private function redirectUser()
    {
        if (Auth::user()->isAdmin()){

            return redirect()->route('admin');
        }

        return redirect()->route('home');

    }

    /**
     * @return mixed
     */
    private function socialUserAlreadyLoggedIn()
    {

        return Auth::check();
    }

    private function socialUserHasNoEmail($socialUserEmail)
    {

        return $socialUserEmail == null;

    }

    /**
     * @param $facebookUser
     */
    private function syncUserAccountWithSocialData($facebookUser)
    {

        // lookup user and update user record

        $id = Auth::user()->id;

        $user = User::findOrFail($id);


        $user->update(['facebook_id' => $facebookUser->id,
                       'avatar'      => $facebookUser->avatar]);
    }


    /**
     * @param $facebookUser
     * @return bool
     */
    private function verfiyUserIds($facebookUser)
    {
        return (Auth::user()->facebook_id == $facebookUser->id) ? true : false;
    }

}
