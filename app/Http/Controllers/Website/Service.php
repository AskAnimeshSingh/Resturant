<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Service extends Controller
{
    /**
     * @return view Service
     */

    public function index()
    {
       return view('website.contact');
    }
}
