<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    public function top()
    {
    	return view('top');
    }
}
