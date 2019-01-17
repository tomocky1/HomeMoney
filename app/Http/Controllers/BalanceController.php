<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Models\Balance;

class BalanceController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	
	public function index() {
		
		$data['balances'] = Balance::join('wallets', 'balances.wallet_id', '=', 'wallets.id')->where('balances.sys_deleted_flag', false)->orderBy('wallets.dorder', 'desc')->get();
		return view('balance.index', $data);
	}
}
