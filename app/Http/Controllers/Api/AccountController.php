<?php

namespace HomeMoney\Http\Controllers\Api;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Models\Account;
use HomeMoney\Http\Requests\Api\AccountStoreRequest;

class AccountController extends Controller
{
	public function index() {
		$accounts = Account::where('enable_flag', 1)->get(['id', 'name']);
		return response()->json(["accounts" => $accounts]);
	}
	
	public function store(AccountStoreRequest $request) {
		$account = isset($request->id) ? Receipt::find($request->id) : new Account();
		$account->name = $request->name	;
		$account->dorder = $request->dorder;
		$account->saveDefault();
		return response()->json(["result" => "success"]);
	}
}
