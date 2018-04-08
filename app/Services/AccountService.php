<?php

namespace HomeMoney\Services;

use HomeMoney\Services\AccountServiceInterface;
use HomeMoney\Models\Account;

class AccountService implements AccountServiceInterface
{
	protected $account;
	
	public function __construct(Account $account)
	{
		$this->account = $account;
	}
	
	public function index($page)
	{
		$accounts = Account::where('sys_deleted_flag', false)->paginate(3);
		return $accounts;
	}
	
	public function store($data)
	{
		$account = new Account();
		$account->payment_id = $data->paymentId;
		$account->exe_date = $data->exeDate;
		$account->settle_date = $data->exeDate;
		$account->settle_flag = true;
		$account->summery = $data->summery;
		if($data->inCome != null) { $account->in_out = true; } else { $account->in_out = false; }
		if($data->inCome != null) { $account->amount = $data->inCome; } else { $account->amount = $data->outGoings; }
		if($data->income != null) { $account->up_down = $data->amount; } else { $account->up_down = $data->amount * (-1); }
		$account->saveDefault();
		 
		//    	return redirect()->to(action('AccountController@create'));
		return back()->withInput();
	}
}