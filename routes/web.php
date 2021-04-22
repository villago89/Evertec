<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', 'ordersController@index');
Route::post('/crearOrder', 'ordersController@crearOrder');
Route::get('/pagos-list', 'ordersController@list');
Route::get('/shoppingcart', 'ordersController@shoppingcart');
Route::get('/getPrice/{id}', 'ordersController@getPrice');
Route::get('/confirmacion/{id}', 'placetopayController@confirmacion');
Route::get('/crearTransaccion/{id}', 'placetopayController@crearTransaccion');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

