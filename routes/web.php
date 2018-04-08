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

// Route::get('/', function () { return view('welcome'); });
Route::get('/', function() { return redirect()->route('login'); });
Route::get('top', 'MainController@top')->name('main.top');

// 認証
Auth::routes();

// マスタ関連
// 財布
Route::get('WalletMgt', 'WalletMgtController@index')->name('walletMgt.index');
Route::post('WalletMgt', 'WalletMgtController@store')->name('walletMgt.store');
Route::get('WalletMgt/delete/{id}', 'WalletMgtController@delete')->name('walletMgt.delete');

// 支払い方法
Route::get('PaymentMgt', 'PaymentMgtController@index')->name('paymentMgt.index');
Route::post('PaymentMgt', 'PaymentMgtController@store')->name('paymentMgt.store');
Route::get('PaymentMgt/delete/{id}', 'PaymentMgtController@destroy')->name('paymentMgt.delete');

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


Route::get('AccountListManagement', 'Mst\AccountListController@index')->name('accountListManagement.index');
Route::post('AccountListManagement', 'Mst\AccountListController@store')->name('accountListManagement.store');
Route::get('AccountListManagement/delete/{id}', 'Mst\AccountListController@destroy')->name('accountListManagement.delete');

// その他のコントローラ
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index')->name('test');
//Route::post('/api/Account/store', 'AccountController@apistore')->name('api.Account.store');