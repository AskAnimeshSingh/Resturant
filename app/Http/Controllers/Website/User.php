<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BookingTable;
use App\Models\HomeDeliveryAddress;
use App\Models\PickupAddress;
use App\Models\User as ModelsUser;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Controller
{
    /**
     * @param Request $request
     * @method use for user login
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'phone'     => 'required',
            'password'  => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $checkPhoneExists = ModelsUser::orWhere(['person_id' => $request->phone])
                                ->orWhere(['email' => $request->phone])
                                ->orWhere(['phone' => $request->phone])
                                ->first();
            if($checkPhoneExists)
            {
                if (Hash::check($request->password, $checkPhoneExists->password)) {
                    if (Auth::loginUsingId($checkPhoneExists->id)) {
                        return json_encode(['status' => true, 'msg' => "Successfully loggedIn!", 'location' => url('') . '/pos-detail']);
                        exit;
                    } else {
                        return json_encode(['status' => false, 'msg' => "Something went wrong!!!"]);
                        exit;
                    }
                }else{
                    return response()->json(['status' => false , 'msg' => 'Your password is wrong!']);
                    exit;
                }
            }
            else
            {
                return response()->json(['status' => false , 'msg' => 'Your Person Id or Email or Phone number doesnot match!']);
                exit;
            }
        }


    }

    /**
     * @param Request $request
     * @method use for verify otp
     */
    public function otp_verify(Request $request)
    {

        $rules = [
            'f' => 'required',
            's' => 'required',
            't' => 'required',
            'l' => 'required',
        ];
        $msg = [
            'f.required' => 'Otp required',
            's.required' => 'Otp required',
            't.required' => 'Otp required',
            'l.required' => 'Otp required',
        ];

        $validator = Validator::make($request->all() , $rules , $msg);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit();
        }
        else
        {
            $getPhone = ModelsUser::findOrFail($request->user_id);

            $otpVerify = $request->f.$request->s.$request->t.$request->l;

            if($getPhone->otp_verify == $otpVerify)
            {
                if (Auth::loginUsingId($request->user_id)) {
                    return json_encode(['status' => true, 'msg' => "Success, Welcome Back!", 'location' => url('') . '/pos-detail']);
                    exit;
                } else {
                    return json_encode(['status' => false, 'msg' => "Something went wrong!!!"]);
                    exit;
                }
            }
            else
            {
                return json_encode(['status' => false, 'msg' => "OTP do not match !!!"]);
                exit;
            }


        }
    }

    /**
     * @param Request $request
     * @method use for Logout
     */
    public function logout(Request $request)
    {

        $admin = Auth::user()->id;

        $input['updated_at'] = date('Y-m-d h:i:s');
        ModelsUser::where('id', $admin)->update($input);
        Auth::logout();
        return redirect('/');
    }


    /**
     * @param Request $request
     * @method use for Logout
     */
    public function addUserAddress(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $userAddress = UserAddress::where(['user_id' => Auth::user()->id])->get();
            if(count($userAddress) > 0){
                return redirect(route('website.pos_detail'));
            }
        }
        return view('website.add_user_address');
    }

    /**
     * @param Request $request
     * @method use for user home address store
     */
    public function userAddressAdd2(Request $request)
    {
        if(Auth::user()) {
            $validator = Validator::make($request->all() , [
                'house'    => 'required|min:3',
                'apartment'     => 'required',
                'street'  => 'required',
                'city'          => 'required',
                'state'         => 'required',
                'zip_code'         => 'required',
                'cross_street'        => 'required',
                'block'        => 'required',
                'plot_no'        => 'required',

            ]);

            if($validator->fails())
            {
                return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
                exit;
            }
            else
            {
                $data                       = new UserAddress();
                $input['user_id']        = Auth::user()->id;;
                $input['house']         = $request->house;
                $input['apartment']       = $request->apartment;
                $input['street']    = $request->street;
                $input['city']             = $request->city;
                $input['state']             = $request->state;
                $input['zip_code']              = $request->zip_code;
                $input['cross_street']             = $request->cross_street;
                $input['block']             = $request->block;
                $input['plot_no']            = $request->plot_no;
                $result = $data->fill($input)->save();


            }

            if($result)
            {
                return response()->json(['status' => true , 'msg' => 'Address Save !!']);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => 'Something went wrong try again later !!']);
                exit;
            }
        }
        else
        {
            return response()->json(['status' => false , 'msg' => 'First login then you can add your address!']);
            exit;
        }

    }

    public function homeAddress(Request $request)
    {
        if(Auth::user()) {
            $validator = Validator::make($request->all() , [
                'first_name'    => 'required|min:3',
                'last_name'     => 'required',
                'phone_number'  => 'required',
                'city'          => 'required',
                'state'         => 'required',
                'house'         => 'required',
                'street'        => 'required',
            ]);

            if($validator->fails())
            {
                return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
                exit;
            }
            else
            {
                $checkAdd = HomeDeliveryAddress::where(['user_id' => Auth::user()->id])->first();

                if($checkAdd)
                {
                    $getHomeAdd                 = HomeDeliveryAddress::where(['user_id' => Auth::user()->id])->first();
                    $getHomeAdd->first_name     = $request->first_name;
                    $getHomeAdd->last_name      = $request->last_name;
                    $getHomeAdd->middle_name    = $request->middle_name;
                    $getHomeAdd->bussiness_name = $request->bussiness_name;
                    $getHomeAdd->email          = $request->email_address;
                    $getHomeAdd->phone          = $request->phone_number;
                    $getHomeAdd->city           = $request->city;
                    $getHomeAdd->state          = $request->state;
                    $getHomeAdd->house          = $request->house;
                    $getHomeAdd->apartment      = $request->apartment;
                    $getHomeAdd->cross_street   = $request->cross_street;
                    $getHomeAdd->instruction    = $request->instruction;
                    $result = $getHomeAdd->update();

                }
                else
                {
                    $data                       = new HomeDeliveryAddress();
                    $input['first_name']        = $request->first_name;
                    $input['last_name']         = $request->last_name;
                    $input['middle_name']       = $request->middle_name;
                    $input['bussiness_name']    = $request->bussiness_name;
                    $input['email']             = $request->email_address;
                    $input['phone']             = $request->phone_number;
                    $input['city']              = $request->city;
                    $input['state']             = $request->state;
                    $input['house']             = $request->house;
                    $input['street']            = $request->street;
                    $input['apartment']         = $request->apartment;
                    $input['cross_street']      = $request->cross_street;
                    $input['instruction']       = $request->instruction;
                    $input['user_id']           = Auth::user()->id;
                    $result = $data->fill($input)->save();
                }
            }

            if($result)
            {
                return response()->json(['status' => true , 'msg' => 'Address Save !!']);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => 'Something went wrong try again later !!']);
                exit;
            }
        }
        else
        {
            return response()->json(['status' => false , 'msg' => 'First login then you can add your address!']);
            exit;
        }

    }

    /**
     * @param Request $request
     * @method use for store pickup address
     */
    public function pickupAddress(Request $request)
    {
        if(Auth::user()) {
            $validator = Validator::make($request->all() , [
                'store_location'    => 'required',
                'first_name'        => 'required',
                'last_name'         => 'required',
                'phone'             => 'required',
            ]);
            if($validator->fails())
            {
                return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
                exit;
            }
            else
            {
                $checkAdd = PickupAddress::where(['user_id' => Auth::user()->id])->first();

                if($checkAdd)
                {
                    $getPickup                  = PickupAddress::where(['user_id' => Auth::user()->id])->first();
                    $getPickup->first_name      = $request->first_name;
                    $getPickup->last_name       = $request->last_name;
                    $getPickup->store_location  = $request->store_location;
                    $getPickup->email           = $request->email;
                    $getPickup->phone           = $request->phone;
                    $result = $getPickup->update();
                }
                else
                {
                    $data                       = new PickupAddress();
                    $input['store_location']    = $request->store_location;
                    $input['first_name']        = $request->first_name;
                    $input['last_name']         = $request->last_name;
                    $input['email']             = $request->email;
                    $input['phone']             = $request->phone;
                    $input['user_id']           = Auth::user()->id;
                    $result = $data->fill($input)->save();
                }
            }
            if($result)
                {
                    return response()->json(['status' => true , 'msg' => 'Pickup address Save !!']);
                    exit;
                }
                else
                {
                    return response()->json(['status' => false , 'msg' => 'Something went wrong try again later !!']);
                    exit;
                }
        }else{
            return response()->json(['status' => false , 'msg' => 'First login then you can save/update your address !!']);
                    exit;
        }

    }

    public function profileSubmit(Request $request)
    {
        $rules = [
            'name'     => 'required',
            'email'     => 'required',
            // 'dob'     => 'required',
            'age'     => 'required',
            'address'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        }

        $data = ModelsUser::where(['id' => Auth::guard('web')->user()->id])->first();
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

    /**
     * @method use for store use address
     */
    public function userAddressAdd(Request $request)
    {
        $validator = Validator::make($request->all() ,  [
            'house'    => 'required|min:3',
            'apartment'     => 'required',
            'street'  => 'required',
            'city'          => 'required',
            'state'         => 'required',
            'zip_code'         => 'required',
            'cross_street'        => 'required',
            'block'        => 'required',
            'plot_no'        => 'required',
            // 'instruction'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

            // $data                   = new UserAddress();
            // $input['user_id']       = Auth::user()->id;
            // $input['city']          = $request->city;
            // $input['state']         = $request->state;
            // $input['house']         = $request->house;
            // $input['street']        = $request->street;
            // $input['apartment']     = $request->apartment;
            // $input['cross_street']  = $request->cross_street;
            // $input['instruction']   = $request->instruction;

            // $result = $data->fill($input)->save();

            $data                       = new UserAddress();
            $input['user_id']        = Auth::user()->id;;
            $input['house']         = $request->house;
            $input['apartment']       = $request->apartment;
            $input['street']    = $request->street;
            $input['city']             = $request->city;
            $input['state']             = $request->state;
            $input['zip_code']              = $request->zip_code;
            $input['cross_street']             = $request->cross_street;
            $input['block']             = $request->block;
            $input['plot_no']            = $request->plot_no;
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

    /**
     * @method use for get user address
     */
    public function getUserAddress(Request $request)
    {
        $data = UserAddress::where(['user_id' => Auth::user()->id])->get();
        return response()->json(['status' => true , 'data' => $data]);
    }

    /**
     * @method use for delete use
     */
    public function removeAddress(Request $request)
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

    /**
     * @method use for update_address
     */
    public function update_address(Request $request)
    {
        $validator = Validator::make($request->all() ,  [
            'city'          => 'required',
            'state'         => 'required',
            'house'         => 'required',
            'street'        => 'required',
            'apartment'     => 'required',
            'cross_street'  => 'required',
            // 'instruction'   => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else {

           $where = array('id' => $request->address_id);
           $data  = array('city' => $request->city , 'state' => $request->state , 'house' => $request->house ,
            'street' => $request->street , 'apartment' => $request->apartment , 'cross_street' => $request->cross_street ,
            'instruction' => $request->instruction
            );

            $result = UserAddress::where($where)->update($data);
        }

        if($result) {
            return response()->json(['status' => true , 'msg' => "User address update successfully"]);
            exit;
        }else{
            return response()->json(['status' => false , 'msg' => "Something went wrong try again later"]);
            exit;
        }
    }
}
