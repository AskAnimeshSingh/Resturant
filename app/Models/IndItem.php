<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndItem extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'name',
        'ind_grp_id',
        'unit'
    ];
}
