<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'name',
        'branch_id',
        'email',
        'phone',
        'address',
    ];
}
