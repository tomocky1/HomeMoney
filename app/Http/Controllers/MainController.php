<?php

namespace HomeMoney\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function top()
    {
    	return view('top');
    }
}
