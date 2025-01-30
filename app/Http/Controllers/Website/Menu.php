<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Menu extends Controller
{
    /**
     * @return view Menu
     */

    public function index()
    {
       return view('website.menu');
    }
}
