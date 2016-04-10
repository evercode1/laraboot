<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// Api routes

Route::any('api/marketing-image', 'ApiController@marketingImageData');
Route::any('api/profile', 'ApiController@profileData');
Route::any('api/user', 'ApiController@userData');
Route::any('api/widget', 'ApiController@widgetData');


Route::group(['middleware' => ['web']], function () {
    // admin routes

    Route::get('admin', ['as' => 'admin', 'uses' => 'AdminController@index']);

    // auth routes

    Route::auth();

    // home page route

    Route::get('/', ['as' => 'home', 'uses' => 'PagesController@index']);

    // marketing images

    Route::resource('marketing-image', 'MarketingImageController');

    // privacy

    Route::get('privacy', 'PagesController@privacy');

    // profile routes

    Route::get('show-profile', ['as' => 'show-profile', 'uses' => 'ProfileController@showProfileToUser']);
    Route::get('my-profile', ['as' => 'my-profile', 'uses' => 'ProfileController@myProfile']);
    Route::resource('profile', 'ProfileController');

    // settings routes

    Route::get('settings', 'SettingsController@edit');
    Route::post('settings', ['as' => 'userUpdate', 'uses' => 'SettingsController@update']);

    // socialite routes

    Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

    // terms of service

    Route::get('terms-of-service', 'PagesController@terms');

    // test route

    Route::get('test', ['middleware' => ['auth', 'admin'], 'uses' => 'TestController@index']);

    // user routes

    Route::resource('user', 'UserController');

    // widget routes

    Route::get('widget/create', ['as' => 'widget.create', 'uses' => 'WidgetController@create']);

    Route::get('widget/{id}-{slug?}', ['as' => 'widget.show', 'uses' => 'WidgetController@show']);

    Route::resource('widget', 'WidgetController', ['except' => ['show', 'create']]);

});

