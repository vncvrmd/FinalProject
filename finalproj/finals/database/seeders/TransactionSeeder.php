<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Log;
use App\Models\User; 

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $customers = Customer::all();
        $user = User::first(); 

        if ($products->isEmpty() || $customers->isEmpty() || !$user) {
            $this->command->info('Cannot run TransactionSeeder, missing products, customers, or users.');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $product = $products->random();
            $customer = $customers->random();
            $quantity = rand(1, 5);

            $transaction = Transaction::create([
                'product_id' => $product->product_id,
                'customer_id' => $customer->customer_id,
                'quantity_sold' => $quantity,
                'transaction_date' => now(),
            ]);

            $sale = Sale::create([
                'transaction_id' => $transaction->transaction_id,
                'total_amount' => $product->price * $quantity,
                'payment_method' => ['cash', 'credit card'][rand(0, 1)],
                'sales_date' => now(),
            ]);


            Log::create([
                'user_id' => $user->user_id, 
                'action' => 'Created sale #' . $sale->sales_id,
                'date_time' => now()
            ]);
        }
    }
}

