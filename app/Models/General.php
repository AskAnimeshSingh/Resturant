<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    use HasFactory;

    protected $fillable = [
             'name',
            'address',
            'phone',
            'back_logo_colo',
            'back_foot_colo',
            'text_colo',
            'image',
            'favicon',
            'tax',
            'discount',
            'bill_header',
            'bill_footer',
            'web_footer',
            'print_detail',
            'sound',
            'selection'

    ];
}
