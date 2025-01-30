<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'product_name',
        'product_img',
        'product_des',
        'qty',
        'price',
        'tax',
        'status',
        'category',
        'sub_category',
        'child_category',
        'size',
        'addon',
        'type',
        'has_varients',
        'has_properties',
        'default_varients',
        'default_toppings',
        'default_crust'
    ];
}
