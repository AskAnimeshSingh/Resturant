<?php

namespace App\Http\Controllers\deliveryboy;

use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('deliveryboy.profile.profile');
    }

    /**
     * @param Request $request
     * @method use for update profile
     */
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name'     => 'required',
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
            if ($request->file('image') != "") {
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('/assets/admin/assets/img/delivery/'), $favicon);
                $favicon = "/assets/admin/assets/img/delivery/" . $favicon;

                $where = array('id' => Auth::guard('deliveryboy')->user()->id);
                $data  = array( 'name' => $request->name ,
                            'email' => $request->email ,
                            'phone' => $request->phone ,
                            'image' => $favicon,
                            );
                $update = Delivery::where($where)->update($data);
            }else
            {
                $where = array('id' => Auth::guard('deliveryboy')->user()->id);
                $data  = array( 'name' => $request->name ,
                            'email' => $request->email ,
                            'phone' => $request->phone ,

                            );
                $update = Delivery::where($where)->update($data);
            }




        }
        if($update)
        {
            return response()->json(['status' => true , 'msg' => "Profile updated successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occur try again later!"]);
            exit;
        }
    }

    public function changePassword() {
        return view('deliveryboy.profile.profile');
      }

      public function updatePassword(Request $request) {

        $messages = [
            'password.required' => 'The new password field is required',
            'password.confirmed' => "Password does not match"
        ];
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ], $messages);

       if($request->old_password == $request->password && $request->old_password == $request->password_confirmation)   {
        return response()->json(['status' => false , 'msg' => "Current password and new should be differend!"]);
                    exit;
       }else{
                // if given old password matches with the password of this authenticated user...
                if(Hash::check($request->old_password, Auth::guard('deliveryboy')->user()->password)) {
                    $oldPassMatch = 'matched';
                } else {
                    $oldPassMatch = 'not_matched';
                }
                if ($validator->fails() || $oldPassMatch=='not_matched') {
                    if($oldPassMatch == 'not_matched') {
                    //$validator->errors()->add('oldPassMatch', true);
                    return response()->json(['status' => false , 'msg' => "Password is not Matched!"]);
                    exit;
                    }
                    return response()->json(['status' => false , 'msg' => "New Password and Confirmed Password is not Matched!"]);
                    exit;
                }
            }
        // updating password in database...
        $kitchen = Delivery::findOrFail(Auth::guard('deliveryboy')->user()->id);
        $kitchen->password = bcrypt($request->password);
        $kitchen->update();

        // Session::flash('success', 'Password changed successfully!');
        // return redirect()->back();

        if($kitchen)
        {
            return response()->json(['status' => true , 'msg' => "Password updated successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occur try again later!"]);
            exit;
        }

      }
}
