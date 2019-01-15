<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HomeMoney\Services\IncomeService;
use HomeMoney\Services\IncomeServiceInterface;

class IncomeServiceTest extends TestCase
{

	
	public function testStore()
	{
		$service = new IncomeService();
		$data = new Data();
		$data->accountId = 1;
		$data->receiptId = 1;
		$data->summery = "テスト摘要";
		$data->amount = 3000;
		$data->tradeDate = "2019年1月1日";
		$data->settleDate = "2019年1月1日";
		$service->store($data);
	}
	
	
}

class Data { }