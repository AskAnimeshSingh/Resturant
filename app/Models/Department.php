<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'name',
        'commission',
        'status'
    ];
}
