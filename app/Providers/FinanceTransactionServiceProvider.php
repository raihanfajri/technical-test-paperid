<?php

namespace App\Providers;

use App\Models\FinanceTransaction;
use App\Repositories\Eloquent\FinanceTransactionRepository;
use App\Services\FinanceTransactionService;
use Illuminate\Support\ServiceProvider;

class FinanceTransactionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\FinanceTransactionRepositoryInterface', function ($app) {
            return new FinanceTransactionRepository(new FinanceTransaction());
        });

        $this->app->bind('FinanceTransactionService', function ($app) {
            return new FinanceTransactionService(
                $app->make('App\Repositories\FinanceTransactionRepositoryInterface'),
                $app->make('App\Services\FinanceAccountService')
            );
        });
    }
}
