<?php

namespace App\Providers;

use App\Services\Page\Contracts\PageRepositoryContract;
use App\Services\Page\Contracts\PageServiceContract;
use App\Services\Page\PageService;
use App\Services\Page\Repositories\PageRepository;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PageRepositoryContract::class, PageRepository::class);
        $this->app->singleton(PageServiceContract::class, PageService::class);
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
