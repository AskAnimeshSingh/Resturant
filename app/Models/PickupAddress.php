<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupAddress extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'store_location',
        'first_name',
        'last_name',
        'email',
        'phone',
        'user_id'
    ];
}
