<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transactions = Transaction::with(['product', 'customer'])
            ->when($search, function ($query, $search) {
                // Search by customer name
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%");
                })
                // Or search by product name
                ->orWhereHas('product', function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        // We need all products and customers for the dropdowns
        $products = Product::orderBy('product_name')->get();
        $customers = Customer::orderBy('customer_name')->get();
        
        return view('transactions.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'customer_id' => 'required|exists:customers,customer_id',
            'quantity_sold' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:cash,credit card',
        ]);

        // Find the product to check stock and get price
        $product = Product::find($validated['product_id']);

        // 1. Check for sufficient stock
        if ($product->quantity_available < $validated['quantity_sold']) {
            return back()->withInput()->withErrors([
                'quantity_sold' => 'Not enough stock. Only ' . $product->quantity_available . ' available.',
            ]);
        }

        // 2. Use a database transaction to ensure all operations succeed or fail together
        try {
            DB::beginTransaction();

            // 3. Create the Transaction
            $transaction = Transaction::create([
                'product_id' => $validated['product_id'],
                'customer_id' => $validated['customer_id'],
                'quantity_sold' => $validated['quantity_sold'],
                'transaction_date' => now(),
            ]);

            // 4. Create the associated Sale
            $totalAmount = $product->price * $validated['quantity_sold'];
            $sale = Sale::create([
                'transaction_id' => $transaction->transaction_id,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'sales_date' => now(),
            ]);

            // 5. Update the product's stock
            $product->quantity_available -= $validated['quantity_sold'];
            $product->save();

            // 6. Create a log entry (assuming user is logged in)
            Log::create([
                'user_id' => Auth::id() ?? 1, // Fallback to user 1 if not logged in (e.g., in tests)
                'action' => 'Created sale #' . $sale->sales_id . ' (Transaction #' . $transaction->transaction_id . ')',
                'date_time' => now(),
            ]);

            // 7. Commit the transaction
            DB::commit();

        } catch (\Exception $e) {
            // 8. Rollback on error
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully!');
    }
}