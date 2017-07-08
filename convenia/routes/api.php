<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('/sale', 'SaleController',['only' => ['store']]);
Route::resource('/salesman', 'SalesmanController',['only' => ['store', 'index']]);
Route::group(['prefix' => 'salesman'], function () {
	Route::get('/{id}/sales', 'SalesmanController@getSaleBySalesmanID');
});