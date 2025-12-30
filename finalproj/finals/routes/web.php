<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CustomerStoreController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Middleware\EmployeeAccessMiddleware; 
use Illuminate\Support\Facades\Route;

// -- ADMIN/EMPLOYEE GUEST ROUTES (Login) --
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// -- CUSTOMER AUTH ROUTES --
// These POST routes need web middleware for CSRF protection - wrap in middleware group
Route::middleware(['web'])->group(function () {
    Route::post('/customer/login', [CustomerAuthController::class, 'login'])->name('customer.auth.login.post');
    Route::post('/customer/register', [CustomerAuthController::class, 'register'])->name('customer.auth.register.post');
});

// GET routes with guest middleware
Route::prefix('customer')->name('customer.auth.')->middleware('guest:customer')->group(function () {
    Route::get('/login', fn() => redirect('/login?mode=customer'))->name('login');
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
});

// -- ADMIN/EMPLOYEE AUTHENTICATED ROUTES --
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Global Search API
    Route::get('/api/search', [SearchController::class, 'search'])->name('api.search');
    
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
        
        // SHOP/POS ROUTES
        Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
        Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
        Route::get('/shop/receipt/{sale}', [ShopController::class, 'receipt'])->name('shop.receipt');
    });

    // -- EVERYONE (Transactions, Sales) --
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
});

// -- CUSTOMER PORTAL (Authenticated Customers Only) --
Route::prefix('customer-portal')->name('customer.')->middleware('auth:customer')->group(function () {
    Route::get('/', [CustomerStoreController::class, 'index'])->name('index');
    Route::post('/checkout', [CustomerStoreController::class, 'checkout'])->name('checkout');
    Route::get('/receipt/{sale}', [CustomerStoreController::class, 'receipt'])->name('receipt');
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// Debug routes - Protected: Only accessible to authenticated admin users
Route::middleware(['auth'])->group(function () {
    Route::get('/migrate-db', function() {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        Artisan::call('migrate --force');
        return '<h1>Database Migrated Successfully!</h1><p><a href="/">Go back to Dashboard</a></p>';
    });

    Route::get('/seed-db', function() {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        Artisan::call('db:seed --force');
        return '<h1>Database Seeded Successfully!</h1><p><a href="/">Go back to Dashboard</a></p>';
    });

    Route::get('/db-check', function() {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $output = '<h1>Database Connection Check</h1>';
        $output .= '<p><strong>DB_CONNECTION:</strong> ' . env('DB_CONNECTION', 'not set') . '</p>';
        $output .= '<p><strong>DB_HOST:</strong> ' . env('DB_HOST', 'not set') . '</p>';
        $output .= '<p><strong>DB_DATABASE:</strong> ' . env('DB_DATABASE', 'not set') . '</p>';
        $output .= '<p><strong>DATABASE_URL:</strong> ' . (env('DATABASE_URL') ? 'SET (hidden)' : 'not set') . '</p>';
        
        try {
            DB::connection()->getPdo();
            $output .= '<p style="color:green"><strong>✓ Database connected successfully!</strong></p>';
            $output .= '<p><strong>Database name:</strong> ' . DB::connection()->getDatabaseName() . '</p>';
            
            // Check if users table exists
            $tables = DB::select('SHOW TABLES');
            $output .= '<p><strong>Tables:</strong> ' . count($tables) . ' found</p>';
            
            // Count users
            $userCount = DB::table('users')->count();
            $output .= '<p><strong>Users in database:</strong> ' . $userCount . '</p>';
            
        } catch (\Exception $e) {
            $output .= '<p style="color:red"><strong>✗ Database connection failed:</strong> ' . $e->getMessage() . '</p>';
        }
    
        return $output;
    });
});