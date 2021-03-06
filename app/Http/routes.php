<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('auth', 'AuthController@resolve');
Route::get('logout', 'AuthController@logout');
Route::get('feed', 'FeedController@index');

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function()
{
    Route::group(['prefix' => 'v1'], function()
    {
        Route::resource('translate', 'ApiController', ['only' => ['show']]);
    });

});
Route::group(['prefix' => 'callback'], function()
{
    Route::get('users', 'CallbackController@users');
    Route::post('users', 'CallbackController@usersPost');
});
