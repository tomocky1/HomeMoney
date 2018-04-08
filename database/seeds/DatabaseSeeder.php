<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use HomeMoney\Models\Account;
use HomeMoney\Models\Payment;
use HomeMoney\Models\Wallet;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();
    	
    	Account::where('id', '>', 0)->delete();
    	Payment::where('id', '>', 0)->delete();
    	Wallet::where('id', '>', 0)->delete();
    	
//     	DB::table('accounts')->truncate();
//     	DB::table('payments')->truncate();
//     	DB::table('wallets')->truncate();
    	
        $this->call(WalletTableSeeder::class);
        $this->call(PaymentTableSeeder::class);
        $this->call(AccountTableSeeder::class);
        Model::reguard();
    }
}
