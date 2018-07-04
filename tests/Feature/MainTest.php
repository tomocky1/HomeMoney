<?php

namespace Tests\Feature;


use Tests\TestCase;

class MainTest extends TestCase
{
	/**
	 * MainControllerのテスト
	 */
	public function testTop()
	{
		$response = $this->get('/login');
		
		$response->assertStatus(200);
	}
}