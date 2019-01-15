<?php

namespace HomeMoney\Services;

Interface OutgoingServiceInterface
{
	/**
	 * 支出データを登録するメソッド。支出・受払・残高エンティティを更新する。
	 * @param $data $amount(合計金額)、$tradeDate(取引日)、$settleDate(決済日)、$accountId(勘定科目ID)、$paymentId(支払方法ID)、$summery(摘要) をプロパティとして持つオブジェクト
	 */
	public function store($data);
}