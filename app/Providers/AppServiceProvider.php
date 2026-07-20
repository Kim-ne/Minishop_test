<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;


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

        // CustomerApiServiceInterface
        $this->app->bind(
            \App\Services\Contracts\CustomerApiServiceInterface::class,
            \App\Services\CustomerApiService::class
        );

          // OrderServiceInterface
        $this->app->bind(
            \App\Services\Contracts\OrderServiceInterface::class,
            \App\Services\OrderService::class
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

        // AuthRepositoryInterface
        $this->app->bind(
            \App\Repositories\Contracts\AuthRepositoryInterface::class,
            \App\Repositories\AuthRepository::class
        );


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Rate limit for login attempts - prevent brute-force attacks
        RateLimiter::for('api.login', function (Request $request) {
            return [
                // Limit for ip: 5 requests per minute
                // If more than 5 requests -> lock this ip in 5 minutes
                Limit::perMinute(5)
                    ->by('ip:' . $request->ip())
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Too many login attempts for this account. Please try again in 5 minute.',
                        ], 429);
                    }),

                // Limit for email: 10 requests per 5 minute
                // Prevent hackers from launching attacks on a single email using multiple IPs.
                Limit::perMinutes(5, 10)
                    ->by('email:' . strtolower($request->input('email', '')))
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Too many login attempts for this account. Please try again in 5 minute.',
                        ], 429);
                    }),
            ];
        });
    }
}
