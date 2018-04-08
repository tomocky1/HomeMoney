<?php

namespace HomeMoney\Http\Controllers\Mst;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Http\Requests\AccountStoreRequest;
use HomeMoney\Models\Account;

class AccountController extends Controller
{
    public function index()
    {
    	$data['accounts'] = Account::where('sys_deleted_flag', false)->where('enable_flag', true)->get();
    	return view('account.index', $data);
    	}
    
    public function store(AccountStoreRequest $request)
    {
    	$account = new Account();
    	$account->name = $request->name	;
    	$account->dorder = $request->dorder;
    	$account->saveDefault();
    	return redirect()->route('account.index');
    }
    
    public function delete($id)
    {
    	
    }
    
    public function create()
    {
    	
    }
}
