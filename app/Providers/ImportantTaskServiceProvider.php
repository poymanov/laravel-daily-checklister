<?php

namespace App\Providers;

use App\Services\ImportantTask\Contracts\ImportantTaskRepositoryContract;
use App\Services\ImportantTask\Contracts\ImportantTaskServiceContract;
use App\Services\ImportantTask\ImportantTaskService;
use App\Services\ImportantTask\Repositories\ImportantTaskRepository;
use Illuminate\Support\ServiceProvider;

class ImportantTaskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImportantTaskRepositoryContract::class, ImportantTaskRepository::class);
        $this->app->singleton(ImportantTaskServiceContract::class, ImportantTaskService::class);
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
