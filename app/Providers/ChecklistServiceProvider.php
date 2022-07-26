<?php

namespace App\Providers;

use App\Services\Checklist\ChecklistService;
use App\Services\Checklist\Contracts\ChecklistRepositoryContract;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Checklist\Repositories\ChecklistRepository;
use Illuminate\Support\ServiceProvider;

class ChecklistServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ChecklistRepositoryContract::class, ChecklistRepository::class);
        $this->app->singleton(ChecklistServiceContract::class, ChecklistService::class);
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
