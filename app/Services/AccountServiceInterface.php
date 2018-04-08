<?php

namespace HomeMoney\Services;

Interface AccountServiceInterface
{
	public function index($page);
	
	public function store($data);
}