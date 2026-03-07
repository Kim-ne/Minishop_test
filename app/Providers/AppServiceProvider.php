<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // HomeServiceInterface
        $this->app->bind(
            \App\Services\Interface\HomeServiceInterface::class,
            \App\Services\HomeService::class
        );
        
        // ProductServiceInterface
        $this->app->bind(
            \App\Services\Interface\ProductServiceInterface::class,
            \App\Services\ProductService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
