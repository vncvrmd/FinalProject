<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'transaction_id';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'transaction_id';
    }

    protected $fillable = ['sale_id', 'product_id', 'quantity_sold', 'price_at_sale'];

    // A Transaction belongs to a Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'sales_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}