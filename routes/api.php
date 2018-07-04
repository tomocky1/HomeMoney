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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/Account/store', 'Api\AccountController@store')->name('api.Account.store');
Route::get('/Test', 'Api\TestController@index')->name('api.Test.index');
Route::middleware('auth:api')->get('/Account', 'Api\AccountController@index')->name('api.Account.index');
