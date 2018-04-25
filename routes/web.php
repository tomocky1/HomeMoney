<?php

use HomeMoney\Http\Controllers\OutGoingController;

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

// Route::get('/', function () { return view('welcome'); });
Route::get('/', function() { return redirect()->route('login'); });
Route::get('top', 'MainController@top')->name('main.top');

// 認証
Auth::routes();

// マスタ関連
// 財布
Route::get('Wallet', 'WalletController@index')->name('wallet.index');
Route::post('Wallet', 'WalletController@store')->name('wallet.store');
Route::get('Wallet/delete/{id}', 'WalletController@delete')->name('wallet.delete');
Route::get('Wallet/edit/{id}', 'WalletController@edit')->name('wallet.edit');

// 支払い方法
Route::get('Payment', 'PaymentController@index')->name('payment.index');
Route::post('Payment', 'PaymentController@store')->name('payment.store');
Route::get('Payment/delete/{id}', 'PaymentController@destroy')->name('payment.delete');
Route::get('Payment/edit/{id}', 'PaymentController@edit')->name('payment.edit');

// 受取方法
Route::get('Receipt', 'Mst\ReceiptController@index')->name('receipt.index');
Route::get('Receipt/edit/{id}', 'Mst\ReceiptController@edit')->name('receipt.edit');
Route::post('Receipt', 'Mst\ReceiptController@store')->name('receipt.store');
Route::get('Receipt/delete/{id}', 'Mst\ReceiptController@delete')->name('receipt.delete');

// 勘定科目
Route::get('Account', 'Mst\AccountController@index')->name('account.index');
Route::get('Account/edit/{id}', 'Mst\AccountController@edit')->name('account.edit');
Route::post('Account/store', 'Mst\AccountController@store')->name('account.store');
Route::get('Account/delete/{id}', 'Mst\AccountController@delete')->name('account.delete');

// 収入
Route::get('Income', 'IncomeController@index')->name('income.index');
Route::post('Income', 'IncomeController@index')->name('income.search');
Route::get('Income/create', 'IncomeController@create')->name('income.create');
Route::post('Income/store', 'IncomeController@store')->name('income.store');

// 支出
Route::get('OutGoing', 'OutGoingController@index')->name('outgoing.index');
Route::post('OutGoing', 'OutGoingController@index')->name('outgoing.search');
Route::get('OutGoing/create', 'OutGoingController@create')->name('outgoing.create');
Route::post('OutGoing/store', 'OutGoingController@store')->name('outgoing.store');
Route::get('OutGoing/edit/{id}', 'OutGoingController@edit')->name('outgoing.edit');
Route::get('OutGoing/delete/{id}', 'OutGoingController@delete')->name('outgoing.delete');


// その他のコントローラ
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index')->name('test');
//Route::post('/api/Account/store', 'AccountController@apistore')->name('api.Account.store');