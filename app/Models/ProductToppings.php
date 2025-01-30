<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductToppings extends Model
{
    use HasFactory;
    protected $table = 'product_toppings';
    protected $fillable = [
        'product_id',
        'ingredients_id',
        'ingredents_price',
    ];
}
