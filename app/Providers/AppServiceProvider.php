<?php

namespace HomeMoney\Providers;

use Illuminate\Support\ServiceProvider;
use HomeMoney\Services\AccountService;
use HomeMoney\Services\AccountServiceInterface;
use HomeMoney\Services\IncomeService;
use HomeMoney\Services\IncomeServiceInterface;
use HomeMoney\Services\OutgoingService;
use HomeMoney\Services\OutgoingServiceInterface;
use HomeMoney\Services\MoveService;
use HomeMoney\Services\MoveServiceInterface;

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
    	$this->app->singleton(OutgoingServiceInterface::class, OutgoingService::class);
    	$this->app->singleton(MoveServiceInterface::class, MoveService::class);
    }
}
