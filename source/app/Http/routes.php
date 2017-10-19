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

Route::group(['middleware' => 'auth'], function () {
    Route::get('user/logout', ['uses' => 'LoginController@logout']);

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/manageUser', function () {
            return view('user/index');
        });
    });

    Route::get('/dashboard', function () {
        return view('dashboard/index');
    });
    Route::post('/user/checkPassword', ['uses' => 'LoginController@checkPassword']);
    Route::get('/user/checkUsername', ['uses' => 'LoginController@checkUsername']);
    Route::put('/user/editUser', ['uses' => 'LoginController@editUser']);

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
    Route::get('/manageItem/getAllData', ['uses' => 'ItemController@getAllData']);
    Route::get('/manageItem/getEditData', ['uses' => 'ItemController@getEditData']);
    Route::get('/manageItem/checkCodeItem', ['uses' => 'ItemController@checkCodeItem']);
    Route::post('/manageItem/insertNewData', ['uses' => 'ItemController@insertNewData']);
    Route::put('/manageItem/editData', ['uses' => 'ItemController@editData']);
    Route::delete('/manageItem/deleteData', ['uses' => 'ItemController@deleteData']);

    Route::get('/manageSupplier', function () {
        return view('supplier/index');
    });
    Route::post('/manageSupplier/insertNewData', ['uses' => 'SupplierController@insertNewData']);
    Route::get('/manageSupplier/getEditData', ['uses' => 'SupplierController@getEditData']);
    Route::get('/manageSupplier/getAllData', ['uses' => 'SupplierController@getAllData']);
    Route::put('/manageSupplier/editData', ['uses' => 'SupplierController@editData']);
    Route::delete('/manageSupplier/deleteData', ['uses' => 'SupplierController@deleteData']);

    Route::get('/transactionSales', function () {
        return view('transaction/sales');
    });
    Route::get('/transactionSales/getSalesCode', ['uses' => 'SalesController@autoNumberSales']);
    Route::get('/transactionSales/getItem', ['uses' => 'SalesController@getItem']);
    Route::get('/transactionSales/getAllItem', ['uses' => 'SalesController@getAllItem']);
    Route::get('/transactionSales/getCart', ['uses' => 'SalesController@getCart']);
    Route::post('/transactionSales/insertCart', ['uses' => 'SalesController@insertCart']);
    Route::delete('/transactionSales/deleteCart', ['uses' => 'SalesController@deleteCart']);
    Route::get('/transactionSales/getEditCart', ['uses' => 'SalesController@getEditCart']);
    Route::put('/transactionSales/updateCart', ['uses' => 'SalesController@updateCart']);
    Route::get('/transactionSales/insertDetailTransaction', ['uses' => 'SalesController@insertDetailTransaction']);
    Route::get('/transactionSales/insertMasterTransaction', ['uses' => 'SalesController@insertMasterTransaction']);
    Route::get('/transactionSales/insertTransaction', ['uses' => 'SalesController@insertTransaction']);
    Route::get('/transactionSales/checkQty', ['uses' => 'ItemController@checkQty']);
    Route::get('/transactionSales/checkQtyUpdate', ['uses' => 'ItemController@checkQtyUpdate']);
    Route::get('/transactionRecordSales', function () {
        return view('transaction/master');
    });
    Route::get('/transactionRecordSales/getMasterTransaction', ['uses' => 'SalesController@getMasterTransaction']);

    Route::get('/transactionPurchase', function () {
        return view('purchasing/index');
    });
    Route::get('/transactionPurchase/getAllPurchase', ['uses' => 'PurchaseController@getAllPurchase']);
    Route::get('/transactionPurchase/getEditPurchase', ['uses' => 'PurchaseController@getEditPurchase']);
    Route::post('/transactionPurchase/insertPurchase', ['uses' => 'PurchaseController@insertPurchase']);
    Route::delete('/transactionPurchase/deletePurchase', ['uses' => 'PurchaseController@deletePurchase']);

    Route::get('/transactionRecordPurchase', function () {
        return view('transaction/master');
    });
    Route::get('/transactionRecordSales/getRangeMasterTransaction', ['uses' => 'SalesController@getRangeMasterTransaction']);
    Route::get('/transactionRecordSales/getListDetailTransaction', ['uses' => 'SalesController@getListDetailTransaction']);
    Route::get('/transactionRecordSales/getTotalTransactionCurrentMonth', ['uses' => 'SalesController@totalSalesChart']);

});