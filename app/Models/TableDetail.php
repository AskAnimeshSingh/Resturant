<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_table_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'area',
        'table_num',
        'first_name',
        'last_name',
    ];
}
