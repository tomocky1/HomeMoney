<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Models\Account;
use HomeMoney\Models\Payment;
use HomeMoney\Http\Requests\AccountStoreRequest;
use HomeMoney\Services\AccountServiceInterface;
use Illuminate\Support\Facades\Validator;

class TranController extends Controller
{
	protected $accountService;
	
	public function __construct(AccountServiceInterface $accountServiceInterface)
	{
		$this->accountService = $accountServiceInterface;
	}
	
    public function index()
    {
//    	$accounts = Account::where('sys_deleted_flag', false)->paginate(3);
//    	return view('account.index')->with('accounts', $accounts);
    	
//    	$data['accounts'] = Account::where('sys_deleted_flag', false)->paginate(3);
		$data['accounts'] = $this->accountService->index(1);
    	return view('account.index', $data);
    	   
//    	$data['accounts'] = Account::where('sys_deleted_flag', false)->get();
//    	return view('account.index', $data);
    }
    
    public function create()
    {
    	$data['payments'] = Payment::where('enable_flag', true)->get();
    	$data['accountLists'] = Account::where('enable_flag', true)->get();
    	return view('account.create', $data);
    }
    
    public function store(Request $request)
    {
    	$rules = [
            'summery'   => 'required',
        	'paymentId' => 'exists:payments,id',
        	'exeDate'   => 'required|date',
        	'inCome'    => 'digits:8',
        	'outGoings' => 'digits:8',
        ];
    	
    	$messages = [
    			'summery.required' => '摘要は必須です',
    			'paymentId.exists' => '支払い方法が存在しません',
    	];
    	
    	$validator = Validator::make($request->all(), $rules, $messages);
//    	$validator->validate();
    	if($validator->fails())
    	{
    		return redirect(route('Account.create'))->withErrors($validator)->withInput($request->all());
    	}
    	
    	
    	$this->accountService->store($request);
		return back()->withInput();
    }
    

}
