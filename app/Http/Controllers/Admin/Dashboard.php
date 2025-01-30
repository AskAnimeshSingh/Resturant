<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    /**
    *@return view dashboard
    */
    public function index()
    {
        
        return view('admin.dashboard');
    }
}
