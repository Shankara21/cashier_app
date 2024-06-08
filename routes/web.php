<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::redirect('/', '/dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    // Category
    Route::resource('categories', CategoryController::class);

    // User
    Route::resource('users', UserController::class);

    // Product
    Route::resource('products', ProductController::class);
});
