<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Middleware\EmployeeAccessMiddleware; 
use Illuminate\Support\Facades\Route;

// -- GUEST ROUTES (Login) --
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// -- AUTHENTICATED ROUTES --
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard (Shared by all authenticated users)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // -- PROFILE ROUTES --
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // -- ADMIN ONLY (Users, Logs) --
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });

    // -- ADMIN & EMPLOYEE (Products, Customers) --
    Route::middleware(EmployeeAccessMiddleware::class)->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
    });

    // -- EVERYONE (Transactions, Sales) --
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
});