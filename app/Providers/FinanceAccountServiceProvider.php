<?php

namespace App\Providers;

use App\Models\FinanceAccount;
use App\Repositories\Eloquent\FinanceAccountRepository;
use App\Services\FinanceAccountService;
use Illuminate\Support\ServiceProvider;

class FinanceAccountServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\FinanceAccountRepositoryInterface', function ($app) {
            return new FinanceAccountRepository(new FinanceAccount());
        });

        $this->app->bind('FinanceAccountService', function ($app) {
            return new FinanceAccountService(
                $app->make('App\Repositories\FinanceAccountRepositoryInterface')
            );
        });
    }
}
