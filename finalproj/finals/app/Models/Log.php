<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id',
        'action',
        'date_time',
    ];
    
    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function user()
    {
        // Make sure your keys are correct
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}