<?php

use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use Illuminate\Support\Facades\Route;

//route for home page
Route::get('/', [HomeController::class,'index'])->name('home');

//route for product page
Route::get('/products', [ProductController::class,'index'])->name('product');

