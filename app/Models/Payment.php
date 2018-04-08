<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
	protected $table = 'payments';
	
	const CREATED_AT = 'sys_created_at';
	
	const UPDATED_AT = 'sys_updated_at';
	
	protected $dates = ['deleted_at'];
	
	public function saveDefault()
	{
		$this->enable_flag = true;
		$this->sys_deleted_flag = false;
		$this->save();
	}
	
	public function wallet()
	{
		return $this->hasOne('HomeMoney\Models\Wallet', 'id', 'wallet_id');
	}
	
	public static function findWithWallet()
	{
		return Payment::where('enable_flag', true)->where('sys_deleted_flag', false)->get()->hasOne('HomeMoney\Models\Wallet', 'wallet_id', 'id');
	}
	
	public function deleteDefault()
	{
		$this->sys_deleted_flag = true;
		$this->sys_deleted_at = Carbon::now();
		$this->save();
	}
}
