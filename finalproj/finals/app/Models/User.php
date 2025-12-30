<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'user_id';
    }

    /**
     * mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'role',
        'username',
        'email',
        'password',
        'profile_image', 
    ];

    /**
     * hidden
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id');
    }
}