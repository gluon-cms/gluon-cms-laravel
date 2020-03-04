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

//middleware API
Route::get('api/get/{id}', 'Gluon\GluonApiController@get');
Route::get('api/list/{type}', 'Gluon\GluonApiController@list');


//middleware ADMIN (GLUON)
Route::get('admin', 'Gluon\GluonAdminController@home');
Route::get('admin/list/{type}', 'Gluon\GluonAdminController@list');
Route::get('admin/edit/{type}/{id}', 'Gluon\GluonAdminController@edit');
Route::get('admin/create/{type}', 'Gluon\GluonAdminController@create');
Route::post('admin/handleForm', 'Gluon\GluonAdminController@handleForm');

//Web front
//Route::get('/', 'Front\HelloController@home')->name('hello.nolocale');
Route::get('/{locale}', 'Front\HelloController@home')->name('hello.home');
Route::get('/{locale}/article/{slug}-{id}', 'Front\HelloController@detail')->name('hello.detail');
