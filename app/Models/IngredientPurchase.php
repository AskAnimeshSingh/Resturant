<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_price',
        'vendor_name',
        'vendor_address',
        'purchase_date',
        'cgst',
        'sgst',
        'quantity',
        'unit',
    ];
}
