<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'phone',
        'bio',
        'birthday',
        'img',
        'store_location',
        'type',
        'branch_id',
        'status'
    ];
}
