<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebOrderProduct extends Model
{
    use HasFactory;

    protected $table = 'web_order_products';
    protected $primaryKey   = "id";
    public $timestamps      = false;

    protected $fillable = [
       'product_id',
        'cart_id',
        'user_id',
        'qty',
        'base_price',
        'order_id',
        'prod_extra_id',
        'price',
        'tax',
        'status',
        'combo_pack_id',
        'type',
        'extra',
        'varients',
        'properties',
        'toppings',
        'discount_percent',
        'normal_price',
        'price_before_discount',
        'tax_percent',
        'chef_id'
    ];
}
