<?php

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

//middleware for auth
Route::middleware(['auth-customer'])->group(function () {
    Route::get('/profile', [AuthController::class,'profile'])->name('profile');
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');

});

//route for login
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginPost'])->name('login.post');


//search route
Route::get('/search', [ProductController::class,'search'])->name('search');

//route for product detail page
Route::get('/{alias}', [ProductController::class,'detail'])->name('product.detail');
