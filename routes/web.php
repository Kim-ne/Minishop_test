<?php

use App\Http\Controllers\frontend\HomeController;
use Illuminate\Support\Facades\Route;

//route for home page
Route::get('/', [HomeController::class,'index'])->name('home');

