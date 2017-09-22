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
    Route::post('/user/checkPassword', ['uses' => 'LoginController@checkPassword']);
    Route::get('/user/checkUsername', ['uses' => 'LoginController@checkUsername']);
    Route::put('/user/editUser', ['uses' => 'LoginController@editUser']);
    Route::get('/manageUser', function () {
        return view('user/index');
    });
    Route::get('/manageUser/getAllUser', ['uses' => 'UserController@getAllUser']);
    Route::delete('/manageUser/deleteUser', ['uses' => 'UserController@deleteUser']);
    Route::post('/manageUser/addNewUser', ['uses' => 'UserController@addNewUser']);
    Route::get('/manageUser/getOneUser', ['uses' => 'UserController@getOneUser']);
    Route::put('/manageUser/updateUser', ['uses' => 'UserController@updateUser']);

    Route::get('/manageItemType', function () {
        return view('itemType/index');
    });
    Route::get('/manageItemType/getAllItem', ['uses' => 'ItemTypeController@getAllData']);
    Route::get('/manageItemType/getEditItem', ['uses' => 'ItemTypeController@getEditItem']);
    Route::post('/manageItemType/insertNewData', ['uses' => 'ItemTypeController@insertNewData']);
    Route::delete('/manageItemType/deleteData', ['uses' => 'ItemTypeController@deleteData']);
    Route::put('/manageItemType/updateItem', ['uses' => 'ItemTypeController@updateItem']);

    Route::get('/manageItem', function () {
       return view('item/index');
    });
});