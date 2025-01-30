<?php

namespace App\Http\Controllers\deliveryboy;

use App\Models\WebOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {   $status = WebOrder::where('delivery_id', Auth::guard('deliveryboy')->user()->id)->get();
        return view('deliveryboy.dashboard',compact('status'));
    }
}
