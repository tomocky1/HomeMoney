<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;

class Tran extends Model
{
	/** 実テーブル名 */
	protected $table = 'accounts';
	
	/** 作成日時 */
	const CREATED_AT = 'sys_created_at';
	
	/** 更新日時 */
	const UPDATED_AT = 'sys_updated_at';
	
	/** 削除日時 */
	protected $dates = ['deleted_at'];
	
	/**
	 * 基本的な保存メソッド
	 */
	public function saveDefault()
	{
		$this->sys_deleted_flag = false;
		$this->save();
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function payment()
	{
		return $this->hasOne('HomeMoney\Models\Payment', 'id', 'payment_id');
	}
}
