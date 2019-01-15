<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
	/** 実テーブル名 */
	protected $table = 'balances';
	
	/** 作成日時 */
	const CREATED_AT = 'sys_created_at';
	
	/** 更新日時 */
	const UPDATED_AT = 'sys_updated_at';
	
	/** 削除日時 */
	protected $dates = ['trade_date', 'settle_date', 'deleted_at'];
	
	/**
	 * 財布エンティティ
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function wallet()
	{
		return $this->belongsTo("'HomeMoney\Models\Wallet", 'wallet_id', 'id');
	}
	
}