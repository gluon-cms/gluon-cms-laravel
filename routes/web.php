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


//middleware API
Route::get('api/get/{id}', 'Gluon\GluonApiController@get');
Route::get('api/list/{type}', 'Gluon\GluonApiController@list');


//middleware ADMIN
Route::get('admin', 'Gluon\GluonAdminController@home');
Route::get('admin/list/{type}', 'Gluon\GluonAdminController@list');
Route::get('admin/get/{id}', 'Gluon\GluonAdminController@get');