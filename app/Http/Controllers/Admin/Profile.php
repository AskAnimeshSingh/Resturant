<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Profile extends Controller
{
    /**
     * @return view profile
     */
    public function index()
    {
        return view('admin.profile.profile');
    }

    /**
     * @param Request $request
     * @method use for update profile
     */
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'fname'     => 'required',
            'lname'     => 'required',
            'email'     => 'required',
            'phone'     => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $where = array('id' => Auth::guard('admin')->user()->id);
            $data  = array( 'fname' => $request->fname , 
                            'lname' => $request->lname , 
                            'email' => $request->email , 
                            'phone' => $request->phone ,
                            'bio'   => $request->bio);
            $update = Admin::where($where)->update($data);
            

        }
        if($update)
        {
            return response()->json(['status' => true , 'msg' => "Profile update successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occur try again later!"]);
            exit;
        }
    }
}
