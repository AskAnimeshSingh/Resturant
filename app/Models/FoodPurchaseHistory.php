<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPurchaseHistory extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'food_purchase_id',
        'product_id',
        'qty',
        'price',
        'total_price',
        'branch_id',
    ];
}
