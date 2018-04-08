<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use HomeMoney\Models\DateNumbering;
use Carbon\Carbon;

class DateNumberingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
    	$_class = "0001";
    	$_date = Carbon::now();
    	
    	DateNumbering::where('sys_deleted_flag', false)->orWhere('sys_deleted_flag', true)->delete();
    	
    	$r = DateNumbering::getSingleDateNumber($_class, $_date);
        $this->assertEquals(1, $r);
        
        $r = DateNumbering::getSingleDateNumber($_class, $_date);
        $this->assertEquals(2, $r);
    }
}
