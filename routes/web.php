<?php

use App\Http\Controllers\Backend\AuthController as BackendAuthController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\ProfileController as BackendProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CustomerController as BackendCustomerController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\frontend\ProfileController as FrontendProfileController;
use Illuminate\Support\Facades\Route;

//route for home page
Route::get('/', [HomeController::class,'index'])->name('home');

//route for product page
Route::get('/products', [ProductController::class,'index'])->name('product.index');

//route for cart page
Route::get('/cart', [CartController::class,'getCart'])->name('product.cart');
Route::post('/cart/{id}', [CartController::class,'addToCart'])->name('product.addToCart');
Route::get('/cart/remove/{id}', [CartController::class,'removeFromCart'])->name('cart.remove');
Route::put('/cart/update/{id}', [CartController::class,'updateCart'])->name('cart.update');
Route::get('/checkout',[CartController::class,'order'])->name('cart.checkout');
Route::post('/checkout',[CartController::class, 'orderPost'])->name('cart.orderpost');
Route::get('/cart-completed', [CartController::class,'orderCompleted'])->name('cart.completed');

//middleware for auth-customer
Route::middleware(['auth.customer'])->group(function () {
    Route::get('/profile', [FrontendProfileController::class,'profile'])->name('profile');
    Route::put('/profile/info', [FrontendProfileController::class,'infoUpdate'])->name('info.update');
    Route::get('/logout', [FrontendAuthController::class,'logout'])->name('logout');
    Route::put('/profile/password', [FrontendProfileController::class,'passwordUpdate'])->name('password.update');

});

//middleware for auth-user
Route::prefix('user')->middleware(['auth.user'])->group(function () {
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/roles',[RoleController::class,'index'])->name('roles.index');
        Route::post('/roles',[RoleController::class,'store'])->name('roles.store');
        Route::put('/roles/{user}/update',[RoleController::class,'update'])->name('roles.update');
        Route::delete('/roles/{user}/destroy',[RoleController::class,'destroy'])->name('roles.destroy');
        Route::patch('/customers/{customer}/toggle-status', [BackendCustomerController::class, 'toggleStatus'])->name('customer.toggleStatus');
        Route::delete('/customers/{customer}/delete', [BackendCustomerController::class, 'destroy'])->name('customer.destroy');

    });

    Route::get('/', [BackendHomeController::class,'dashboardIndex'])->name('user.dashboard');
    Route::get('/social', [BackendHomeController::class,'socialIndex'])->name('social');
    Route::get('/profile', [BackendProfileController::class,'userProfile'])->name('userProfile');
    Route::get('/edit-profile', [BackendProfileController::class,'editProfile'])->name('editProfile');
    Route::put('/edit-profile/avatar', [BackendProfileController::class,'userAvatarUpdate'])->name('userAvatar.update');
    Route::put('/edit-profile/info', [BackendProfileController::class,'userInfoUpdate'])->name('userInfo.update');
    Route::put('/edit-profile/password', [BackendProfileController::class,'userPasswordUpdate'])->name('userPassword.update');
    Route::get('/customers',[BackendCustomerController::class,'index'])->name('customer.index');
    Route::get('/customers/{customer}',[BackendCustomerController::class,'show'])->name('customer.show');
    Route::get('/logout', [BackendAuthController::class,'userLogout'])->name('user.logout');

});

// Route user login
Route::get('/user/login', [BackendAuthController::class,'userLogin'])->name('user.login');
Route::post('/user/login', [BackendAuthController::class,'userLoginPost'])->name('userLogin.post');
Route::get('/user/register', [BackendAuthController::class,'userRegister'])->name('userRegister');
Route::post('/user/register', [BackendAuthController::class,'userRegisterPost'])->name('userRegister.post');

//route customer for login
Route::get('/login', [FrontendAuthController::class,'login'])->name('login');
Route::post('/login', [FrontendAuthController::class,'loginPost'])->name('login.post');
Route::get('/register', [FrontendAuthController::class,'register'])->name('register');
Route::post('/register', [FrontendAuthController::class,'registerPost'])->name('register.post');

//test
Route::get('/logintest',[BackendHomeController::class,'loginTest'])->name('logintest');
Route::get('/profiletest',[BackendHomeController::class,'profileTest'])->name('profiletest');
// Route::get('/editProfiletest',[BackendHomeController::class,'editProfileTest'])->name('editProfiletest');
Route::get('/roleTest',[BackendHomeController::class,'roleTest'])->name('roleTest');

//search route
Route::get('/search', [ProductController::class,'search'])->name('search');

//route for product detail page
Route::get('/{alias}', [ProductController::class,'detail'])->name('product.detail');


