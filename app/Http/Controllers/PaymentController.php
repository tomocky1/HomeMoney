<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Models\Payment;
use HomeMoney\Models\Wallet;
use HomeMoney\Http\Requests\PaymentStoreRequest;

class PaymentController extends Controller
{
    public function index()
    {
    	$data['payments'] = Payment::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
    	$data['wallets'] = Wallet::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
    	return view('payment.index', $data);
    }
    
    public function store(PaymentStoreRequest $request)
    {
    	// 支払い方法を保存する
    	if (isset($request->id)) {
    		$payment = Payment::find($request->id);
    	} else {
	    	$payment = new Payment();
    	}
    	$payment->name = $request->name;
    	$payment->wallet_id = $request->walletId;
    	$payment->dorder = $request->dorder;
    	$payment->saveDefault();
    	return redirect()->route('payment.index');
    }
    
    public function delete($id)
    {
    	$payment = Payment::find($id);
    	$payment->deleteDefault();
    	
    	return redirect()->route("payment.index");    
    }
    
    public function edit($id)
    {
    	$data['payments'] = Payment::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
    	$data['wallets'] = Wallet::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
    	$data['payment'] = Payment::find($id);
    	$data['editFlag'] = true;
    	return view('payment.index', $data);
    }
}
