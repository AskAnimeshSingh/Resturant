<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebOrder extends Model
{
    use HasFactory;

    protected $table = 'web_orders';
    protected $primaryKey   = "id";
    public $timestamps      = false;

    protected $fillable = [
        'product_id',
        'user_id',
        'qty',
        'price',
        'tax',
        'status',
        'payment_mode',
        'shipping_address',
        'pay_amount',
        'invoice_id',
        'txn_id',
        'coupon_code',
        'instruction',
        'delivery_type',
        'discount_value',
        'delivery_charge'
    ];

    public function delivery(){
        return $this->belongsTo(Delivery::class);
    }
}
