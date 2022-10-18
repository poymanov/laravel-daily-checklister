<?php

namespace App\Providers;

use App\Services\TaskNote\Contracts\TaskNoteRepositoryContract;
use App\Services\TaskNote\Contracts\TaskNoteServiceContract;
use App\Services\TaskNote\Repositories\TaskNoteRepository;
use App\Services\TaskNote\TaskNoteService;
use Illuminate\Support\ServiceProvider;

class TaskNoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TaskNoteRepositoryContract::class, TaskNoteRepository::class);
        $this->app->singleton(TaskNoteServiceContract::class, TaskNoteService::class);
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
