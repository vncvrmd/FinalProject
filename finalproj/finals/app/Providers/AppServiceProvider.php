<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Transaction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share notification data with all views that use the app layout
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                // Low stock products (quantity <= 10)
                $lowStockProducts = Product::where('quantity_available', '<=', 10)
                    ->where('quantity_available', '>', 0)
                    ->orderBy('quantity_available', 'asc')
                    ->take(5)
                    ->get();
                
                // Out of stock products
                $outOfStockProducts = Product::where('quantity_available', '=', 0)->get();
                
                // Recent sales (last 24 hours)
                $recentSales = Sale::where('created_at', '>=', now()->subDay())
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
                
                // Today's transaction count
                $todayTransactions = Transaction::whereDate('created_at', today())->count();
                
                $view->with([
                    'lowStockProducts' => $lowStockProducts,
                    'outOfStockProducts' => $outOfStockProducts,
                    'recentSales' => $recentSales,
                    'todayTransactions' => $todayTransactions,
                ]);
            }
        });
    }
}
