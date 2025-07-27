<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'image',
        'isShow',
        'colors',
        'sizes',
        'isOffred',
        'offredPrice',
        'startOffreDay',
        'endOffreDay',
        'category_id',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
    ];

    // Product belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
