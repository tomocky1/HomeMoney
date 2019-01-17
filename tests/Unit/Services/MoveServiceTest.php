<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HomeMoney\Services\MoveService;

class MoveServiceTest extends TestCase
{
   function testStore()
    {
    	$service = new MoveService();
    	$data = new class(){};
    	$data->srcWalletId = 1;
    	$data->distWalletId = 2;
    	$data->summery = "テスト摘要";
    	$data->amount = 3000;
    	$data->tradeDate = "2019年1月1日";
    	$data->settleDate = "2019年1月1日";
    	$service->store($data);
    	
    	$this->assertTrue(true);
    }
}
