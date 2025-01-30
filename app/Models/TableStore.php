<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableStore extends Model
{
    use HasFactory;

    protected $table = "tables";

    protected $fillable = [
        'name',
        'branch_id',
        'guest_capacity',
        'status'
    ];
}
