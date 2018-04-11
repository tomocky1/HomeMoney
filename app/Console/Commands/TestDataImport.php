<?php

namespace HomeMoney\Console\Commands;

use Illuminate\Console\Command;
use HomeMoney\Models\Receipt;
use HomeMoney\Models\Wallet;
use HomeMoney\Models\Payment;
use HomeMoney\Models\Account;
use HomeMoney\Models\DateNumbering;
use Carbon\Carbon;
use HomeMoney\Models\Income;
use HomeMoney\Models\OutGoing;

class TestDataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TestDataImport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    	// 既存データの削除
    	OutGoing::where('delete_flag', true)->orWhere('delete_flag', false)->delete();
    	Income::where('delete_flag', true)->orWhere('delete_flag', false)->delete();
    	Account::where('enable_flag', true)->orWhere('enable_flag', false)->delete();
    	Payment::where('enable_flag', true)->orWhere('enable_flag', false)->delete();
    	Receipt::where('enable_flag', true)->orWhere('enable_flag', false)->delete();
    	Wallet::where('enable_flag', true)->orWhere('enable_flag', false)->delete();
    	 
    	// 財布
    	self::saveWallet("財布", 10);
    	self::saveWallet("nanaco", 20);
    	self::saveWallet("Pasmo", 30);
    	self::saveWallet("クオカード", 30);
    	self::saveWallet("UFJ銀行-普通口座", 40);
    	self::saveWallet("UFJ銀行-火災・地震保険", 42);
    	self::saveWallet("UFJ銀行-楽斗教育費", 44);
    	self::saveWallet("UFJ銀行-笑奈教育費", 46);
    	self::saveWallet("みずほ銀行", 50);
    	self::saveWallet("住信SBI-代表口座", 60);
    	self::saveWallet("住信SBI-表札代", 62);
    	self::saveWallet("住信SBI-税金貯金", 64);
    	self::saveWallet("住信SBI-固定資産税", 66);
    	self::saveWallet("住信SBI-その他貯蓄", 67);
    	self::saveWallet("新生銀行", 70);
    	self::saveWallet("じぶん銀行", 75);
    	self::saveWallet("三井住友銀行", 80);
    	self::saveWallet("ゆうちょ銀行", 80);
    
    	// 支払方法
    	self::savePayment("現金（財布）", "財布", 10);
    	self::savePayment("現金", "財布", 20);
    	 
    	// 受取方法
        self::saveReceipt("現金", "財布", 10);
        self::saveReceipt("銀行振込（SBI）", "住信SBI-代表口座", 20);
        
        // 勘定科目
        self::saveAccount("会議費", 10);
        self::saveAccount("雑費", 20);
        
        // 収入
        self::saveIncome("雑費", "現金", "食事", 5000, Carbon::now(), Carbon::now());
        
        // 支出
        self::saveOutGoing("雑費", "現金", "食事", 7000, Carbon::now(), Carbon::now());
    	
    
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
    
    private static function saveReceipt($name, $walletName, $dorder)
    {
    	$receipt = new Receipt();
    	$receipt->name = $name;
    	$receipt->wallet_id = Wallet::getIdByName($walletName);
    	$receipt->dorder = $dorder;
    	$receipt->enable_flag = true;
    	$receipt->save();
    }
    
    private static function saveAccount($name, $dorder)
    {
    	$account = new Account();
    	$account->name = $name;
    	$account->dorder = $dorder;
    	$account->enable_flag = true;
    	$account->save();
    }
    
    private static function saveIncome($accountName, $receiptName, $summery, $amount, $tradeDate, $settleDate)
    {
    	$income = new Income();
    	$income->account_id = Account::getIdByName($accountName);
    	$income->receipt_id = Receipt::getIdByName($receiptName);
    	$income->income_no = str_pad(DateNumbering::getSingleDateNumber("0001", Carbon::now()), 5, 0, STR_PAD_LEFT);
    	$income->summery = $summery;
    	$income->amount = $amount;
    	$income->trade_date = $tradeDate;
    	$income->settle_date = $settleDate;
    	$income->regist_tsp = Carbon::now();
    	$income->modify_flag = false;
    	$income->delete_flag = false;
    	$income->save();
    }
    
    private static function saveOutGoing($accountName, $paymentName, $summery, $amount, $tradeDate, $settleDate)
    {
    	$outGoing = new OutGoing();
    	$outGoing->account_id = Account::getIdByName($accountName);
    	$outGoing->payment_id = Payment::getIdByName($paymentName);
    	$outGoing->outgoing_no = str_pad(DateNumbering::getSingleDateNumber("0002", Carbon::now()), 5, 0, STR_PAD_LEFT);
    	$outGoing->summery = $summery;
    	$outGoing->amount = $amount;
    	$outGoing->trade_date = $tradeDate;
    	$outGoing->settle_date = $settleDate;
    	$outGoing->regist_tsp = Carbon::now();
    	$outGoing->modify_flag = false;
    	$outGoing->delete_flag = false;
    	$outGoing->save();
    }
    
    
    
}
