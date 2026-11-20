<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'name',
        'ISBN',
        'publish_date',
        'author',
        'publisher',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Part 7: many-to-many through the borrowings pivot table
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'borrowings')
            ->withPivot('borrowing_date', 'return_date', 'is_returned')
            ->withTimestamps();
    }
}