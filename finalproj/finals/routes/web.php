<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController; // Added ShopController
use App\Http\Controllers\CustomerStoreController; // Customer Portal
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

    // -- ADMIN & EMPLOYEE (Products, Customers, Shop) --
    Route::middleware(EmployeeAccessMiddleware::class)->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        
        // NEW SHOP ROUTES
        Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
        Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
    });

    // -- EVERYONE (Transactions, Sales) --
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('sales', SaleController::class)->only(['index', 'show']);

    // -- CUSTOMER PORTAL (All Authenticated Users) --
    Route::prefix('customer-portal')->name('customer.')->group(function () {
        Route::get('/', [CustomerStoreController::class, 'index'])->name('index');
        Route::post('/checkout', [CustomerStoreController::class, 'checkout'])->name('checkout');
        Route::get('/receipt/{sale}', [CustomerStoreController::class, 'receipt'])->name('receipt');
    });
});