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
	public function store($data)
	{
		$incomeNo = DateNumbering::getSingleDateNumber("0001", Carbon::today());
		$amount = str_replace(" 円", "", str_replace(",", "", $data->amount));
		$tradeDate = Carbon::createFromFormat('Y年m月d日', $data->tradeDate);
		$settleDate = Carbon::createFromFormat('Y年m月d日', $data->settleDate);
		
		
		// 収入エンティティに登録
		$income = new Income();
		$income->account_id = $data->accountId;
		$income->receipt_id = $data->receiptId;
		$income->income_no = $incomeNo;
		$income->summery = $data->summery;
		$income->amount = $amount;
		$income->trade_date = $tradeDate;
		$income->settle_date = $settleDate;
		$income->regist_tsp = Carbon::now();
		$income->modify_flag = false;
		$income->delete_flag = false;
		$income->sys_deleted_flag = false;
		$income->save();
		
		$receipt = Receipt::find($data->receiptId);
		
		$tran = new Tran();
		$tran->income_id = $income->id;
		$tran->mod_del_flg = false;
		$tran->wallet_id = $receipt->wallet_id;
		$tran->account_list_id = $data->accountId;
		$tran->summery = $data->summery;
		$tran->amount = $amount;
		$tran->up_down = $amount;
		$tran->settle_date = $settleDate;
		$tran->sys_deleted_flag = false;
		$tran->save();
		
		
		$balance = Balance::where('wallet_id', $receipt->wallet_id)->first();
		if(!isset($balance)) {
			$balance = new Balance();
			$balance->wallet_id = $receipt->wallet_id;
			$balance->balance = $amount;
			$balance->sys_deleted_flag = false;
		} else {
			$balance->balance = $balance->balance + $amount;
		}
		$balance->save();
	}
}