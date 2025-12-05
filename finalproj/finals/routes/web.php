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

    // -- ADMIN ONLY (Users, Logs) --
    // We use the class name 'AdminMiddleware::class' instead of a closure
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });

    // -- ADMIN & EMPLOYEE (Products, Customers) --
    // We use the class name 'EmployeeAccessMiddleware::class'
    Route::middleware(EmployeeAccessMiddleware::class)->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
    });

    // -- EVERYONE (Transactions, Sales) --
    // Cashiers are allowed here by default as they are 'auth' but don't hit the specific middleware above
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
});