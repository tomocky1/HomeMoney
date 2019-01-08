<?php

namespace Tests\Feature\Controllers\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestOutgoingController extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
    	$header = [
    			'Content-Type' => 'application/x-www-form-urlencoded',
    			'authorization' => 'Basic c2lva29idTg0MDBAZ21haWwuY29tOnNpb2tvYnU4NDAw', // siokobu8400@gmail.com:siokobu8400
    	];
    	 
    	$data = [
    			'summery' => 'テスト送信１',
    			'amount' => '3000',
    			'accountId' => '1',
    			'paymentId' => '1',
    			'tradeDate' => '2018-08-09',
    			'settleDate' => '2018-08-09',
    	];
    	 
    	$response = $this
    	->withHeaders($header)
    	->json('POST', '/api/OutGoing/store', $data);
    	 
    	$response
    	->assertStatus(200)
    	->assertJson(['result' => 'success']);
    }
}
