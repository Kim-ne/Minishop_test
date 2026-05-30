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
            \App\Services\Contracts\HomeServiceInterface::class,
            \App\Services\HomeService::class
        );

        // ProductServiceInterface
        $this->app->bind(
            \App\Services\Contracts\ProductServiceInterface::class,
            \App\Services\ProductService::class
        );

        // CartServiceInterface
        $this->app->bind(
            \App\Services\Contracts\CartServiceInterface::class,
            \App\Services\CartService::class
        );

        // AuthServiceInterface
        $this->app->bind(
            \App\Services\Contracts\AuthServiceInterface::class,
            \App\Services\AuthService::class
        );

        // ProfileServiceInterface for Customer
        $this->app->bind(
            \App\Services\Contracts\ProfileServiceInterface::class,
            \App\Services\ProfileService::class
        );

        // RoleServiceInterface for user
        $this->app->bind(
            \App\Services\Contracts\RoleServiceInterface::class,
            \App\Services\RoleService::class
        );

        // CustomerServiceInterface for user
        $this->app->bind(
            \App\Services\Contracts\CustomerServiceInterface::class,
            \App\Services\CustomerService::class
        );

        // AuthApiServiceInterface
        $this->app->bind(
            \App\Services\Contracts\AuthApiServiceInterface::class,
            \App\Services\AuthApiService::class
        );

        // ProductRepositoryInterface
        $this->app->bind(
            \App\Repositories\Contracts\ProductRepositoryInterface::class,
            \App\Repositories\ProductRepository::class
        );

        // OrderRepositoryInterface
        $this->app->bind(
            \App\Repositories\Contracts\OrderRepositoryInterface::class,
            \App\Repositories\OrderRepository::class
        );

        // OrderServiceInterface
        $this->app->bind(
            \App\Services\Contracts\OrderServiceInterface::class,
            \App\Services\OrderService::class
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
