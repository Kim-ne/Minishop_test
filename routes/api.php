<?php
use App\Http\Controllers\Api\V1\ProductApiController as V1ProductApiController;
use App\Http\Controllers\Api\V1\AuthApiController as V1AuthApiController;
use App\Http\Controllers\Api\V1\OrderApiController as V1OrderApiController;
use App\Http\Controllers\Api\V1\CustomerApiController as V1CustomerApiController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\OrderApiController;


// -------------------------------------
// Health check
// -------------------------------------
Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working',
        'version' => '1.0.0',
    ]);
});

// -------------------------------------
// Auth Routes - public
// -------------------------------------
Route::prefix('auth')->controller(AuthApiController::class)->group(function () {
    Route::post('/login','login')           // POST   /api/user/login
        ->middleware('throttle:api.login');
});

//  -------------------------------------
// Order routes - public
//  -------------------------------------
Route::prefix('orders')->controller(OrderApiController::class)->group(function () {
    Route::get('/','index');                // GET    /api/orders
    Route::get('/{id}','show');             // GET    /api/orders/{id}
    Route::post('/','store');               // POST   /api/orders
    Route::patch('/{id}/status','updateStatus');  // PATCH  /api/orders/{id}/status
    Route::delete('/{id}','destroy');       // DELETE /api/orders/{id}
});

// -------------------------------------
// Protected routes - requires token
// All request goes through middleware without token - auto 401
// -------------------------------------
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth Routes - need token
    Route::prefix('auth')->controller(AuthApiController::class)->group(function () {
        Route::post('/logout','logout');        // POST   /api/auth/logout
        Route::get('/me','me');                 // GET    /api/auth/me
    });
    // Product routes - need token
    Route::prefix('products')->controller(ProductApiController::class)->group(function () {

    Route::get('/','index');              // GET    /api/products
    Route::get('/{id}','show');           // GET    /api/products/{id}
    Route::post('/','store');             // POST   /api/products
    Route::put('/{id}','update');         // PUT    /api/products/{id}
    Route::delete('/{id}','destroy');     // DELETE /api/products/{id}

    // PATCH endpoints
    Route::patch('/{id}/status','toggleStatus');        // PATCH /api/products/{id}/status
    Route::patch('/{id}/featured','toggleFeatured');    // PATCH /api/products/{id}/featured
    });
});

// -------------------------------------
// V1 routes - api/v1/...
// -------------------------------------
Route::prefix('v1')->name('api.v1.')->group(function () {
    // public auth routes
    Route::prefix('auth')->controller(V1AuthApiController::class)->group(function () {
        Route::post('/login','login')                        // POST   /api/v1/auth/
            ->middleware('throttle:api.login');
        Route::post('/register','register');                 // POST   /api/v1/auth/register
        Route::post('/forgot-Password','forgotPassword');    // POST   /api/v1/auth/ForgotPassword
        Route::post('/reset-Password','resetPassword');      // POST   /api/v1/auth/ResetPassword
    });

    // public customer route
    Route::prefix('customer')->controller(V1CustomerApiController::class)->group(function () {
        Route::post('/register','register');    // POST   /api/v1/customer/register
    });

    // protected
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::prefix('auth')->controller(V1AuthApiController::class)->group(function () {
            Route::post('/logout','logout');    // POST   /api/v1/auth/logout
            Route::get('/me','me');             // GET    /api/v1/auth/me
        });

        Route::prefix('products')->controller(V1ProductApiController::class)->group(function () {
            Route::get('/','index');              // GET    /api/v1/products
            Route::get('/{id}','show');           // GET    /api/v1/products/{id}
            Route::post('/','store');             // POST   /api/v1/products
            Route::put('/{id}','update');         // PUT    /api/v1/products/{id}
            Route::delete('/{id}','destroy');     // DELETE /api/v1/products/{id}
            Route::patch('/{id}/status','toggleStatus');        // PATCH /api/v1/products/{id}/status
            Route::patch('/{id}/featured','toggleFeatured');    // PATCH /api/v1/products/{id}/featured
        });

        Route::prefix('orders')->controller(V1OrderApiController::class)->group(function () {
            Route::get('/','index');                // GET    /api/v1/orders
            Route::get('/{id}','show');             // GET    /api/v1/orders/{id}
            Route::post('/','store');               // POST   /api/v1/orders
            Route::patch('/{id}/status','updateStatus');  // PATCH  /api/v1/orders/{id}/status
            Route::delete('/{id}','destroy');       // DELETE /api/v1/orders/{id}
        });
    });


});
