<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use DB;
use App\User;
use Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        return view('user.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */

    public function show($id)
    {
        $user = User::findOrFail($id);

        $profile = $user->profile;

        return view('user.show', compact('user', 'profile'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->updateUser($user, $request);

        alert()->success('Congrats!', 'You updated a user');

        return Redirect::route('user.show', ['user' => $user]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        User::destroy($id);

        alert()->overlay('Attention!', 'You deleted a user', 'error');

        return Redirect::route('user.index');
    }
}