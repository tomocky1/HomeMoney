<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DateNumbering extends Model
{
	/** 実テーブル名 */
	protected $table = 'date_numbering';
	
	/** 作成日時 */
	const CREATED_AT = 'sys_created_at';
	
	/** 更新日時 */
	const UPDATED_AT = 'sys_updated_at';
	
	/** 削除日時 */
	protected $dates = ['deleted_at'];
	
	public static function getSingleDateNumber(String $class, Carbon $date)
	{
		\DB::beginTransaction();
		try {
			// 該当レコードを悲観ロック
			$dateNumbering = self::where('clazz', $class)->where('ymd', $date)->lockForUpdate()->first();
			if($dateNumbering == null)
			{
				$dateNumbering = new DateNumbering();
				$dateNumbering->clazz = $class;
				$dateNumbering->ymd = $date;
				$dateNumbering->val = 1;
				$dateNumbering->sys_deleted_flag = false;
				$dateNumbering->save();
			} else {
				$dateNumbering->val = $dateNumbering->val + 1;
				$dateNumbering->save();
			}
			\DB::commit();
			
			if($class == '0001') {
				$result = $date->format('ymd') . sprintf('%05d', $dateNumbering->val);
			} else if($class == '0002') {
				$result = $date->format('ymd') . sprintf('%05d', $dateNumbering->val);
			}
			return $result;
		} catch (\Exception $e) {
			\DB::rollback();
			throw $e;
		}
	}
	
}
