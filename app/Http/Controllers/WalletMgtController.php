<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Models\Wallet;
use HomeMoney\Http\Requests\WalletMgtStoreRequest;

class WalletMgtController extends Controller
{
	public function index()
	{
		$data['wallets'] = Wallet::where('sys_deleted_flag', '0')->where('enable_flag', true)->orderBy('dorder', 'asc')->get();
		return view('walletMgt.index', $data);
	}
	
	public function store(WalletMgtStoreRequest $request)
	{
		$wallet = new Wallet();
		$wallet->name = $request->name;
		$wallet->dorder = $request->dorder;
		$wallet->saveDefault();
		return redirect()->route("walletMgt.index");
	}
	
	public function delete($id)
	{
		$wallet = Wallet::find($id);
		$wallet->deleteDefault();
	
		return redirect()->route("walletMgt.index");
	}
}
