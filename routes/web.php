<?php

use App\Http\Controllers\Backend\AuthController as BackendAuthController;
use App\Http\Controllers\Backend\ProfileController as BackendProfileController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\frontend\ProfileController as FrontendProfileController;
use Illuminate\Container\Attributes\Auth;
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
    Route::get('/profile', [BackendProfileController::class,'userProfile'])->name('userProfile');
    Route::put('/profile/info', [BackendProfileController::class,'userInfoUpdate'])->name('userInfo.update');
    Route::put('/profile/password', [BackendProfileController::class,'userPasswordUpdate'])->name('userPassword.update');
    Route::get('/logout', [BackendAuthController::class,'userLogout'])->name('user.logout');

});

// Route user login
Route::get('/user/login', [BackendAuthController::class,'userLogin'])->name('user.login');
Route::post('/user/login', [BackendAuthController::class,'userLoginPost'])->name('userLogin.post');
Route::get('/user/register', [BackendAuthController::class,'userRegister'])->name('userRegister');
Route::post('/user/register', [BackendAuthController::class,'userRegisterPost'])->name('userRegister.post');

//route for login
Route::get('/login', [FrontendAuthController::class,'login'])->name('login');
Route::post('/login', [FrontendAuthController::class,'loginPost'])->name('login.post');
Route::get('/register', [FrontendAuthController::class,'register'])->name('register');
Route::post('/register', [FrontendAuthController::class,'registerPost'])->name('register.post');


//search route
Route::get('/search', [ProductController::class,'search'])->name('search');

//route for product detail page
Route::get('/{alias}', [ProductController::class,'detail'])->name('product.detail');
