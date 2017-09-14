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

Route::get('/', function () {
    return view('login/index');
});
Route::post('/user/authenticate', 'LoginController@authenticate');

Route::group(['middleware' => 'auth'], function (){
    Route::get('user/logout', ['uses' => 'LoginController@logout']);
    Route::get('/dashboard', function (){
        return view('dashboard/index');
    });
});