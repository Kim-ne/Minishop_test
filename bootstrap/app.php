<?php

use App\Helpers\ApiResponse;
use App\Http\Middleware\AuthCustomerMiddleware;
use App\Http\Middleware\AuthUserMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        'auth.user' => AuthUserMiddleware::class,
        'auth.customer' => AuthCustomerMiddleware::class,
        'role' => \App\Http\Middleware\CheckRole::class]);
        $middleware->api(prepend:[
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // request is Api (Accept: application/json)
        // -> all exceptions will be converted to json

        $exceptions->render(function (AuthenticationException $e, $request) {
            if($request->expectsJson())
            {
                return ApiResponse::unauthorized('Unauthorized. Please login first.');
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if($request->expectsJson())
            {
                return ApiResponse::notFound('Resource not found');
            }
        });

        $exceptions->render(function (ValidationException $e, $request) {
            if($request->expectsJson())
            {
                return ApiResponse::validationError($e->errors());
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            if($request->expectsJson())
            {
                return ApiResponse::error('Method not allowed', 405);
            }
        });

    })->create();

