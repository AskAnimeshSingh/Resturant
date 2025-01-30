<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertiesItems extends Model
{
    use HasFactory;
    protected $table = 'properties_items';
    protected $fillable = [
        'properties_id',
        'name',
        'price',
        'is_multiple',
        'status',
    ];
}
