<?php

namespace App\Http\Controllers\deliveryboy;

use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeliveryBoyLoginController extends Controller
{
    public function index()
    {
        return view('deliveryboy.auth.login');
    }

    public function loginSubmit(Request $request)
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

        if (Auth::guard('deliveryboy')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return json_encode(['status' => true, 'msg' => "Success, Welcome Back!", 'location' => url('deliveryboy/dashboard')]);
            exit;

        } else {

            return response()->json(array('status' => false, 'msg' => "Credentials not matched !"));
            exit;
        }
    }

    public function logout()
    {
        $dboy = Auth::guard('deliveryboy')->user()->id;
        $input['updated_at'] = date('Y-m-d h:i:s');
        Delivery::where('id', $dboy)->update($input);
        Auth::guard('deliveryboy')->logout();
        return redirect('/deliveryboy');
    }
}
