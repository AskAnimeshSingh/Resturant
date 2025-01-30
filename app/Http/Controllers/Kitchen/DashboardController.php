<?php

namespace App\Http\Controllers\Kitchen;

use App\Models\WebOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {

        $status = WebOrder::all();
        return view('kitchen.dashboard',compact('status'));
    }
}
