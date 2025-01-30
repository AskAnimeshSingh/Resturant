<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Delivery extends Authenticatable

{
    use HasFactory;
    protected $table = 'deliveries';

    /**
     * @var massassignment
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'branch_id',
        'image',
        'status'
    ];

    public function web_orders(){
        return $this->hasMany(WebOrder::class,'delivery_id');
    }
}
