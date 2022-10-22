<?php

namespace App\Providers;

use App\Services\Subscription\Contract\SubscriptionRepositoryContract;
use App\Services\Subscription\Contract\SubscriptionServiceContract;
use App\Services\Subscription\Repositories\SubscriptionRepository;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SubscriptionRepositoryContract::class, SubscriptionRepository::class);
        $this->app->singleton(SubscriptionServiceContract::class, SubscriptionService::class);
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
