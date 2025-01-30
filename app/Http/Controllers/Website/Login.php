<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User as ModelsUser;

class Login extends Controller
{
     /**
     * @return view Login
     */

    public function index()
    {
        if (Auth::guard('web')->check()) {
                return redirect(route('website.pos_detail'));
        }
       return view('website.login');
    }

    public function register()
    {
        if (Auth::guard('web')->check()) {
                return redirect(route('website.pos_detail'));
        }
       return view('website.register');
    }


    public function registerProcess(Request $request){
            $validator = Validator::make($request->all() , [
                'person_id'    => 'required|unique:users,person_id',
                'first_name'    => 'required',
                'last_name'     => 'required',
                'phone_number'  => 'required|unique:users,phone',
                'email'          => 'required|email|unique:users,email',
                'password'         => 'required|confirmed|min:6',
            ]);

            if($validator->fails())
            {
                return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
                exit;
            }
            else
            {

                    $data                       = new ModelsUser();
                    $data->name      = $request->first_name.' '.$request->last_name;
                    $data->person_id       = $request->person_id;
                    $data->email       = $request->email;
                    $data->password     = Hash::make($request->password);
                    $data->phone  = $request->phone_number;
                    $result = $data->save();
            }

            if($result)
            {
                if (Auth::loginUsingId($data->id)) {
                    return json_encode(['status' => true, 'msg' => "Successfully registered!", 'location' => url('') . '/pos-detail']);
                    exit;
                } else {
                    return json_encode(['status' => false, 'msg' => "Something went wrong!!!"]);
                    exit;
                }
            }
            else
            {
                return response()->json(['status' => false , 'msg' => 'Something went wrong try again later !!']);
                exit;
            }
    }

    /**
     * @return view Otp Form
     */
    public function opt_view(Request $request)
    {
        $id = $request->id;
        return view('website.otp' , compact('id'));
    }
}
