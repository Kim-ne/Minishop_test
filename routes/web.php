<?php

use App\Http\Controllers\Backend\AuthController as BackendAuthController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\AuthController;

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
Route::middleware(['auth-customer'])->group(function () {
    Route::get('/profile', [AuthController::class,'profile'])->name('profile');
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');

});

Route::middleware(['auth-admin'])->group(function () {
    Route::get('/admin/profile', [BackendAuthController::class,'adminProfile'])->name('admin.profile');
    Route::get('/admin/logout', [BackendAuthController::class,'adminLogout'])->name('admin.logout');

});

// Route admin login
Route::get('/admin/login', [BackendAuthController::class,'adminLogin'])->name('admin.login');
Route::post('/admin/login', [BackendAuthController::class,'adminLoginPost'])->name('adminLogin.post');

//route for login
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class,'register'])->name('register');
Route::post('/register', [AuthController::class,'registerPost'])->name('register.post');


//search route
Route::get('/search', [ProductController::class,'search'])->name('search');

//route for product detail page
Route::get('/{alias}', [ProductController::class,'detail'])->name('product.detail');
