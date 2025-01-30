<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Blog extends Controller
{
    /**
     * @return view Blog
     */

    public function index()
    {
       return view('website.blog');
    }
}
