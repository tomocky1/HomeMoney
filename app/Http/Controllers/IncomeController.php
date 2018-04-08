<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Models\Wallet;
use HomeMoney\Models\Income;
use HomeMoney\Http\Requests\IncomeIndexRequest;
use Carbon\Carbon;
use HomeMoney\Models\Account;
use HomeMoney\Models\Receipt;
use HomeMoney\Http\Requests\IncomeStoreRequest;
use HomeMoney\Models\DateNumbering;

class IncomeController extends Controller
{
    public function index(IncomeIndexRequest $request)
    {
    	// 一覧表示用の収入を取得
    	$builder = Income::where('delete_flag', false);
    	
    	// 日付の範囲が指定された板場合
    	if(isset($request->tradeDateRange)) {
    		$tradeDateFrom = Carbon::createFromFormat('Y年m月d日', explode(" - ", $request->tradeDateRange)[0]);
    		$tradeDateTo = Carbon::createFromFormat('Y年m月d日', explode(" - ", $request->tradeDateRange)[1]);
    		$builder->where('trade_date', '>=', $tradeDateFrom);
    		$builder->where('trade_date', '<=', $tradeDateTo);
    	}
    	
    	// 勘定科目が指定された場合
    	if(isset($request->accountId)) {
    		$builder->where('account_id', $request->accountId);
    	}
    	
    	// 受取方法が指定された場合
    	if(isset($request->receiptId)) {
    		$builder->where('receipt_id', $request->receiptId);
    	}
    	
    	// 収入一覧データを取得
    	$data['incomes'] = $builder->get();
    	
    	// 検索項目用の勘定科目
    	$data['accounts'] = Account::where('enable_flag', true)->get();
    	
    	// 検索項目用の受取方法
    	$data['receipts'] = Receipt::where('enable_flag', true)->get();
    	
    	// Formデータを取得
    	$data['req'] = $request;
    	return view('income.index', $data);
    }
    
    public function create()
    {
    	// 選択用の勘定科目
    	$data['accounts'] = Account::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	
    	// 選択用の受取方法
    	$data['receipts'] = Receipt::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	
    	// 取引日用の今日
    	$data['today'] = Carbon::now()->format('Y年m月d日');
    	
    	return view('income.create', $data);
    }
    
    public function store(IncomeStoreRequest $request)
    {
    	$income = new Income();
    	$income->account_id = $request->accountId;
    	$income->receipt_id = $request->receiptId;
    	$income->income_no = DateNumbering::getSingleDateNumber("0001", Carbon::today());
    	$income->summery = $request->summery;
    	$income->amount = str_replace(" 円", "", str_replace(",", "", $request->amount));
    	$income->trade_date = Carbon::createFromFormat('Y年m月d日', $request->tradeDate);
    	$income->settle_date = Carbon::createFromFormat('Y年m月d日', $request->settleDate);
    	$income->regist_tsp = Carbon::now();
    	$income->modify_flag = false;
    	$income->delete_flag = false;
    	$income->sys_deleted_flag = false;
    	$income->save();
    	
    	return redirect()->route('income.create');
    }
    
}
