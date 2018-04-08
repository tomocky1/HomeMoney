<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Wallet extends Model
{
	protected $table = 'wallets';
	
	const CREATED_AT = 'sys_created_at';
	
	const UPDATED_AT = 'sys_updated_at';
	
	protected $dates = ['deleted_at'];
	
	public function saveDefault()
	{
		$this->enable_flag = true;
		$this->sys_deleted_flag = false;
		$this->save();
		
	}
	
	public function deleteDefault()
	{
		$this->sys_deleted_flag = true;
		$this->sys_deleted_at = Carbon::now();
		$this->save();
	}
	
	public static function getIdByName($name)
	{
		return Wallet::where('name', $name)->first()->id;
	}
}
