<?php

namespace HomeMoney\Http\Controllers\Api;

use Illuminate\Http\Request;
use HomeMoney\Http\Controllers\Controller;
use HomeMoney\Models\Payment;

class PaymentController extends Controller
{
    public function index() {
    	$payments = Payment::where('enable_flag', 1)->get(['id', 'wallet_id', 'name']);
    	return response()->json(["payments" => $payments]);
    }
}
