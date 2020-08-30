<?php

namespace App\Providers;

use App\Models\TokenWhitelist;
use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Repositories\Eloquent\UserRepository;
use App\Models\User;
use App\Repositories\Eloquent\TokenWhitelistRepository;

class UserServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\UserRepositoryInterface', function ($app) {
            return new UserRepository(new User());
        });

        $this->app->bind('App\Repositories\TokenWhitelistRepositoryInterface', function ($app) {
            return new TokenWhitelistRepository(new TokenWhitelist());
        });

        $this->app->bind('UserService', function ($app) {
            return new UserService(
                // Injecting user dependency
                $app->make('App\Repositories\UserRepositoryInterface'),
                $app->make('App\Repositories\TokenWhitelistRepositoryInterface')
            );
        });
    }
}
