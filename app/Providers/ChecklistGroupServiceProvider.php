<?php

namespace App\Providers;

use App\Services\ChecklistGroup\ChecklistGroupService;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupRepositoryContract;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;
use App\Services\ChecklistGroup\Repositories\ChecklistGroupRepository;
use Illuminate\Support\ServiceProvider;

class ChecklistGroupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ChecklistGroupRepositoryContract::class, ChecklistGroupRepository::class);
        $this->app->singleton(ChecklistGroupServiceContract::class, ChecklistGroupService::class);
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
