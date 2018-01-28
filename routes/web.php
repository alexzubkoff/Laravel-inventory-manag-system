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

Route::get('/goods','GoodsController@index');
Route::get('/goods/update/{id}','GoodsController@update');
Route::post('/goods/update/{id}','GoodsController@update');
Route::get('/goods/delete/{id}','GoodsController@delete');
Route::post('/goods/create','GoodsController@create');

Route::get('/counterparties','CounterpartiesController@index');
Route::post('/counterparties/create','CounterpartiesController@create');
Route::get('/counterparties/update/{id}','CounterpartiesController@update');
Route::post('/counterparties/update/{id}','CounterpartiesController@update');
Route::get('/counterparties/delete/{id}','CounterpartiesController@delete');

Route::get('/orderreceipt','OrderReceiptController@index');
Route::get('/orderreceipt/create','OrderReceiptController@create');
Route::post('/orderreceipt/create','OrderReceiptController@create');
Route::get('/orderreceipt/delete/{id}/{goodid}','OrderReceiptController@delete');


Route::get('/orderwithdrawal','OrderWithDrawalController@index');
Route::get('/orderwithdrawal/create','OrderWithDrawalController@create');
Route::post('/orderwithdrawal/create','OrderWithDrawalController@create');
Route::get('/orderwithdrawal/delete/{id}/{goodid}','OrderWithDrawalController@delete');

Route::get('/report/create','ReportController@create');
Route::post('/report/create','ReportController@create');