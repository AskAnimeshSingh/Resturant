<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertiesSidesInCart extends Model
{
    use HasFactory;

    protected $table = 'properties_sides_in_cart';
    protected $fillable = [
        'usercart_id',
        'product_id',
        'property_id',
        'sides',
        'is_extra'
    ];
}
