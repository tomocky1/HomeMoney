<?php

namespace Tests\Unit\Http\Controllers\IncomeControllerTest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HomeMoney\Http\Controllers\IncomeController;
use HomeMoney\Http\Requests\IncomeStoreRequest;

class IncomeControllerTest extends TestCase
{
	use RefreshDatabase;
	
	public function testStore()
	{
		$controller = new IncomeController();
		
		$request = new IncomeStoreRequest();
		$request->accountId = 1;
		$request->receiptId = 1;
		$request->summery = "テスト摘要";
		$request->amount = 5000;
		$request->tradeDate = "2019年1月1日";
		$request->settleDate = "2019年1月1日";
		
		$controller->store($request);
		
	}
}