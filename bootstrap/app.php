<?php

use App\Http\Middleware\AuthAdminMiddleware;
use App\Http\Middleware\AuthCustomerMiddleware;
use App\Http\Middleware\AuthUserMiddleware;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['auth-customer'=> AuthCustomerMiddleware::class]);
        $middleware->alias(['auth-user'=> AuthuserMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

