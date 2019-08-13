<?php

namespace HomeMoney\Services;

use Carbon\Carbon;
use HomeMoney\Services\IncomeServiceInterface;
use HomeMoney\Models\DateNumbering;
use HomeMoney\Models\Income;
use HomeMoney\Models\Tran;
use HomeMoney\Models\Balance;
use HomeMoney\Models\Receipt;

class IncomeService implements IncomeServiceInterface
{
    public function store($accountId, $receiptId, $summery, $amount, $tradeDate, $settleDate) {
        
        // 収入番号を編集
        $incomeNo = DateNumbering::getSingleDateNumber("0001", Carbon::today());
       
        // 受取方法を取得
        $receipt = Receipt::find($receiptId);
        
        // 収入エンティティに登録
        $income = new Income();
        $income->account_id = $accountId;
        $income->receipt_id = $receiptId;
        $income->income_no = $incomeNo;
        $income->summery = $summery;
        $income->amount = $amount;
        $income->trade_date = $tradeDate;
        $income->settle_date = $settleDate;
        $income->record_regist_tsp = Carbon::now();
        $income->save();
        
        // 受払を登録
        $tran = new Tran();
        $tran->income_id = $income->id;
        $tran->wallet_id = $receipt->wallet_id;
        $tran->account_list_id = $accountId;
        $tran->amount = $amount;
        $tran->up_down = $amount;
        $tran->settle_date = $settleDate;
        $tran->save();
        
        // 残高を更新
        $balance = Balance::where('wallet_id', $receipt->wallet_id)->first();
        if(!isset($balance)) {
            $balance = new Balance();
            $balance->wallet_id = $receipt->wallet_id;
            $balance->balance = $amount;
            $balance->update_tsp = Carbon::now();
            $balance->sys_deleted_flag = false;
        } else {
            $balance->balance = $balance->balance + $amount;
            $balance->update_tsp = Carbon::now();
        }
        $balance->save();
    }
    
    
// 	public function store($data)
// 	{
// 		$incomeNo = DateNumbering::getSingleDateNumber("0001", Carbon::today());
// 		$amount = str_replace(" 円", "", str_replace(",", "", $data->amount));
// 		$tradeDate = Carbon::createFromFormat('Y年m月d日', $data->tradeDate);
// 		$settleDate = Carbon::createFromFormat('Y年m月d日', $data->settleDate);
		
		
// 		// 収入エンティティに登録
// 		$income = new Income();
// 		$income->account_id = $data->accountId;
// 		$income->receipt_id = $data->receiptId;
// 		$income->income_no = $incomeNo;
// 		$income->summery = $data->summery;
// 		$income->amount = $amount;
// 		$income->trade_date = $tradeDate;
// 		$income->settle_date = $settleDate;
// 		$income->record_regist_tsp = Carbon::now();
// 		$income->save();
		
// 		$receipt = Receipt::find($data->receiptId);
		
// 		$tran = new Tran();
// 		$tran->income_id = $income->id;
// 		$tran->wallet_id = $receipt->wallet_id;
// 		$tran->account_list_id = $data->accountId;
// 		$tran->amount = $amount;
// 		$tran->up_down = $amount;
// 		$tran->settle_date = $settleDate;
// 		$tran->save();
		
		
// 		$balance = Balance::where('wallet_id', $receipt->wallet_id)->first();
// 		if(!isset($balance)) {
// 			$balance = new Balance();
// 			$balance->wallet_id = $receipt->wallet_id;
// 			$balance->balance = $amount;
// 			$balance->update_tsp = Carbon::now();
// 			$balance->sys_deleted_flag = false;
// 		} else {
// 			$balance->balance = $balance->balance + $amount;
// 			$balance->update_tsp = Carbon::now();
// 		}
// 		$balance->save();
// 	}
}