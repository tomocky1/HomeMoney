<?php

use Illuminate\Database\Seeder;
use HomeMoney\Models\Wallet;
use HomeMoney\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::select('select setval(\'payments_id_seq\', 1, false)');
    	$this->save('財布', '財布');
    	$this->save('みずほ銀行', 'みずほ銀行');
    	$this->save('UFJ銀行', 'UFJ銀行');
    	$this->save('QUOカード', 'QUOカード');
    	$this->save('楽天Edy', '楽天Edy');
    	$this->save('nanaco', 'nanaco');
    	$this->save('セゾンクレジット', 'みずほ銀行');
    	$this->save('楽天カード', 'みずほ銀行');
    }
    
    private function save($name, $wallet_name)
    {
    	$payment = new Payment();
    	$payment->payment_name = $name;
    	$payment->wallet_id = Wallet::where('name', '財布')->first()->id;
    	$payment->saveDefault();
    }
}
