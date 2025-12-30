<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'product_id';
    }

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'quantity_available',
        'product_image',
    ];
}
