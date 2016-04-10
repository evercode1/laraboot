<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\AuthTraits\OwnsRecord;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedException;
use DB;
use Redirect;
use App\Profile;
use App\User;

class ProfileController extends Controller
{
    use OwnsRecord;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only'=> 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('profile.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('profile.create');
    }

    public function myProfile()
    {

        $currentUser = Auth::id();

        $alreadyExists = DB::table('profiles')
            ->where('user_id', '=', $currentUser)
            ->exists();

        if($alreadyExists){

            return Redirect::route('show-profile');
        }

        return view('profile.create');
    }

    public function showProfileToUser()
    {

        $currentUser = Auth::id();

        $profile = Profile::where('user_id', '=', $currentUser)->first();

        if( ! $profile){

            return Redirect::route('profile.create');

        }

        $user = User::where('id', '=', $profile->user_id)->first();

        if ($this->userNotOwnerOf($profile)){

            throw new UnauthorizedException;
        }

        return view('profile.show', compact('profile', 'user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|alpha_num|max:20',
            'last_name' => 'required|alpha_num|max:20',
            'gender' => 'boolean',
            'birthdate' => 'date'
        ]);

        $profile = Profile::create(['first_name' => $request->first_name,
                                    'last_name' => $request->last_name,
                                    'gender' => $request->gender,
                                    'birthdate' => $request->birthdate,
                                    'user_id' => Auth::user()->id]);

        $profile->save();

        $user = User::where('id', '=', $profile->user_id)->first();

        alert()->success('Congrats!', 'You made your profile');

        return view('profile.show', compact('profile', 'user'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::findOrFail($id);

        $user = User::where('id', '=', $profile->user_id)->first();

        if( ! $this->adminOrCurrentUserOwns($profile)){

            throw new UnauthorizedException;
        }

        return view('profile.show', compact('profile', 'user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);

        if ( ! $this->adminOrCurrentUserOwns($profile)){

            throw new UnauthorizedException;
        }

        return view('profile.edit', compact('profile'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha_num|max:20',
            'last_name' => 'required|alpha_num|max:20',
            'gender' => 'boolean',
            'birthdate' => 'date'
        ]);

        $profile = Profile::findOrFail($id);

        if ($this->userNotOwnerOf($profile)) {

            throw new UnauthorizedException;
        }

        $profile->update(['first_name' => $request->first_name,
                          'last_name' => $request->last_name,
                          'gender' => $request->gender,
                          'birthdate' => $request->birthdate]);

        alert()->success('Congrats!', 'You updated your profile');

        return Redirect::route('profile.show', ['profile' => $profile]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        if ($this->userNotOwnerOf($profile)){

            throw new UnauthorizedException;
        }

        Profile::destroy($id);

        if (Auth::user()->isAdmin()){

            alert()->overlay('Attention!', 'You deleted a profile', 'error');

            return Redirect::route('profile.index');
        }

        alert()->overlay('Attention!', 'You deleted a profile', 'error');

        return Redirect::route('home');
    }
}