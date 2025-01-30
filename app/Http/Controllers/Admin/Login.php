<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    /**
     * @return view login form
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    /**
     * @param Request $request
     * @method use for admin login
     */
    public function loginSubmit(Request $request)
    {
        // print_r($request->all());
        // exit;
        $rules = [
            'email'   => 'required|exists:admins,email|email',
            'password' => 'required|min:6'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('result' => false, 'msg' => $validator->errors()->first()));
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'kitchen'])) {
            return json_encode(['status' => true, 'msg' => "Success, Welcome Back!", 'location' => url('kitchen/dashboard')]);
            exit;
            //             return redirect()->intended('/admin/dashboard');
        }elseif (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            
            return json_encode(['status' => true, 'msg' => "Success, Welcome Back!", 'location' => url('admin/dashboard')]);
            exit;
        } else {

            return response()->json(array('status' => false, 'msg' => "Credentials not matched !"));
            exit;
        }
    }


    /**
     * @return view forget password
     */
    public function forgetPassword()
    {
        return view('admin.auth.forget_password');
    }

    /**
     * @return view reset password
     */
    public function resetPassword()
    {
        return view('admin.auth.reset_password');
    }

     /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        $admin = Auth::guard('admin')->user()->id;
        $input['updated_at'] = date('Y-m-d h:i:s');
        Admin::where('id', $admin)->update($input);
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
