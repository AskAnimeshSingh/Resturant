<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'coupon_name',
        'product_id',
        'start_date',
        'end_date',
        'status',
        'discount',
    ];
}
