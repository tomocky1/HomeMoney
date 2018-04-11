<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Http\Requests\OutGoingIndexRequest;
use HomeMoney\Models\OutGoing;
use HomeMoney\Models\Account;
use HomeMoney\Models\Payment;
use Carbon\Carbon;
use HomeMoney\Http\Requests\OutGoingStoreRequest;
use HomeMoney\Models\DateNumbering;

class OutGoingController extends Controller
{
    public function index(OutGoingIndexRequest $request)
    {
    	// 一覧表示用の収入を取得
    	$builder = OutGoing::where('delete_flag', false);
    	 
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
    	if(isset($request->paymentId)) {
    		$builder->where('payment_id', $request->paymentId);
    	}
    	
    	// 検索結果を取得
    	$data['outgoings'] = $builder->get();
    	
    	// 画面表示項目
    	// 開始日
    	$data['startDate'] = isset($tradeDateFrom) ? $tradeDateFrom : Carbon::now()->addMonths(-1)->format('Y-m-d');
    	$data['endDate'] = isset($tradeDateTo) ? $tradeDateTo : Carbon::now()->format('Y-m-d');
    	$data['accounts'] = Account::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	$data['payments'] = Payment::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	
    	$data['req'] = $request;
    	
    	return view('outgoing.index', $data);
    }
    
    public function delete()
    {
    	
    }
    
    public function edit()
    {
    	
    }
    
    public function create()
    {
    	// 選択用の勘定科目
    	$data['accounts'] = Account::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	 
    	// 選択用の支払方法
    	$data['payments'] = Payment::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	 
    	// 取引日用の今日
    	$data['today'] = Carbon::now()->format('Y年m月d日');
    	
    	return view('outgoing.create', $data);
    }
    
    public function store(OutGoingStoreRequest $request)
    {
    	$outgoing = new OutGoing();
    	$outgoing->account_id = $request->accountId;
    	$outgoing->payment_id = $request->paymentId;
    	$outgoing->outgoing_no = DateNumbering::getSingleDateNumber("0002", Carbon::today());
    	$outgoing->summery = $request->summery;
    	$outgoing->amount = str_replace(" 円", "", str_replace(",", "", $request->amount));
    	$outgoing->trade_date = Carbon::createFromFormat('Y年m月d日', $request->tradeDate);
    	$outgoing->settle_date = Carbon::createFromFormat('Y年m月d日', $request->settleDate);
    	$outgoing->regist_tsp = Carbon::now();
    	$outgoing->modify_flag = false;
    	$outgoing->delete_flag = false;
    	$outgoing->sys_deleted_flag = false;
    	$outgoing->save();
    	 
    	return redirect()->route('outgoing.create');
    }

}
