<?php

namespace HomeMoney\Http\Controllers\Api;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Models\Account;

class AccountController extends Controller
{
	public function index() {
		$accounts = Account::all('id', 'name');
		return response()->json(["accounts" => $accounts]);
	}
	
	public function store() {
		return "fuga";
	}
}
