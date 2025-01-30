<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupons;

class CouponsController extends Controller
{
    public function getCoupons(){
        $coupons = Coupons::get();
        if (count($coupons) > 0){
            return response()->json([
                'status' => true,
                'message' => 'Coupons found!!',
                'data' => $coupons
            ], 201);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'No coupons found!!',
                'data' => null
            ], 401);
        }
    }
}
