<?php

use App\Http\Controllers\Backend\AuthController as BackendAuthController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\AuthController;
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

//middleware for auth-cusstomer
Route::middleware(['auth.customer'])->group(function () {
    Route::get('/profile', [FrontendProfileController::class,'profile'])->name('profile');
    Route::put('/profile/info', [FrontendProfileController::class,'infoUpdate'])->name('info.update');
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
    Route::put('/profile/password', [FrontendProfileController::class,'passwordUpdate'])->name('password.update');

});

Route::middleware(['auth.user'])->group(function () {
    Route::get('/user/profile', [ProfileController::class,'adminProfile'])->name('user.profile');
    Route::put('/user/profile/info', [ProfileController::class,'updateProfile'])->name('userProfile.update');
    Route::put('/user/profile/password', [ProfileController::class,'updatePassword'])->name('userPassword.update');
    Route::get('/user/logout', [ProfileController::class,'adminLogout'])->name('user.logout');

});

// Route user login
Route::get('/user/login', [BackendAuthController::class,'adminLogin'])->name('user.login');
Route::post('/user/login', [BackendAuthController::class,'adminLoginPost'])->name('userLogin.post');

//route for login
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class,'register'])->name('register');
Route::post('/register', [AuthController::class,'registerPost'])->name('register.post');


//search route
Route::get('/search', [ProductController::class,'search'])->name('search');

//route for product detail page
Route::get('/{alias}', [ProductController::class,'detail'])->name('product.detail');
