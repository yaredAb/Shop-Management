<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    Route::get('/', [ProductController::class, 'index']);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/products-list', [ProductController::class, 'listOfProducts'])->name('products.list');

    Route::post('/add-to-cart/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [ProductController::class, 'updateQuantity'])->name('cart.update');
    Route::get('/cart/list', [CartController::class, 'list'])->name('cart.list');
    Route::post('/cart/delete', [CartController::class, 'delete_cart_item']);

    Route::post('/checkout', [ProductController::class, 'sendToCashier'])->name('checkout');

    Route::get('/sales/report', [SaleController::class, 'monthlyReport'])->name('sales.report');

    Route::get('/sales/report/pdf', [SaleController::class, 'exportPDF'])->name('sales.report.pdf');

    Route::get('/orders', [SaleController::class, 'index'])->name('sale.index');

    Route::get('/send-daily-report', [SaleController::class, 'maybeSendDailyReport'])->name('dailyReport');

    Route::get('/settings', [SettingsController::class, 'showSetting'])->name('settings');

    Route::post('/security_qa', [AuthController::class, 'securityQA'])->name('securityQA');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');

    Route::post('/settings/telegram', [SettingsController::class, 'setTelegramToken'])->name('settings.setTelegramToken');
    Route::post('/settings/Timer', [SettingsController::class, 'setTimer'])->name('settings.setTimer');

    Route::post('/settings/custemize', [SettingsController::class, 'updateCustemization'])->name('settings.updateCustemization');

    Route::get('/users', [SettingsController::class, 'userList'])->name('userList');
    Route::delete('/users/{user}', [SettingsController::class, 'deleteUser'])->name('users.delete');

    Route::post('/logout', function() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        \App\Models\Log::saveLog('orange', 'Logged Out');
        return redirect('/');
    })->name('logout');

    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    Route::get('/cashier/index', [CashierController::class, 'index'])->name('cashier.index');
    Route::post('/proceed/direct', [ProductController::class, 'proceedDirect'])->name('proceed.direct');
});


Route::middleware(['guest'])->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function() {
        return view('auth.register');
    })->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('forget-password', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forget-password', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});
