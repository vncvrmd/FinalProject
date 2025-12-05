<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'sales_id';
    protected $fillable = ['customer_id', 'total_amount', 'payment_method', 'sales_date'];

    // A Sale has many items (transactions)
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'sale_id', 'sales_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}