<?php

namespace App\Providers;

use App\Services\ChecklistGroup\ChecklistGroupService;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupRepositoryContract;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;
use App\Services\ChecklistGroup\Repositories\ChecklistGroupRepository;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);

        $this->app->bind(ChecklistGroupRepositoryContract::class, ChecklistGroupRepository::class);
        $this->app->bind(ChecklistGroupServiceContract::class, ChecklistGroupService::class);
    }
}
