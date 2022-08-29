<?php

namespace App\Providers;

use App\Services\DayTask\Contracts\DayTaskRepositoryContract;
use App\Services\DayTask\Contracts\DayTaskServiceContract;
use App\Services\DayTask\DayTaskService;
use App\Services\DayTask\Repositories\DayTaskRepository;
use Illuminate\Support\ServiceProvider;

class DayTaskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DayTaskRepositoryContract::class, DayTaskRepository::class);
        $this->app->singleton(DayTaskServiceContract::class, DayTaskService::class);
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
