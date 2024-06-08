<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    // Category
    Route::resource('category', CategoryController::class);
});
