<?php

namespace App\Http\Controllers\Kitchen;

use App\Models\WebOrder;
use App\Models\Chef;
use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    // public function index()
    // {

    //     $status = WebOrder::all();
    //     return view('kitchen.dashboard',compact('status'));
    // }
    public function index()
    {
        // Fetch all orders
        $status = WebOrder::all();
    
        // Fetch pending and cooking orders with required joins
        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
            'user_addresses.city',
            'user_addresses.state',
            'user_addresses.house',
            'user_addresses.street',
            'user_addresses.apartment',
            'user_addresses.cross_street',
        )
            ->leftJoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftJoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftJoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->whereIn('web_orders.status', ['PENDING', 'COOKING'])
            ->orderBy('web_orders.id', 'DESC')
            ->get();
    
        // Fetch chefs and delivery boys
        $chefs = Chef::all();
        $dboys = Delivery::all();
        // dd($groups, $chefs, $dboys);
        return view('kitchen.dashboard', compact('status', 'groups', 'chefs', 'dboys'));
    }
    

}
