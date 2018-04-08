<?php

use Illuminate\Database\Seeder;
use HomeMoney\Models\Account;
use Illuminate\Support\Facades\DB;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::select('select setval(\'accounts_id_seq\', 1, false)');
    	$this->save('1', '2017/10/01', null, false, "食費", false, 100);
    	$this->save('1', '2017/10/01', null, false, "おこづかい", true, 200);
    	 
    }
    
    private function save($payment_id, $exe_date, $settle_date, $settle_flag, $summery, $in_out, $amount)
    {
    	$account = new Account();
    	$account->payment_id = $payment_id;
    	$account->exe_date = $exe_date;
    	$account->settle_date = $settle_date;
    	$account->settle_flag = $settle_flag;
    	$account->summery = $summery;
    	$account->in_out = $in_out;
    	$account->amount = $amount;
    	if($in_out) { $account->up_down = $amount; } else { $account->up_down = (-1) * $amount; }
    	$account->saveDefault();
    }
}