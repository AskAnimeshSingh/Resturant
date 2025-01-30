<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * @var massassignement
     */
    protected $fillable = [
        'user_id',
        'city',
        'state',
        'house',
        'apartment',
        'cross_street',
        'instruction',
        'street',
        'zip_code',
        'cross_street',
        'block',
        'plot_no',
        'instruction',

    ];
}
