<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery as ModelsDelivery;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DeliveryProfileController extends Controller
{
    public function delivery_profile(Request $request){
        $rules = [
            'delivery_boy_id'   => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('result' => false, 'msg' => $validator->errors()->first()));
        }

        $checkEmailExists = ModelsDelivery::where(['id' => $request->delivery_boy_id])->first();
        if($checkEmailExists)
        {
            return response()->json(['status' => true , 'msg' => 'Successfully', 'data'=> $checkEmailExists]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => 'No data found!']);
            exit;
        }
    }

    public function delivery_profile_upadte(Request $request)
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

                    $where = array('id' => $request->delivery_boy_id);
                    $data  = array( 'name' => $request->name ,
                                'email' => $request->email ,
                                'phone' => $request->phone ,
                                'image' => $favicon,
                                );
                    $update = ModelsDelivery::where($where)->update($data);
                }else
                {
                    $where = array('id' => $request->delivery_boy_id);
                    $data  = array( 'name' => $request->name ,
                                'email' => $request->email ,
                                'phone' => $request->phone ,

                                );
                    $update = ModelsDelivery::where($where)->update($data);
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

    public function delivery_change_password(Request $request) {

        $messages = [
            'password.required' => 'The new password field is required',
            'password.confirmed' => "Password does not match"
        ];
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'delivery_boy_id' => 'required|numeric'
        ], $messages);

        if($request->old_password == $request->password && $request->old_password == $request->password_confirmation)   {
            return response()->json(['status' => false , 'msg' => "Current password and new should be differend!"]);
            exit;
        }else{
            $oldPass = ModelsDelivery::where('id', $request->delivery_boy_id)->first();
            // if given old password matches with the password of this authenticated user...
            if(Hash::check($request->old_password, $oldPass->password)) {
                $oldPassMatch = 'matched';
            } else {
                $oldPassMatch = 'not_matched';
            }
            if ($validator->fails() || $oldPassMatch=='not_matched') {
                if($oldPassMatch == 'not_matched') {
                    //$validator->errors()->add('oldPassMatch', true);
                    return response()->json(['status' => false , 'msg' => "Password not Matched!"]);
                    exit;
                }
                return response()->json(['status' => false , 'msg' => "New Password and Confirmed Password not Matched!"]);
                exit;
            }
        }
        // updating password in database...
        $kitchen = ModelsDelivery::findOrFail($request->delivery_boy_id);
        $kitchen->password = bcrypt($request->password);
        $kitchen->update();

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
