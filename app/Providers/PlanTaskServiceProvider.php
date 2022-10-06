<?php

namespace App\Providers;

use App\Services\PlanTask\Contracts\PlanTaskRepositoryContract;
use App\Services\PlanTask\Contracts\PlanTaskServiceContract;
use App\Services\PlanTask\PlanTaskService;
use App\Services\PlanTask\Repositories\PlanTaskRepository;
use Illuminate\Support\ServiceProvider;

class PlanTaskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlanTaskRepositoryContract::class, PlanTaskRepository::class);
        $this->app->singleton(PlanTaskServiceContract::class, PlanTaskService::class);
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
