<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

// Public Route (Dashboard is visible to all authenticated users)
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Group for all authenticated routes
Route::middleware(['auth'])->group(function () {

    // --- ADMIN ONLY ROUTES ---
    // Only 'admin' role can access Users and Logs
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });

    // --- EMPLOYEE & ADMIN ROUTES ---
    // 'admin' and 'employee' can manage Products and Customers
    Route::middleware(['role:admin,employee'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
    });

    // --- CASHIER, EMPLOYEE & ADMIN ROUTES ---
    // Everyone (Admin, Employee, and Customer/Cashier) can create transactions and view sales
    // Note: This assumes your 'customer' role is functioning as the 'cashier' role
    Route::middleware(['role:admin,employee,customer'])->group(function () {
        Route::resource('transactions', TransactionController::class);
        Route::resource('sales', SaleController::class)->only(['index', 'show']);
    });

});