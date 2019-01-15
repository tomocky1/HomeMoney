<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;

class Tran extends Model
{
	/** 実テーブル名 */
	protected $table = 'trans';
	
	/** 作成日時 */
	const CREATED_AT = 'sys_created_at';
	
	/** 更新日時 */
	const UPDATED_AT = 'sys_updated_at';
	
	/** 削除日時 */
	protected $dates = ['deleted_at'];
	

}
