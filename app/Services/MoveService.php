<?php

namespace HomeMoney\Services;

use HomeMoney\Models\Wallet;
use Carbon\Carbon;
use HomeMoney\Models\DateNumbering;
use HomeMoney\Models\Move;
use HomeMoney\Models\Tran;
use HomeMoney\Models\Balance;

class MoveService implements MoveServiceInterface
{

	/**
	 * {@inheritDoc}
	 * @see \HomeMoney\Services\MoveServiceInterface::index()
	 */
	public function index($data)
	{
		// 画面表示用変数を初期化
		$ret = array();
		
		// 一覧表示用の収入を取得
		$builder = Move::where('delete_flag', false);
		
		// 日付の範囲が指定された板場合
		if(isset($data->tradeDateRange)) {
			$tradeDateFrom = Carbon::createFromFormat('Y年m月d日', explode(" - ", $data->tradeDateRange)[0]);
			$tradeDateTo = Carbon::createFromFormat('Y年m月d日', explode(" - ", $data->tradeDateRange)[1]);
			$builder->where('trade_date', '>=', $tradeDateFrom);
			$builder->where('trade_date', '<=', $tradeDateTo);
		}
		
		// 移動元財布が指定された場合
		if(isset($data->srcWalletId)) {
			$builder->where('src_wallet_id', $data->srcWalletId);
		}
		
		// 移動先財布が指定された場合
		if(isset($data->distWalletId)) {
			$builder->where('dist_wallet_id', $data->distWalletId);
		}
		
		// 検索結果を取得
		$ret['moves'] = $builder->orderBy('trade_date', 'desc')->get();
		
		// 検索条件用財布一覧を設定
		$ret['wallets'] = Wallet::where('enable_flag', true)->where('sys_deleted_flag', false)->orderBy('dorder', 'asc')->get();
		
		// 取引日検索範囲を設定
		$ret['startDate'] = isset($tradeDateFrom) ? $tradeDateFrom : Carbon::now()->addMonths(-1)->format('Y-m-d');
		$ret['endDate'] = isset($tradeDateTo) ? $tradeDateTo : Carbon::now()->format('Y-m-d');
		
		return $ret;
	}
	
	public function create()
	{
		$data = array();
		$data['wallets'] = Wallet::where('enable_flag', true)->orderBy('dorder', 'desc')->get();
		$data['today'] = Carbon::now()->format('Y年m月d日');
		
		return $data;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \HomeMoney\Services\MoveServiceInterface::store()
	 */
	public function store($data)
	{
		$moveNo = DateNumbering::getSingleDateNumber("0003", Carbon::today());
		$amount = str_replace(" 円", "", str_replace(",", "", $data->amount));
		$tradeDate = Carbon::createFromFormat('Y年m月d日', $data->tradeDate);
		$settleDate = Carbon::createFromFormat('Y年m月d日', $data->settleDate);
		
		// 移動エンティティに登録
		$move = new Move();
		$move->src_wallet_id = $data->srcWalletId;
		$move->dist_wallet_id = $data->distWalletId;
		$move->move_no = $moveNo;
		$move->summery = $data->summery;
		$move->amount = $amount;
		$move->trade_date = $tradeDate;
		$move->settle_date = $settleDate;
		$move->regist_tsp = Carbon::now();
		$move->modify_flag = false;
		$move->delete_flag = false;
		$move->sys_deleted_flag = false;
		$move->save();
		
		// 移動元受払を登録
		$stran = new Tran();
		$stran->move_id = $move->id;
		$stran->mod_del_flg = false;
		$stran->wallet_id = $data->srcWalletId;
		$stran->summery = $data->summery;
		$stran->amount = $amount;
		$stran->up_down = 0 - $amount;
		$stran->settle_date = $settleDate;
		$stran->sys_deleted_flag = false;
		$stran->save();
		
		// 移動元残高を登録
		$sbalance = Balance::where('wallet_id', $data->srcWalletId)->first();
		if(!isset($sbalance)) {
			$sbalance = new Balance();
			$sbalance->wallet_id = $data->srcWalletId;
			$sbalance->balance = 0 - $amount;
			$sbalance->update_tsp = Carbon::now();
			$sbalance->sys_deleted_flag = false;
		} else {
			$sbalance->balance = $sbalance->balance - $amount;
			$sbalance->update_tsp = Carbon::now();
		}
		$sbalance->save();
		
		// 移動先受払を登録
		$dtran = new Tran();
		$dtran->move_id = $move->id;
		$dtran->mod_del_flg = false;
		$dtran->wallet_id = $data->distWalletId;
		$dtran->summery = $data->summery;
		$dtran->amount = $amount;
		$dtran->up_down = $amount;
		$dtran->settle_date = $settleDate;
		$dtran->sys_deleted_flag = false;
		$dtran->save();
		
		// 移動先残高を登録
		$dbalance = Balance::where('wallet_id', $data->distWalletId)->first();
		if(!isset($dbalance)) {
			$dbalance = new Balance();
			$dbalance->wallet_id = $data->distWalletId;
			$dbalance->balance = $amount;
			$dbalance->update_tsp = Carbon::now();
			$dbalance->sys_deleted_flag = false;
		} else {
			$dbalance->balance = $dbalance->balance - $amount;
			$dbalance->update_tsp = Carbon::now();
		}
		$dbalance->save();
	}

}

