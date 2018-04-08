<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
	/** 実テーブル名 */
	protected $table = 'incomes';
	
	/** 作成日時 */
	const CREATED_AT = 'sys_created_at';
	
	/** 更新日時 */
	const UPDATED_AT = 'sys_updated_at';
	
	/** 削除日時 */
	protected $dates = ['trade_date', 'settle_date', 'deleted_at'];
	
	/**
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function receipt()
	{
		return $this->belongsTo('HomeMoney\Models\Receipt', 'receipt_id', 'id');
	}
	
	public function account()
	{
		return $this->belongsTo('HomeMoney\Models\Account', 'account_id', 'id');
	}
}
