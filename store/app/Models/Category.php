<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'products.categories';
    protected $fillable = [
        'name',
        
    ];
}
