<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    /**
     * @var massassignment 
     */
    protected $fillable = [
        'name',
        'description',
        'created_by_id',
        'created_date',
        'image',
        'status'
    ];
}
