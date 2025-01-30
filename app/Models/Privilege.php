<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = [

        'staff_id',
        'module',
        'submodule',
        'access',
        'add',
        'edit',
        'delete',
        'status'
    ];
}
