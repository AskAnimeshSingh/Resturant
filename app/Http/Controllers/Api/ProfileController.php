<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function get_addresses(Request $request){
        $rules = [
            'user_id' => 'required|numeric'
        ];
        $msg = [
            'user_id.required' => 'User ID required',
        ];

        $validator = Validator::make($request->all() , $rules , $msg);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit();
        }
        else
        {
            $getPhone = ModelsUser::where('id', $request->user_id)->first();
            if(empty($getPhone)){
                return response()->json(['status' => false , 'msg' => 'User ID is invalid!!']);
                exit();
            }

            $addressData = UserAddress::where('user_id', $request->user_id)->get();

            if ($addressData) {
                return response()->json([
                    'status' => true,
                    'message' => 'Address List',
                    'data' => $addressData
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Available',
                    'data' => '',
                ], 401);
            }
        }
    }


    public function add_address(Request $request)
    {
        $validator = Validator::make($request->all() ,  [
            'city'          => 'required',
            'state'         => 'required',
            'house'         => 'required',
            'street'        => 'required',
            'apartment'     => 'required',
            'cross_street'  => 'required',
            'user_id'       => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {
            $getUserDetails = ModelsUser::where('id', $request->user_id)->first();
            if(empty($getUserDetails)){
                return response()->json(['status' => false , 'msg' => 'User ID is invalid!!']);
                exit();
            }

            $data                   = new UserAddress();
            $input['user_id']       = $request->user_id;
            $input['city']          = $request->city;
            $input['state']         = $request->state;
            $input['house']         = $request->house;
            $input['street']        = $request->street;
            $input['apartment']     = $request->apartment;
            $input['cross_street']  = $request->cross_street;
            $input['instruction']   = $request->instruction;

            $result = $data->fill($input)->save();
        }

        if($result) {
            return response()->json(['status' => true , 'msg' => "User address store successfully"]);
            exit;
        }else{
            return response()->json(['status' => false , 'msg' => "Something went wrong try again later"]);
            exit;
        }
    }



    public function update_address(Request $request)
    {
        $validator = Validator::make($request->all() ,  [
            'city'          => 'required',
            'state'         => 'required',
            'house'         => 'required',
            'street'        => 'required',
            'apartment'     => 'required',
            'cross_street'  => 'required',
            'user_id'       => 'required',
            'address_id'       => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {
            $getUserDetails = ModelsUser::where('id', $request->user_id)->first();
            if(empty($getUserDetails)){
                return response()->json(['status' => false , 'msg' => 'User ID is invalid!!']);
                exit();
            }

            $data                   = UserAddress::where(['id' => $request->address_id])->first();;
            $input['user_id']       = $request->user_id;
            $input['city']          = $request->city;
            $input['state']         = $request->state;
            $input['house']         = $request->house;
            $input['street']        = $request->street;
            $input['apartment']     = $request->apartment;
            $input['cross_street']  = $request->cross_street;
            $input['instruction']   = $request->instruction;

            $result = $data->fill($input)->update();
        }

        if($result) {
            return response()->json(['status' => true , 'msg' => "User address updated successfully"]);
            exit;
        }else{
            return response()->json(['status' => false , 'msg' => "Something went wrong try again later"]);
            exit;
        }
    }

    public function delete_address(Request $request)
    {
        try {
            $delete = UserAddress::where(['id' => $request->address_id])->delete();
            if($delete) {
                return response()->json(['status' => true , 'msg' => "user address deleted successfully"]);
                exit;
            }else{
                return response()->json(['status' => false , 'msg' => "something went wrong try again later"]);
                exit;
            }
        } catch (Exception $e) {
            return response()->json(['status' => false , 'msg' => "something went wrong try again later"]);
            exit;
        }
    }


    public function userProfileUpdate(Request $request)
    {
        $rules = [
            'name'     => 'required',
//            'email'     => 'required',
            // 'dob'     => 'required',
            'age'     => 'required',
            'address'    => 'required',
            'user_id'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        }

        $getUserDetails = ModelsUser::where('id', $request->user_id)->first();
        if(empty($getUserDetails)){
            return response()->json(['status' => false , 'msg' => 'User ID is invalid!!']);
            exit();
        }

        $data = ModelsUser::where(['id' => $request->user_id])->first();
        $data->name     = $request->name ;
        $data->email    = $request->email ;
        $data->password = $request->password ;
        // $data->phone    = $request->phone ;
        $data->dob      = date('Y-m-d',strtotime($request->dob));
        $data->age      = $request->age;
        $data-> address  = $request->address;

        $update = $data->update();

        if($update)
        {
            return response()->json(['status' => true , 'msg' => "Profile saved successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occur try again later!"]);
            exit;
        }
    }

    public function userProfileDetails(Request $request)
    {
        $rules = [
            'user_id'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        }

        $getUserDetails = ModelsUser::where('id', $request->user_id)->first();
        if(empty($getUserDetails)){
            return response()->json(['status' => false , 'msg' => 'User ID is invalid!!']);
            exit();
        }else{
            return response()->json(['status' => true , 'msg' => "Profile Found", 'data' => $getUserDetails]);
            exit;
        }
    }



}
