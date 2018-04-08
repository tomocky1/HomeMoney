<?php

namespace HomeMoney\Http\Controllers\Mst;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Models\Receipt;
use HomeMoney\Models\Wallet;
use HomeMoney\Http\Requests\ReceiptStoreRequest;

class ReceiptController extends Controller
{
	/**
	 * 受取方法管理の管理画面
	 */
    public function index()
    {
    	$date['receipt'] = null;
    	$data['receipts'] = Receipt::where('sys_deleted_flag', false)->where('enable_flag', true)->get();
    	$data['wallets'] = Wallet::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
    	return view('receipt.index', $data);
    }
    
    public function edit($id)
    {
    	$data['receipt'] = Receipt::find($id);
    	$data['receipts'] = Receipt::where('sys_deleted_flag', false)->where('enable_flag', true)->get();
    	$data['wallets'] = Wallet::where('sys_deleted_flag', false)->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
    	return view('receipt.index', $data);
    }
    
    public function store(ReceiptStoreRequest $request)
    {
    	if (isset($request->id)) {
    		$receipt = Receipt::find($request->id);
    	} else {
    		$receipt = new Receipt();
    	}
    	$receipt->name = $request->name;
    	$receipt->wallet_id = $request->walletId;
    	$receipt->dorder = $request->dorder;
    	$receipt->saveDefault();
    	return redirect()->route('receipt.index');
    }
    
    public function delete($id)
    {
    	$receipt = Receipt::find($id);
    	$receipt->deleteDefault();
    	return redirect()->route('receipt.index');
    }
}
