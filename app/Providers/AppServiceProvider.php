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
            \App\Services\HomeServiceInterface::class,
            \App\Services\HomeService::class
        );

        // ProductServiceInterface
        $this->app->bind(
            \App\Services\ProductServiceInterface::class,
            \App\Services\ProductService::class
        );

        // CartServiceInterface
        $this->app->bind(
            \App\Services\CartServiceInterface::class,
            \App\Services\CartService::class
        );

        // AuthServiceInterface
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            \App\Services\AuthService::class
        );

        // ProfileServiceInterface for Customer
        $this->app->bind(
            \App\Services\ProfileServiceInterface::class,
            \App\Services\ProfileService::class
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
