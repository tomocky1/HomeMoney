<?php

namespace HomeMoney\Providers;

use Illuminate\Support\ServiceProvider;
use HomeMoney\Services\AccountService;
use HomeMoney\Services\AccountServiceInterface;
use HomeMoney\Services\IncomeService;
use HomeMoney\Services\IncomeServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->app->singleton(AccountServiceInterface::class, AccountService::class);
    	$this->app->singleton(IncomeServiceInterface::class, IncomeService::class);
    }
}
