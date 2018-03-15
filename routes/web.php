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

Route::get('/goodslist','GoodslistController@index');
Route::get('/goodslist/update/{id}','GoodslistController@update');
Route::post('/goodslist/update/{id}','GoodslistController@update');
Route::get('/goodslist/delete/{id}','GoodslistController@delete');
Route::post('/goodslist/create','GoodslistController@create');
Route::get('autocomplete',array('as'=>'autocomplete','uses'=> 'GoodslistController@autocomplete'));
//Route::get('/goodslist/autocomplete','GoodslistController@autocomplete');

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

// Route to create a new role
Route::post('role', 'JwtAuthenticateController@createRole');
// Route to create a new permission
Route::post('permission', 'JwtAuthenticateController@createPermission');
// Route to assign role to user
Route::post('assign-role', 'JwtAuthenticateController@assignRole');
// Route to attache permission to a role
Route::post('attach-permission', 'JwtAuthenticateController@attachPermission');

// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    // Protected route
    Route::get('users', 'JwtAuthenticateController@index');
});

// Authentication route
Route::post('authenticate', 'JwtAuthenticateController@authenticate');

Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    Route::get('users', 'JwtAuthenticateController@index');

});