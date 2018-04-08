<?php

use Illuminate\Database\Seeder;
use HomeMoney\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::select('select setval(\'wallets_id_seq\', 1, false)');
    	$this->save('財布');
    	$this->save('みずほ銀行');
        $this->save('UFJ銀行');
        $this->save('QUOカード');
        $this->save('楽天Edy');
        $this->save('nanaco');
    }
        
    private function save($name)
    {
    	$wallet = new Wallet();
    	$wallet->name = $name;
    	$wallet->saveDefault();
    }
}
