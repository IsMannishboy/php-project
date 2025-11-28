<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products.products';
    protected $fillable = [
        'name',
        'stock',
        'description',
        'cat_id',
        'price',
        
    ];
}
