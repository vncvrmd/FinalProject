<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Global search across products, customers, users, sales, transactions, and logs
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 1) {
            return response()->json([
                'products' => [],
                'customers' => [],
                'users' => [],
                'sales' => [],
                'transactions' => [],
                'logs' => []
            ]);
        }

        $searchTerm = '%' . $query . '%';
        $isAdmin = strtolower(Auth::user()->role) === 'admin';
        
        // Search products
        $products = Product::where('product_name', 'LIKE', $searchTerm)
            ->orWhere('description', 'LIKE', $searchTerm)
            ->select('product_id', 'product_name', 'price', 'quantity_available', 'product_image')
            ->limit(5)
            ->get();

        // Search customers
        $customers = Customer::where('customer_name', 'LIKE', $searchTerm)
            ->orWhere('email', 'LIKE', $searchTerm)
            ->orWhere('phone', 'LIKE', $searchTerm)
            ->select('customer_id', 'customer_name', 'email', 'phone')
            ->limit(5)
            ->get();

        // Search users (only for admins)
        $users = [];
        if ($isAdmin) {
            $users = User::where('full_name', 'LIKE', $searchTerm)
                ->orWhere('username', 'LIKE', $searchTerm)
                ->orWhere('email', 'LIKE', $searchTerm)
                ->select('user_id', 'full_name', 'username', 'email', 'role')
                ->limit(5)
                ->get();
        }

        // Search sales by customer name, payment method, or sales_id
        $sales = Sale::with('customer:customer_id,customer_name')
            ->where(function($q) use ($searchTerm, $query) {
                $q->where('payment_method', 'LIKE', $searchTerm)
                  ->orWhere('sales_id', 'LIKE', $searchTerm)
                  ->orWhereHas('customer', function($cq) use ($searchTerm) {
                      $cq->where('customer_name', 'LIKE', $searchTerm);
                  });
            })
            ->select('sales_id', 'customer_id', 'total_amount', 'payment_method', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Search transactions by product name or transaction_id
        $transactions = Transaction::with(['product:product_id,product_name', 'sale:sales_id,customer_id'])
            ->where(function($q) use ($searchTerm) {
                $q->where('transaction_id', 'LIKE', $searchTerm)
                  ->orWhereHas('product', function($pq) use ($searchTerm) {
                      $pq->where('product_name', 'LIKE', $searchTerm);
                  });
            })
            ->select('transaction_id', 'sale_id', 'product_id', 'quantity_sold', 'price_at_sale', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Search logs by action (only for admins)
        $logs = [];
        if ($isAdmin) {
            $logs = Log::with('user:user_id,full_name')
                ->where('action', 'LIKE', $searchTerm)
                ->select('log_id', 'user_id', 'action', 'date_time')
                ->orderBy('date_time', 'desc')
                ->limit(5)
                ->get();
        }

        return response()->json([
            'products' => $products,
            'customers' => $customers,
            'users' => $users,
            'sales' => $sales,
            'transactions' => $transactions,
            'logs' => $logs
        ]);
    }
}
