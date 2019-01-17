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
Route::get('Wallet', 'Mst\WalletController@index')->name('wallet.index');
Route::post('Wallet', 'Mst\WalletController@store')->name('wallet.store');
Route::get('Wallet/delete/{id}', 'Mst\WalletController@delete')->name('wallet.delete');
Route::get('Wallet/edit/{id}', 'Mst\WalletController@edit')->name('wallet.edit');

// 支払い方法
Route::get('Payment', 'Mst\PaymentController@index')->name('payment.index');
Route::post('Payment', 'Mst\PaymentController@store')->name('payment.store');
Route::get('Payment/delete/{id}', 'Mst\PaymentController@destroy')->name('payment.delete');
Route::get('Payment/edit/{id}', 'Mst\PaymentController@edit')->name('payment.edit');

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

// トランザクション
// 収入
Route::get('Income', 'IncomeController@index')->name('income.index');
Route::post('Income', 'IncomeController@index')->name('income.search');
Route::get('Income/create', 'IncomeController@create')->name('income.create');
Route::post('Income/store', 'IncomeController@store')->name('income.store');

// 支出
Route::get('Outgoing', 'OutgoingController@index')->name('outgoing.index');
Route::post('Outgoing', 'OutgoingController@index')->name('outgoing.search');
Route::get('Outgoing/create', 'OutgoingController@create')->name('outgoing.create');
Route::post('Outgoing/store', 'OutgoingController@store')->name('outgoing.store');
Route::get('Outgoing/edit/{id}', 'OutgoingController@edit')->name('outgoing.edit');
Route::get('Outgoing/delete/{id}', 'OutgoingController@delete')->name('outgoing.delete');

// 移動
Route::get('Move', 'MoveController@index')->name('move.index');
Route::get('Move/create', 'MoveController@create')->name('move.create');
Route::post('Move/store', 'MoveController@store')->name('move.store');

// 残高
Route::get('Balance', 'BalanceController@index')->name('balance.index');


// その他のコントローラ
//Route::post('/api/Account/store', 'AccountController@apistore')->name('api.Account.store');
Route::get('Test', 'TestController@index')->name('test.index');