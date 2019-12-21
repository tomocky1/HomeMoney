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
    public function store(int $accountId, int $receiptId, String $summery, int $amount, Carbon $tradeDate, Carbon $settleDate) {
        
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
        $income->regist_tsp = Carbon::now();
        $income->delete_flag = false;
        $income->modify_flag = false;
        $income->id_bfr = null;
        $income->updated_flag = "0";
        $income->active_flag = true;
        $income->sys_deleted_flag = false;
        $income->version = 1;
        $income->save();
        
        // 受払を登録
        $tran = new Tran();
        $tran->income_id = $income->id;
        $tran->wallet_id = $receipt->wallet_id;
        $tran->account_id = $accountId;
        $tran->amount = $amount;
        $tran->up_down = $amount;
        $tran->settle_date = $settleDate;
        $tran->sys_deleted_flag = false;
        $tran->version = 1;
        $tran->save();
        
        // 残高を更新
        $balance = Balance::where('wallet_id', $receipt->wallet_id)->first();
        if(!isset($balance)) {
            $balance = new Balance();
            $balance->wallet_id = $receipt->wallet_id;
            $balance->balance = $amount;
            $balance->update_tsp = Carbon::now();
            $balance->sys_deleted_flag = false;
            $balance->version = 1;
        } else {
            $balance->balance = $balance->balance + $amount;
            $balance->update_tsp = Carbon::now();
            $balance->version = $balance->version + 1;
        }
        $balance->save();
    }
    
    /**
     * Incomeテーブルに対して共有ロックをかける．引数で
     * @param array $ids
     */
    public function sharedLock(array $ids) {
        sort($ids);
        foreach($ids as $id) {
            Income::where('id', $id)->sharedLock()->get();
        }
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