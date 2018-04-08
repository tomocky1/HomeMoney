<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
	/** 実テーブル名 */
	protected $table = 'accounts';
	
	/** 作成日時 */
	const CREATED_AT = 'sys_created_at';
	
	/** 更新日時 */
	const UPDATED_AT = 'sys_updated_at';
	
	/** 削除日時 */
	protected $dates = ['deleted_at'];
	
	public static function getIdByName($name)
	{
		return self::where('name', $name)->first()->id;
	}
	
	/**
	 * 基本的な保存メソッド
	 */
	public function saveDefault()
	{
		$this->enable_flag = true;
		$this->sys_deleted_flag = false;
		$this->save();
	}
}
