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

        // FIX 1: Load 'sale.customer' instead of 'customer'
        $transactions = Transaction::with(['product', 'sale.customer'])
            ->when($search, function ($query, $search) {
                // FIX 2: Search by customer name VIA the sale relationship
                $query->whereHas('sale.customer', function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%");
                })
                // Or search by product name
                ->orWhereHas('product', function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%");
                })
                // Optional: Search by Transaction ID
                ->orWhere('transaction_id', $search);
            })
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::orderBy('product_name')->where('quantity_available', '>', 0)->get();
        $customers = Customer::orderBy('customer_name')->get();
        
        return view('transactions.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'payment_method' => 'required|string',
            'products' => 'required|array',
            'products.*' => 'exists:products,product_id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create the Sale (Receipt)
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'payment_method' => $request->payment_method,
                'sales_date' => now(),
                'total_amount' => 0,
            ]);

            $totalAmount = 0;
            $productsInput = $request->products;
            $quantitiesInput = $request->quantities;

            // 2. Loop through items
            foreach ($productsInput as $index => $productId) {
                $quantity = $quantitiesInput[$index];
                $product = Product::find($productId);

                if ($product->quantity_available < $quantity) {
                    throw new \Exception("Not enough stock for " . $product->product_name);
                }

                Transaction::create([
                    'sale_id' => $sale->sales_id,
                    'product_id' => $productId,
                    'quantity_sold' => $quantity,
                    'price_at_sale' => $product->price,
                ]);

                // Deduct Stock
                $product->decrement('quantity_available', $quantity);

                $totalAmount += ($product->price * $quantity);
            }

            // 3. Update Total
            $sale->update(['total_amount' => $totalAmount]);

            // 4. Log
            Log::create([
                'user_id' => Auth::id() ?? 1,
                'action' => 'Created sale #' . $sale->sales_id,
                'date_time' => now(),
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction completed successfully!');
    }
}