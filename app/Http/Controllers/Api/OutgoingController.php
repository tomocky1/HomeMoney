<?php

namespace HomeMoney\Http\Controllers\Api;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Http\Requests\Api\OutgoingStoreRequest;
use HomeMoney\Models\OutGoing;
use Carbon\Carbon;
use HomeMoney\Models\DateNumbering;

class OutgoingController extends Controller
{
	/**
	 * 支出を登録する
	 * @param OutGoingStoreRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(OutgoingStoreRequest $request)
	{
		$outgoing = new OutGoing();
		$outgoing->account_id = $request->accountId;
		$outgoing->payment_id = $request->paymentId;
		$outgoing->outgoing_no = DateNumbering::getSingleDateNumber("0002", Carbon::createFromFormat('Y-m-d', $request->tradeDate));
		$outgoing->summery = $request->summery;
		$outgoing->amount = str_replace(" 円", "", str_replace(",", "", $request->amount));
		$outgoing->trade_date = Carbon::createFromFormat('Y-m-d', $request->tradeDate);
		$outgoing->settle_date = Carbon::createFromFormat('Y-m-d', $request->settleDate);
		$outgoing->regist_tsp = Carbon::now();
		$outgoing->modify_flag = false;
		$outgoing->delete_flag = false;
		$outgoing->sys_deleted_flag = false;
		$outgoing->save();
	
		return response()->json(["result" => "success"]);
	}
}
