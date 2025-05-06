<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::get('/products-list', [ProductController::class, 'listOfProducts'])->name('products.list');

Route::post('/add-to-cart/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/increase/{id}', [ProductController::class, 'increaseQuantity'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [ProductController::class, 'decreaseQuantity'])->name('cart.decrease');

Route::post('/checkout', [ProductController::class, 'completeSale'])->name('checkout');

Route::get('/sales/report', [SaleController::class, 'monthlyReport'])->name('sales.report');

Route::get('/sales/report/pdf', [SaleController::class, 'exportPDF'])->name('sales.report.pdf');

Route::get('/orders', [SaleController::class, 'index'])->name('sale.index');

Route::get('/send-daily-report', [SaleController::class, 'maybeSendDailyReport']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function() {
    return view('auth.register');
})->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/forget_password', [AuthController::class, 'forget_password'])->name('forget_password');

Route::get('/settings', [SettingsController::class, 'showSetting'])->name('settings');