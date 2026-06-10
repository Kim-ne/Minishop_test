<?php

use App\Http\Controllers\Backend\AuthController as BackendAuthController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\ProfileController as BackendProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CustomerController as BackendCustomerController;
use App\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\frontend\ProfileController as FrontendProfileController;
use Illuminate\Support\Facades\Route;

// Route for home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route for product page
Route::get('/products', [ProductController::class, 'index'])->name('product.index');

// Route for cart page
Route::get('/cart', [CartController::class, 'getCart'])->name('product.cart');
Route::post('/cart/{id}', [CartController::class, 'addToCart'])->name('product.addToCart');
Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/checkout', [CartController::class, 'order'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'orderPost'])->name('cart.orderpost');
Route::get('/cart-completed', [CartController::class, 'orderCompleted'])->name('cart.completed');

//middleware for auth-customer
Route::middleware(['auth.customer'])->group(function () {
    Route::get('/profile', [FrontendProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/info', [FrontendProfileController::class, 'infoUpdate'])->name('info.update');
    Route::get('/logout', [FrontendAuthController::class, 'logout'])->name('logout');
    Route::put('/profile/password', [FrontendProfileController::class, 'passwordUpdate'])->name('password.update');

});

//middleware for auth-user
Route::prefix('user')->group(function () {
    // GUEST ROUTE

    // Login
    Route::get('/login', [BackendAuthController::class, 'userLogin'])->name('user.login');
    Route::post('/login', [BackendAuthController::class, 'userLoginPost'])->name('userLogin.post');
    Route::get('/register', [BackendAuthController::class, 'userRegister'])->name('userRegister');
    Route::post('/register', [BackendAuthController::class, 'userRegisterPost'])->name('userRegister.post');

    //  Route for forgot password User
    Route::get('/forgot-password', [BackendAuthController::class, 'forgotPassword'])->name('user.forgot-password');
    Route::post('/forgot-password', [BackendAuthController::class, 'forgotPasswordPost'])->name('user.forgot-password.post');

    //  route for reset password User
    Route::get('/reset-password/{token}', [BackendAuthController::class, 'resetPassword'])->name('user.reset-password');
    Route::post('/reset-password', [BackendAuthController::class, 'resetPasswordPost'])->name('user.reset-password.post');

    // AUTHENTICATED ROUTE
    Route::middleware(['auth.user'])->group(function () {
        // Route product for user
        Route::patch('/products/{id}/stock', [BackendProductController::class, 'updateStock'])->name('products.updateStock');
        Route::get('/products', [BackendProductController::class, 'index'])->name('user.products');
        Route::get('/products/{id}', [BackendProductController::class, 'show'])->name('user.productShow');

        // Route for dashboard
        Route::get('/', [BackendHomeController::class, 'dashboardIndex'])->name('user.dashboard');
        Route::get('/social', [BackendHomeController::class, 'socialIndex'])->name('social');
        Route::get('/profile', [BackendProfileController::class, 'userProfile'])->name('userProfile');

        // Route for profile
        Route::get('/edit-profile', [BackendProfileController::class, 'editProfile'])->name('editProfile');
        Route::put('/edit-profile/avatar', [BackendProfileController::class, 'userAvatarUpdate'])->name('userAvatar.update');
        Route::put('/edit-profile/info', [BackendProfileController::class, 'userInfoUpdate'])->name('userInfo.update');
        Route::put('/edit-profile/password', [BackendProfileController::class, 'userPasswordUpdate'])->name('userPassword.update');

        // Route for customer
        Route::get('/customers', [BackendCustomerController::class, 'index'])->name('customer.index');
        Route::get('/customers/{customer}', [BackendCustomerController::class, 'show'])->name('customer.show');
        Route::get('/logout', [BackendAuthController::class, 'userLogout'])->name('user.logout');

        // Route for role management
        Route::middleware(['role:manager'])->group(function () {
            // Route for role management
            Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
            Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
            Route::put('/roles/{user}/update', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('/roles/{user}/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');
            Route::patch('/customers/{customer}/toggle-status', [BackendCustomerController::class, 'toggleStatus'])->name('customer.toggleStatus');
            Route::delete('/customers/{customer}/delete', [BackendCustomerController::class, 'destroy'])->name('customer.destroy');

            // Route for product management
            Route::get('/products/create', [BackendProductController::class, 'create'])->name('products.create');
            Route::post('/products', [BackendProductController::class, 'store'])->name('products.store');
            Route::get('/products/{id}/edit', [BackendProductController::class, 'edit'])->name('products.edit');
            Route::put('/products/{id}', [BackendProductController::class, 'update'])->name('products.update');
            Route::delete('/products/{id}', [BackendProductController::class, 'destroy'])->name('products.destroy');
            Route::patch('/products/{id}/toggle-status', [BackendProductController::class, 'toggleStatus'])->name('products.toggleStatus');
            Route::patch('/products/{id}/toggle-featured', [BackendProductController::class, 'toggleFeatured'])->name('products.toggleFeatured');
        });
    });
});

// Route customer for login
Route::get('/login', [FrontendAuthController::class, 'login'])->name('login');
Route::post('/login', [FrontendAuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [FrontendAuthController::class, 'register'])->name('register');
Route::post('/register', [FrontendAuthController::class, 'registerPost'])->name('register.post');

// test
Route::get('/logintest', [BackendHomeController::class, 'loginTest'])->name('logintest');
Route::get('/profiletest', [BackendHomeController::class, 'profileTest'])->name('profiletest');
// Route::get('/editProfiletest',[BackendHomeController::class,'editProfileTest'])->name('editProfiletest');
Route::get('/roleTest', [BackendHomeController::class, 'roleTest'])->name('roleTest');

// Search route
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Route for product detail page
Route::get('/{alias}', [ProductController::class, 'detail'])->name('product.detail');


