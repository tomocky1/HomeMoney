<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use HomeMoney\Services\IncomeService;
use HomeMoney\Services\IncomeServiceInterface;
use PHPExcelDB\PHPExcelDB;
use PDO;

class IncomeServiceTest extends TestCase
{
    private $service;
    
//     public function testAsertTrue()
//     {
//         $this->expectOutputString('foo');
//         print('hoge');
//         print(env('DB_DATABASE'));
//         $this->assertTrue(true);
//     }
	
	public function testStore()
	{
	    $dsn = env('DB_CONNECTION').":dbname=".env('DB_DATABASE').";host=".env('DB_HOST').";";
	    $pdo = new PDO($dsn, env('DB_USERNAME'), env('DB_PASSWORD'));
	    $phpexceldb = new PHPExcelDB($pdo);
	    
	    $phpexceldb->importDBFromExcel('master.xlsx');
	    
	    
	    $accountId = 1;
	    $receiptId = 1;
	    $summery = "摘要";
	    $amount = 100;
	    $tradeDate = Carbon::createFromFormat('Y-m-d', "2019-8-4");
	    $settleDate = Carbon::createFromFormat('Y-m-d', "2019-8-4");
	    
		$service = app(IncomeServiceInterface::class);
		$service->store($accountId, $receiptId, $summery, $amount, $tradeDate, $settleDate);
		
		$this->assertTrue(true);
	}
	
	
}

class Data { }