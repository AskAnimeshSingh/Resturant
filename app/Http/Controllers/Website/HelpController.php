<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function viewHelp()
    {
        $help = Help::first();
        
        return view('website.help', compact('help'));
    }
}
