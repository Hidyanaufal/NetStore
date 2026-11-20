<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockMovementController;

// HALAMAN LOGIN
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.process');

});

// HALAMAN YANG MEMERLUKAN LOGIN
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('transactions', TransactionController::class);

    // MANAJEMEN STOK
    Route::get('/stock-movements', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');

    Route::post('/stock-movements', [StockMovementController::class, 'store'])
        ->name('stock-movements.store');

    // LOGOUT
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

});
