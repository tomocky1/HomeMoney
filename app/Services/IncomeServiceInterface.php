<?php

namespace HomeMoney\Services;

use Carbon\Carbon;

Interface IncomeServiceInterface
{
    public function store(int $accountId, int $receiptId, String $summery, int $amount, Carbon $tradeDate, Carbon $settleDate);
    
    public function sharedLock(array $ids);
}