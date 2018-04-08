<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;

class OutGoing extends Model
{
	/** 実テーブル名 */
	protected $table = 'outgoings';
	
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
	public function payment()
	{
		return $this->belongsTo('HomeMoney\Models\Payment', 'payment_id', 'id');
	}
	
	public function account()
	{
		return $this->belongsTo('HomeMoney\Models\Account', 'account_id', 'id');
	}
}
