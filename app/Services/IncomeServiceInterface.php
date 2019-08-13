<?php

namespace HomeMoney\Services;

Interface IncomeServiceInterface
{
    public function store($accountId, $receiptId, $summery, $amount, $tradeDate, $settleDate);
}