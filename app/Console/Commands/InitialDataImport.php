<?php

namespace HomeMoney\Console\Commands;

use Illuminate\Console\Command;
use HomeMoney\Models\Wallet;
use HomeMoney\Models\Payment;

class InitialDataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:InitialDataImport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初期データを登録する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	Wallet::where('enable_flag', true)->orWhere('enable_flag', false)->delete();
    	InitialDataImport::saveWallet("財布", 10);
    	InitialDataImport::saveWallet("nanaco", 20);
    	InitialDataImport::saveWallet("Pasmo", 30);
    	InitialDataImport::saveWallet("クオカード", 30);
    	InitialDataImport::saveWallet("UFJ銀行-普通口座", 40);
    	InitialDataImport::saveWallet("UFJ銀行-火災・地震保険", 42);
    	InitialDataImport::saveWallet("UFJ銀行-楽斗教育費", 44);
    	InitialDataImport::saveWallet("UFJ銀行-笑奈教育費", 46);
    	InitialDataImport::saveWallet("みずほ銀行", 50);
    	InitialDataImport::saveWallet("住信SBI-代表口座", 60);
    	InitialDataImport::saveWallet("住信SBI-表札代", 62);
    	InitialDataImport::saveWallet("住信SBI-税金貯金", 64);
    	InitialDataImport::saveWallet("住信SBI-固定資産税", 66);
    	InitialDataImport::saveWallet("住信SBI-その他貯蓄", 67);
    	InitialDataImport::saveWallet("新生銀行", 70);
    	InitialDataImport::saveWallet("じぶん銀行", 75);
    	InitialDataImport::saveWallet("三井住友銀行", 80);
    	InitialDataImport::saveWallet("ゆうちょ銀行", 80);
    	 
    	Payment::where('enable_flag', true)->orWhere('enable_flag', false)->delete();
    	InitialDataImport::savePayment("現金（財布）", "財布", 10);
        
    }
        
    private static function saveWallet($name, $dorder)
    {
    	$wallet = new Wallet();
    	$wallet->name = $name;
    	$wallet->dorder = $dorder;
    	$wallet->enable_flag = true;
    	$wallet->save();
    }
    
    private static function savePayment($name, $walletName, $dorder)
    {
    	$payment = new Payment();
    	$payment->name = $name;
    	$payment->wallet_id = Wallet::getIdByName($walletName);
    	$payment->dorder = $dorder;
    	$payment->enable_flag = true;
    	$payment->save();
    }
}
