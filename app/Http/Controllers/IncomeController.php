<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;
use HomeMoney\Models\Income;
use HomeMoney\Http\Requests\IncomeIndexRequest;
use Carbon\Carbon;
use HomeMoney\Models\Account;
use HomeMoney\Models\Receipt;
use HomeMoney\Http\Requests\IncomeStoreRequest;
use HomeMoney\Models\DateNumbering;
use HomeMoney\Services\IncomeServiceInterface;

class IncomeController extends Controller
{
	
	private $incomeService;
	
	public function __construct(IncomeServiceInterface $incomeServiceInterface)
	{
        $this->middleware('auth');
        $this->incomeService = $incomeServiceInterface;
	}
	
    public function index(IncomeIndexRequest $request)
    {
        $data = array();
        
    	// 一覧表示用の収入を取得
    	$builder = Income::where('delete_flag', false);
    	
    	// 日付の範囲が指定された場合
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
    	
    	// 最新のものから表示する
    	$builder->orderby('trade_date', 'desc');
    	$builder->orderby('sys_updated_at', 'desc');
    	
    	// 収入一覧データを取得
    	$data['incomes'] = $builder->get();
    	
    	// 検索項目を取得
    	$data['startDate'] = isset($tradeDateFrom) ? $tradeDateFrom : Carbon::now()->addMonths(-1)->format('Y-m-d'); // 開始日
    	$data['endDate'] = isset($tradeDateTo) ? $tradeDateTo : Carbon::now()->format('Y-m-d');                      // 終了日
    	$data['accounts'] = Account::where('enable_flag', true)->orderBy('dorder', 'desc')->get();                  // 勘定科目
    	$data['receipts'] = Receipt::where('enable_flag', true)->orderBy('dorder', 'desc')->get();                  // 受取方法
    	
    	// Formデータを取得
    	$data['req'] = $request;
    	
    	return view('income.index', $data);
    }
    
    public function create()
    {
        $data = array();
        
    	// 選択用の勘定科目
    	$data['accounts'] = Account::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	
    	// 選択用の受取方法
    	$data['receipts'] = Receipt::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
    	
    	// 取引日用の今日
    	$data['today'] = Carbon::now()->format('Y年m月d日');
    	
    	return view('income.create', $data);
    }
    
    /**
     * "create.blade.php"から呼び出される．editFlag=1の場合は更新、そうでない場合は登録
     * @param IncomeStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(IncomeStoreRequest $request)
    {
        if($request->editFlag == "1") {
            \DB::transaction(function() use($request) {
                $income = $this->incomeService->sharedLock(array($request->id));
                
                if($income->version != $request->version) {
                    return view('income.create', $data);
                }
                
            }, 5);
            
        } else {
        
        
            \DB::transaction(function() use($request) {
                $accountId = $request->accountId;
                $receiptId = $request->receiptId;
                $summery = $request->summery;
                $amount = str_replace(" 円", "", str_replace(",", "", $request->amount));
                $tradeDate = Carbon::createFromFormat('Y年m月d日', $request->tradeDate);
                $settleDate = Carbon::createFromFormat('Y年m月d日', $request->settleDate);
    	        $this->incomeService->store($accountId, $receiptId, $summery, $amount, $tradeDate, $settleDate);
    	    }, 5);
        }
    	return redirect()->route('income.create');
    }
    
    public function edit($id)
    {
        // 画面表示用の配列を宣言
        $data = array();
        
        // 編集対象の支出を取得
        $data['income'] = Income::find($id);
        
        // 選択項目を取得
        $data['accounts'] = Account::where('enable_flag', true)->orderBy('dorder', 'desc')->get(); // 勘定科目
        $data['receipts'] = Receipt::where('enable_flag', true)->orderBy('dorder', 'desc')->get(); // 受取方法
        $data['today'] = Carbon::now();
        $data['editFlag'] = true;
        
        return view('income.create', $data);
    }
    
}
