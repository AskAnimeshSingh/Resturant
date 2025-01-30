<?php

namespace App\Http\Controllers\Admin;

use App\Models\Help;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HelpController extends Controller
{
    public function index()
    {
        return view('admin.help.index');
    }

    public function storeHelp(Request $request)
    {
        $validator = Validator::make($request->all() , [
            // 'name'  => 'required',
            'email'  => 'required',
            'phone'  => 'required',
            'description'  => 'required',


        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {


            $data = new Help();
            $data->user_id = Auth::guard('admin')->user()->id;
            // $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->description = $request->description;
            $save = $data->save();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Help Saved Successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

}
