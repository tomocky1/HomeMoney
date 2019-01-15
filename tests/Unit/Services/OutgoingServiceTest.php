<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HomeMoney\Services\OutgoingService;

class OutgoingServiceTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $service = new OutgoingService();
        $data = new class(){};
        $data->accountId = 1;
        $data->paymentId = 1;
        $data->summery = "テスト摘要";
        $data->amount = 3000;
        $data->tradeDate = "2019年1月1日";
        $data->settleDate = "2019年1月1日";
        $service->store($data);
        
        $this->assertTrue(true);
    }
}

