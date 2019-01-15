<?php

namespace HomeMoney\Services;

use Carbon\Carbon;
use HomeMoney\Models\DateNumbering;
use HomeMoney\Models\OutGoing;
use HomeMoney\Models\Tran;
use HomeMoney\Models\Balance;
use HomeMoney\Models\Payment;

class OutgoingService implements OutgoingServiceInterface
{
	/**
	 * 
	 * {@inheritDoc}
	 * @see \HomeMoney\Services\OutgoingServiceInterface::store()
	 */
	public function store($data)
	{
		$outgoingNo = DateNumbering::getSingleDateNumber("0002", Carbon::today());
		$amount = str_replace(" 円", "", str_replace(",", "", $data->amount));
		$tradeDate = Carbon::createFromFormat('Y年m月d日', $data->tradeDate);
		$settleDate = Carbon::createFromFormat('Y年m月d日', $data->settleDate);
		
		
		// 収入エンティティに登録
		$outgoing = new OutGoing();
		$outgoing->account_id = $data->accountId;
		$outgoing->payment_id = $data->paymentId;
		$outgoing->outgoing_no = $outgoingNo;
		$outgoing->summery = $data->summery;
		$outgoing->amount = $amount;
		$outgoing->trade_date = $tradeDate;
		$outgoing->settle_date = $settleDate;
		$outgoing->regist_tsp = Carbon::now();
		$outgoing->modify_flag = false;
		$outgoing->delete_flag = false;
		$outgoing->sys_deleted_flag = false;
		$outgoing->save();
		
		$receipt = Payment::find($data->paymentId);
		
		$tran = new Tran();
		$tran->outgoing_id = $outgoing->id;
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
			$balance->balance = $balance->balance - $amount;
		}
		$balance->save();
	}
}