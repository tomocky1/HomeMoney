<?php

namespace HomeMoney\Models;

use Illuminate\Database\Eloquent\Model;

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
	
	public static function getSingleDateNumber($class, $date)
	{
		\DB::beginTransaction();
		try {
			// 該当レコードを悲観ロック
			$dateNumbering = self::where('cls', $class)->where('ymd', $date)->lockForUpdate()->first();
			if($dateNumbering == null)
			{
				$dateNumbering = new DateNumbering();
				$dateNumbering->cls = $class;
				$dateNumbering->ymd = $date;
				$dateNumbering->val = 1;
				$dateNumbering->sys_deleted_flag = false;
				$dateNumbering->save();
			} else {
				$dateNumbering->val = $dateNumbering->val + 1;
				$dateNumbering->save();
			}
			\DB::commit();
			return $dateNumbering->val;
		} catch (\Exception $e) {
			\DB::rollback();
			throw $e;
		}
	}
	
}
