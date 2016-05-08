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

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


Route::group(['middleware' => 'auth'], function () {

    // Dashboard
    Route::get('/', ['as' => 'dashboard', 'uses' => 'Admin\DashboardController@index']);

    // Item
    Route::get('/item', ['as' => 'item.index', 'uses' => 'Admin\ItemController@index']);
    Route::get('/item/create', ['as' => 'item.create', 'uses' => 'Admin\ItemController@create']);
    Route::post('/item', ['as' => 'item.store', 'uses' => 'Admin\ItemController@store']);
    Route::get('/item/{id}/edit', ['as' => 'item.edit', 'uses' => 'Admin\ItemController@edit']);
    Route::post('/item/{id}', ['as' => 'item.update', 'uses' => 'Admin\ItemController@update']);
    Route::get('/item/{id}/destroy', ['as' => 'item.destroy', 'uses' => 'Admin\ItemController@destroy']);

    // Supplier
    Route::get('/supplier', ['as' => 'supplier.index', 'uses' => 'Admin\SupplierController@index']);
    Route::get('/supplier/create', ['as' => 'supplier.create', 'uses' => 'Admin\SupplierController@create']);
    Route::post('/supplier', ['as' => 'supplier.store', 'uses' => 'Admin\SupplierController@store']);
    Route::get('/supplier/{id}/edit', ['as' => 'supplier.edit', 'uses' => 'Admin\SupplierController@edit']);
    Route::post('/supplier/{id}', ['as' => 'supplier.update', 'uses' => 'Admin\SupplierController@update']);
    Route::get('/supplier/{id}/destroy', ['as' => 'supplier.destroy', 'uses' => 'Admin\SupplierController@destroy']);

    // Customer
    Route::get('/customer', ['as' => 'customer.index', 'uses' => 'Admin\CustomerController@index']);
    Route::get('/customer/create', ['as' => 'customer.create', 'uses' => 'Admin\CustomerController@create']);
    Route::post('/customer', ['as' => 'customer.store', 'uses' => 'Admin\CustomerController@store']);
    Route::get('/customer/{id}/edit', ['as' => 'customer.edit', 'uses' => 'Admin\CustomerController@edit']);
    Route::post('/customer/{id}', ['as' => 'customer.update', 'uses' => 'Admin\CustomerController@update']);
    Route::get('/customer/{id}/destroy', ['as' => 'customer.destroy', 'uses' => 'Admin\CustomerController@destroy']);

    // Purchase
    Route::get('/purchase', ['as' => 'purchase.index', 'uses' => 'Admin\PurchaseController@create']);
    Route::get('/purchase/create', ['as' => 'purchase.create', 'uses' => 'Admin\PurchaseController@create']);
    Route::post('/purchase', ['as' => 'purchase.store', 'uses' => 'Admin\PurchaseController@store']);
    Route::post('/purchase/save', ['as' => 'purchase.save', 'uses' => 'Admin\PurchaseController@save']);
    Route::get('/purchase/{id}/destroy', ['as' => 'purchase.destroy', 'uses' => 'Admin\PurchaseController@destroy']);
    Route::get('/purchase/destroy-all', ['as' => 'purchase.destroyAll', 'uses' => 'Admin\PurchaseController@destroyAll']);
    Route::get('/purchase/find-item-by-item-code/{item_code}', ['as' => 'purchase.findItemByItemCode', 'uses' => 'Admin\PurchaseController@findItemByItemCode']);
    Route::get('/purchase/find-item-by-item-name/{item_name}', ['as' => 'purchase.findItemByItemName', 'uses' => 'Admin\PurchaseController@findItemByItemName']);
    Route::get('/purchase/payment-mode/{payment_mode}', ['as' => 'purchase.paymentMode', 'uses' => 'Admin\PurchaseController@paymentMode']);

    // Sale
    Route::get('/sale', ['as' => 'sale.index', 'uses' => 'Admin\SaleController@create']);
    Route::get('/sale/create', ['as' => 'sale.create', 'uses' => 'Admin\SaleController@create']);
    Route::post('/sale', ['as' => 'sale.store', 'uses' => 'Admin\SaleController@store']);
    Route::post('/sale/save', ['as' => 'sale.save', 'uses' => 'Admin\SaleController@save']);
    Route::get('/sale/{id}/destroy', ['as' => 'sale.destroy', 'uses' => 'Admin\SaleController@destroy']);
    Route::get('/sale/destroy-all', ['as' => 'sale.destroyAll', 'uses' => 'Admin\SaleController@destroyAll']);
    Route::get('/sale/find-item-by-item-code/{item_code}', ['as' => 'sale.findItemByItemCode', 'uses' => 'Admin\SaleController@findItemByItemCode']);
    Route::get('/sale/find-item-by-item-name/{item_name}', ['as' => 'sale.findItemByItemName', 'uses' => 'Admin\SaleController@findItemByItemName']);
    Route::get('/sale/payment-mode/{payment_mode}', ['as' => 'sale.paymentMode', 'uses' => 'Admin\SaleController@paymentMode']);


    // Report
    Route::group(['prefix' => 'report'], function() {

        // Summary
        Route::get('/summary', ['as' => 'report.summary.index', 'uses' => 'Admin\Report\SummaryController@index']);
        Route::get('/summary/create', ['as' => 'report.summary.create', 'uses' => 'Admin\Report\SummaryController@create']);

        // Purchase
        Route::get('/purchase', ['as' => 'report.purchase.create', 'uses' => 'Admin\Report\PurchaseController@create']);
        Route::get('/purchase/{id}', ['as' => 'report.purchase.single_report', 'uses' => 'Admin\Report\PurchaseController@single_report']);
        Route::get('/purchase/search/bill_id', ['as' => 'report.purchase.search_bill_id', 'uses' => 'Admin\Report\PurchaseController@search_bill_id']);

        // Sale
        Route::get('/sale', ['as' => 'report.sale.index', 'uses' => 'Admin\Report\SaleController@create']);
        Route::get('/sale/{id}', ['as' => 'report.sale.single_report', 'uses' => 'Admin\Report\SaleController@single_report']);
        Route::get('/sale/search/bill_id', ['as' => 'report.sale.search_bill_id', 'uses' => 'Admin\Report\SaleController@search_bill_id']);



        // Profit
        Route::get('/profit', ['as' => 'report.profit.index', 'uses' => 'Admin\Report\ProfitController@index']);
        Route::get('/profit/create', ['as' => 'report.profit.create', 'uses' => 'Admin\Report\ProfitController@create']);

        // Stock
        Route::get('/stock', ['as' => 'report.stock.index', 'uses' => 'Admin\Report\StockController@index']);
        Route::get('/stock/{item_code}', ['as' => 'report.stock.create', 'uses' => 'Admin\Report\StockController@create']);
    });

});
