<?php

namespace App\Providers;

use App\Services\Checklist\ChecklistService;
use App\Services\Checklist\Contracts\ChecklistRepositoryContract;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Checklist\Repositories\ChecklistRepository;
use App\Services\ChecklistGroup\ChecklistGroupService;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupRepositoryContract;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;
use App\Services\ChecklistGroup\Repositories\ChecklistGroupRepository;
use App\Services\Page\Contracts\PageRepositoryContract;
use App\Services\Page\Contracts\PageServiceContract;
use App\Services\Page\PageService;
use App\Services\Page\Repositories\PageRepository;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Repositories\TaskRepository;
use App\Services\Task\TaskService;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Repositories\UserRepository;
use App\Services\User\UserService;
use Illuminate\Pagination\Paginator;
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
        $this->app->bind(
            UserServiceContract::class,
            fn($app) => new UserService($app->make(UserRepositoryContract::class), (int) config('pagination.admin_users'))
        );

        $this->app->bind(ChecklistGroupRepositoryContract::class, ChecklistGroupRepository::class);
        $this->app->bind(ChecklistGroupServiceContract::class, ChecklistGroupService::class);

        $this->app->bind(ChecklistRepositoryContract::class, ChecklistRepository::class);
        $this->app->bind(ChecklistServiceContract::class, ChecklistService::class);

        $this->app->bind(TaskRepositoryContract::class, TaskRepository::class);
        $this->app->bind(TaskServiceContract::class, TaskService::class);

        $this->app->bind(PageRepositoryContract::class, PageRepository::class);
        $this->app->bind(PageServiceContract::class, PageService::class);

        Paginator::useBootstrap();
    }
}
