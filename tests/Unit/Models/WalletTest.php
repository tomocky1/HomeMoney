<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HomeMoney\Models\Wallet;

class WalletTest extends TestCase
{
	
	use RefreshDatabase;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteDefault()
    {
    	$wallet = new Wallet();
    	$wallet->name = "hoge";
    	$wallet->saveDefault();
    	
    	$wallet->deleteDefault();
    	
    	
        $this->assertTrue(true);
    }
}
