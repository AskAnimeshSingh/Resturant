<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userCart extends Model
{
    use HasFactory;

    protected $table = 'user_carts';
    protected $primaryKey   = "id";
    public $timestamps      = false;

    protected $fillable = [
       'product_id',
        'user_id',
        'qty',
        'price',
        'tax',
        'status',
        'extra',
        'combo_id',
        'type',
        'varients',
        'properties',
        'toppings',
        'discount_percent',
        'discounted_price',
    ];
}
