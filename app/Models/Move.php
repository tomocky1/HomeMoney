<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
	/** 実テーブル名 */
	protected $table = 'moves';
	
	/** 作成日時 */
	const CREATED_AT = 'sys_created_at';
	
	/** 更新日時 */
	const UPDATED_AT = 'sys_updated_at';
	
	/** 削除日時 */
	protected $dates = ['trade_date', 'settle_date', 'deleted_at'];
	

	/** 移動元財布 */
	public function srcWallet()
	{
		return $this->belongsTo('HomeMoney\Models\Wallet', 'src_wallet_id', 'id');
	}
	
	/** 移動先財布 */
	public function distWallet()
	{
		return $this->belongsTo('HomeMoney\Models\Wallet', 'dist_wallet_id', 'id');
	}
}
