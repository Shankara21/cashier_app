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
    Route::get('/cashier', function () {
        return view('pages.cashier.index');
    })->name('cashier');
    // Category
    Route::resource('categories', CategoryController::class);

    // User
    Route::resource('users', UserController::class);

    // Product
    Route::resource('products', ProductController::class);
    Route::post('/products/code', [ProductController::class, 'getProductByCode'])->name('products.code');
});
