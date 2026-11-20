<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'balance',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Part 7: many-to-many through the borrowings pivot table
    public function books()
    {
        return $this->belongsToMany(Book::class, 'borrowings')
            ->withPivot('borrowing_date', 'return_date', 'is_returned')
            ->withTimestamps();
    }
}