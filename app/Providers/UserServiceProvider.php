<?php

namespace App\Providers;

use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepositoryContract::class, UserRepository::class);
        $this->app->singleton(
            UserServiceContract::class,
            fn ($app) => new UserService($app->make(UserRepositoryContract::class), (int) config('pagination.admin_users'))
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
