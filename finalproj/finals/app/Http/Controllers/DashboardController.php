<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::latest()->take(5)->get(),
            'products' => Product::all(),
            'customers' => Customer::all(),
            
            // FIX 1: Access customer via the 'sale' relationship
            'transactions' => Transaction::with(['product', 'sale.customer'])->latest()->take(5)->get(),
            
            // FIX 2: Sale now has 'customer' directly. 'transactions' is plural.
            'sales' => Sale::with(['customer', 'transactions'])->latest()->take(5)->get(),
            
            'logs' => Log::with('user')->latest()->take(5)->get(),
        ];
        
        return view('dashboard', $data);
    }
}