<?php

namespace App\Http\Controllers\Kitchen;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('kitchen.auth.login');
    }

    public function logout()
    {
        $admin = Auth::guard('admin')->user()->id;
        $input['updated_at'] = date('Y-m-d h:i:s');
        Admin::where('id', $admin)->update($input);
        Auth::guard('admin')->logout();
        return redirect('/kitchen');
    }
}
