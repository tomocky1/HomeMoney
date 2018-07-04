<?php

namespace HomeMoney\Http\Controllers\Mst;

use HomeMoney\Http\Controllers\Controller;
use Illuminate\Http\Request;
use HomeMoney\Models\Wallet;
use HomeMoney\Http\Requests\WalletMgtStoreRequest;

class WalletController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		$data['wallets'] = Wallet::where('sys_deleted_flag', '0')->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
		return view('wallet.index', $data);
	}
	
	public function store(WalletMgtStoreRequest $request)
	{
		$wallet = (isset($request->id) ? Wallet::find($request->id) : new Wallet());
		$wallet->name = $request->name;
		$wallet->dorder = $request->dorder;
		$wallet->saveDefault();
		return redirect()->route("wallet.index");
	}
	
	public function delete($id)
	{
		$wallet = Wallet::find($id);
		$wallet->deleteDefault();
	
		return redirect()->route("wallet.index");
	}
	
	public function edit($id)
	{
		$data['wallet'] = Wallet::find($id);
		$data['wallets'] = Wallet::where('sys_deleted_flag', '0')->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
		$data['editFlag'] = true;
		return view('wallet.index', $data);
	}
}
