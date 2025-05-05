<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

Route::post('/add-to-cart/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/increase/{id}', [ProductController::class, 'increaseQuantity'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [ProductController::class, 'decreaseQuantity'])->name('cart.decrease');

Route::post('/checkout', [ProductController::class, 'completeSale'])->name('checkout');

Route::get('/sales/report', [SaleController::class, 'monthlyReport'])->name('sales.report');

Route::get('/sales/report/pdf', [SaleController::class, 'exportPDF'])->name('sales.report.pdf');