<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homeDeliveryAddressesModel extends Model
{
    use HasFactory;

    protected $table = 'home_delivery_addresses';
    protected $primaryKey   = "id";
    public $timestamps      = false;

    protected $fillable = [
       'first_name',
       'last_name',
       'middle_name',
       'bussiness_name',
       'email',
       'phone',
       'city',
       'state',
       'house',
       'street',
       'apartment',
       'cross_street',
       'instruction',
       'user_id',
    ];
}
