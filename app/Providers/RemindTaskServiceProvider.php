<?php

namespace App\Providers;

use App\Services\RemindTask\Contracts\RemindTaskRepositoryContract;
use App\Services\RemindTask\Contracts\RemindTaskServiceContract;
use App\Services\RemindTask\RemindTaskService;
use App\Services\RemindTask\Repositories\RemindTaskRepository;
use Illuminate\Support\ServiceProvider;

class RemindTaskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RemindTaskRepositoryContract::class, RemindTaskRepository::class);
        $this->app->singleton(RemindTaskServiceContract::class, RemindTaskService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
