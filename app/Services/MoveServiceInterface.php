<?php

namespace HomeMoney\Services;

interface MoveServiceInterface
{
	public function index($data);
	
	public function create();
	
	/**
	 * 移動を登録するためのメソッド
	 * @param $data $srcWalletId(移動元財布ID)、$distWalletId(移動先財布ID)、$summery(摘要)、$amount(金額)、$tradeDate(取引日)、$settleDate(決済日)
	 */
	public function store($data);
}

