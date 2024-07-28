<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\VariantController;
use App\Models\Category;
use App\Models\Product;

Route::redirect('/', '/dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cashier', function () {
        return view('pages.cashier.index');
    })->name('cashier');

    Route::get('/invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');
    // Category
    Route::resource('categories', CategoryController::class);

    // User
    Route::resource('users', UserController::class);

    // Modal
    Route::get('/modals/today', [ModalController::class, 'modalToday'])->name('modals.today');
    Route::resource('modals', ModalController::class);

    // Product
    Route::resource('products', ProductController::class);
    Route::post('/products/code', [ProductController::class, 'getProductByCode'])->name('products.code');

    // Order
    Route::resource('orders', OrderController::class);
    Route::post('orders/export', [OrderController::class, 'export'])->name('orders.export');

    Route::resource('product-detail', ProductDetailController::class);
    Route::get('/product-detail/product/{id}', [ProductDetailController::class, 'byProduct'])->name('product-detail.by-product');

    Route::resource('settings', SettingController::class);

    Route::resource('variants', VariantController::class);

    Route::get('/brands/category/{id}', [BrandController::class, 'byCategory'])->name('brands.by-category');
    Route::resource('brands', BrandController::class);
});
