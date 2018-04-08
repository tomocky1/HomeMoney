<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Models\Payment;
use HomeMoney\Models\Wallet;
use HomeMoney\Http\Requests\PaymentMgtStoreRequest;

class PaymentMgtController extends Controller
{
    public function index()
    {
    	$data['payments'] = Payment::where('sys_deleted_flag', false)->where('enable_flag', true)->get();
    	$data['wallets'] = Wallet::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
    	return view('paymentMgt.index', $data);
    }
    
    public function store(PaymentMgtStoreRequest $request)
    {
    	// 支払い方法を保存する
    	$payment = new Payment();
    	$payment->name = $request->name;
    	$payment->wallet_id = $request->walletId;
    	$payment->dorder = $request->dorder;
    	$payment->saveDafault();
    	return redirect()->route('paymentMgt.index');
    }
    
    public function delete($id)
    {
    	$payment = Payment::find($id);
    	$payment->deleteDefault();
    	
    	return redirect()->route("paymentMgt.index");    
    }
}
