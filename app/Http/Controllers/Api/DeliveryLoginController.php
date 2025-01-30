<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery as ModelsDelivery;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DeliveryLoginController extends Controller
{
    public function delivery_login(Request $request)
    {
        // print_r($request->all());
        // exit;
        $rules = [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('result' => false, 'msg' => $validator->errors()->first()));
        }

        $checkEmailExists = ModelsDelivery::where(['email' => $request->email])->first();
            if($checkEmailExists)
            {
                if (Hash::check($request->password, $checkEmailExists->password)){
                    return response()->json(['status' => true , 'msg' => 'Successfully', 'data'=> $checkEmailExists]);
                    exit;
                }else{
                    return response()->json(['status' => false , 'msg' => 'Password didnot match!!']);
                    exit;
                }
            }
            else
            {
                return response()->json(['status' => false , 'msg' => 'Email Id not found!']);
                exit;
            }
    }
}
