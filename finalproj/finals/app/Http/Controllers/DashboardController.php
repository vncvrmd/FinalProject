<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::latest()->take(5)->get(),
            'products' => Product::all(),
            'customers' => Customer::all(),
            'transactions' => Transaction::with(['product', 'customer'])->get(),
            'sales' => Sale::with('transaction')->get(),
        ];
        
        return view('dashboard', $data);
    }
}