<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use App\Models\Branches;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserLoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'phone'     => 'required|min:10|max:10',
            'country_code'     => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $checkPhoneExists = ModelsUser::where('phone', $request->phone)->where('country_code',$request->country_code)->first();
            $otp                            = 1234;
            if($checkPhoneExists)
            {
                $checkPhoneExists->otp_verify   = $otp;
                $result                         = $checkPhoneExists->update();

                if ($result) {
                    try {
                        $msg = "Your one time password :" . $otp;
                        $recipient = $request->country_code.$request->phone;
                        $this->sendMessage($msg, $recipient);
                    } catch (Exception $e) {

                    }
                }

                if($result)
                {
                    return response()->json(['status' => true , 'msg' => 'Otp send your phone number', 'data'=> $checkPhoneExists]);
                    exit;
                }
                else
                {
                    return response()->json(['status' => false , 'msg' => 'Something went wrong Try again later!!']);
                    exit;
                }
            }
            else
            {
 
                    return response()->json(['status' => false , 'msg' => 'User does not exist. Please register first!!']);
                    exit;
                
            }
        }

    }

    public function otp_verify(Request $request)
    {

        $rules = [
            'otp' => 'required|min:4|max:4',
            'user_id' => 'required|numeric'
        ];
        $msg = [
            'otp.required' => 'Otp required',
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

            $otpVerify = $request->otp;
            // dd($otpVerify);
            if($getPhone->otp_verify == $otpVerify)
            {

                $token = $getPhone->createToken('otp-token')->plainTextToken;

                return response()->json(['status' => true, 'msg' => "Success, Welcome Back!", 'data' => $getPhone,'token' =>$token ]);
                exit;
            }
            else
            {
                return response()->json(['status' => false, 'msg' => "OTP do not match !!!"]);
                exit;
            }


        }
    }

    public function signup(Request $request)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'username' => 'required|min:3',
                'country_code' => 'required',
                'mobile' => 'required|min:10|max:10|unique:users,phone',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                return response()->json(['status' => false, 'msg' => $errors]);
                
            }
            // dd($request->all()  );
            // $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // // Initialize Twilio client
            // $twilio = new \Twilio\Rest\Client(config('services.twilio.sid'), config('services.twilio.auth_token'));

            // // Send SMS
            // $phoneNumber = '+919548411029'; // Replace with the actual phone number
            // $twilio->messages->create(
            //     $phoneNumber,
            //     [
            //         'from' => config('services.twilio.phone_number'),
            //         'body' => "Your OTP is: $otp"
            //     ]
            // );

            // $otpe = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $user = new ModelsUser();
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->name = $request->input('username');
            // $user->f_token = $request->input('f_token');
            $user->phone = $request->mobile;
            // $user->type = '0';
            // $user->status = '1';
            $user->otp_verify = 1234;
            // $user->email_otp = $otpe;
            $user->country_code = $request->country_code;
            $user->save();

           

            // return $this->apiResponse(true, 'success', ['token' => $token, 'user' => $user]);

            // $twilio = new \Twilio\Rest\Client(config('services.twilio.sid'), config('services.twilio.auth_token'));

            // // Send SMS
            // $message = $twilio->messages->create(
            //     '+919548411029',
            //     [
            //         "body" => "Test message",
            //         "from" => config('services.twilio.phone_number')
            //     ]
            // );

            // return $this->apiResponse(true, 'success', ['user' => $user]);
            return response()->json(['status' => true, 'msg' => "Success", 'data' => $user]);
            
        } catch (\Illuminate\Database\QueryException $e) {
            // dd($e);
            return response()->json(['status' => false, 'msg' => $e]);

        }
    }

    public function resendOtp(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|min:10|max:10',
                'country_code' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                return response()->json(['status' => false, 'msg' => $errors]);
                
            }
            else{
                $getuser = ModelsUser::where('phone',$request->mobile)->where('country_code',$request->country_code)->first();
                if($getuser){
                    $getuser->otp_verify = 7072;
                    $getuser->save();
                    return response()->json(['status' => true, 'msg' => 'Otp send successfully']);   
                }
                else{
                    return response()->json(['status' => false, 'msg' => 'User does not exist']);   
                }
            }

        }
        catch(\Illuminate\Database\QueryException $e) {
            // dd($e);
            return response()->json(['status' => false, 'msg' => $e]);

        }
    }
    
    public function loginEmail(Request $request)
    {
        
            $validator = Validator::make($request->all(), [
                'email'  => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Please Enter Password.',
                'email.email' => 'Invalid Email Format.',
                'password.required' => 'Please Enter Password.',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();

                return response()->json(['status' => false, 'msg' => $errors]);
            }

            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                
                    $user = Auth::user();
                    $token = $request->user()->createToken('api-token')->plainTextToken;
                return response()->json(['status' => true, 'token' => $token, 'user' => $user]);

 
            } else {

                return response()->json(['status' => false, 'msg' =>'Invalid Password. Please try again!!']);

            }

    }
    public function forgetPassword(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email'  => 'required|email',
                // 'password' => 'required',
            ], [
                'email.required' => 'Please Enter E-mail.',
                // 'email.email' => 'Invalid Email Format.',
                // 'password.required' => 'Please Enter Password.',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                
                return response()->json(['status' => false, 'msg' => $errors]);
            }
            else{
                $getdata =  ModelsUser::where('email',$request->email)->first();
                if($getdata){
                    $getdata->otp_email = 4567; 
                    $getdata->save();
                    return response()->json(['status' => true, 'msg' => "Otp send on your email successfully!!"]);
                }
                else{
                    return response()->json(['status' => false, 'msg' => "User does not exist!!"]);
                    
                }
            }
        }
        catch (\Illuminate\Database\QueryException $e) {
            // dd($e);
            return response()->json(['status' => false, 'msg' => $e]);

        }
    }

    public function checkMailOtp(Request $request){
        try{
            $getdata =  ModelsUser::where('email',$request->email)->first();
            if($getdata){
                if($getdata->otp_email == $request->otp)
                {
                    return response()->json(['status' => true, 'msg' => "Correct otp set new password now"]);
                }
                else{
                    return response()->json(['status' => false, 'msg' => "Wromg Otp!!"]);
                }
        }
        else{
            return response()->json(['status' => false, 'msg' => "User does not exist!!"]);
        }
        }
        catch(\Illuminate\Database\QueryException $e){
            // dd($e);
            return response()->json(['status' =>false, 'msg' => $e ]);
        }
    }


    public function updatePassword(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                // 'old_password'  => 'required',  
                'password' => 'required',
                'c_password' => 'required|same:password',
            ], [
                // 'old_password.required' => 'Please Enter Old Password.',
                'password.required' => 'Please Enter Password.',
                'c_password.required' => 'Please Confirm Password.',
                'c_password.same' => 'The password and confirm password must match.',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                
                return response()->json(['status' => false, 'msg' => $errors]);
            }
            else{
                $getdata =  ModelsUser::where('email',$request->email)->first();
                
                // if (Hash::check($request->old_password, $getdata->password)) {
                   
                    $getdata->password = bcrypt($request->password); 
                    $getdata->save();
                
                    return response()->json(['status' => true, 'msg' => 'Password updated successfully']);
                } 
                

            // }
        }
        catch(\Illuminate\Database\QueryException $e){
            // dd($e);
            return response()->json(['status' =>false, 'msg' => $e ]);
        }
    }
    public function getUserData(Request $request)
    {
        // Authenticate the user using the provided token
        if (!$user = Auth::guard('sanctum')->user()) {
            return response()->json(['status' => false, 'msg' => 'Unauthorized'], 401);
        }

        // User is authenticated, return user data
        return response()->json(['status' => true, 'user' => $user]);
    }


    public function getBranches(Request $request){
       
        $branch= Branches::where('status',1)->get();
        
        return response()->json(['status' => true, 'branch' => $branch]);
    }

    public function emailResendotp(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email'  => 'required|email',
                // 'password' => 'required',
            ], [
                'email.required' => 'Please Enter E-mail.',
                
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                
                return response()->json(['status' => false, 'msg' => $errors]);
            }
            else{
                $getdata =  ModelsUser::where('email',$request->email)->first();
                if($getdata){
                $getdata->otp_email = 9876;
                $getdata->save();
                return response()->json(['status' => true, 'msg' => 'Otp send successfully!!']);
                
            }
                else{
                    return response()->json(['status' => false, 'msg' => 'E-mail does not exists!!']);
                }
            }   
        }
        catch(\Illuminate\Database\QueryException $e){
            // dd($e);
            return response()->json(['status' =>false, 'msg' => $e ]);
        }
    }
    public function uodateUser(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name'  => 'required',
                // 'password' => 'required',
            ], [
                'name.required' => 'Please Enter Name.',
                
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                
                return response()->json(['status' => false, 'msg' => $errors]);
            }
            else{
                
               $userData =  ModelsUser::find(Auth::id());
               if($userData){
                $userData->name = $request->name;
                
                if(!empty($request->gender)){
                    $userData->gender = $request->gender;
                }

                if(!empty($request->dob)){
                    $userData->dob = $request->dob;
                }

                if ($request->hasFile('image')) {
                    $image = uniqid(time()) . '.' . $request->file('image')->extension();
                    $request->file('image')->move(public_path('assets/userProfile/'), $image);
                    $userData->image = "/public/assets/userProfile/" . $image;
                    
                }
                    $userData->save();
                return response()->json(['status' =>true, 'msg' =>'User updated successfully!!', 'data' =>$userData ]);
            }
               else{
            return response()->json(['status' =>false, 'msg' =>'User does not exist!!' ]);

               }
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            // dd($e);
            return response()->json(['status' =>false, 'msg' => $e ]);
        }
    }


    public function updatePhone (Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'phone'  => 'required|min:10|max:10|unique:users,phone',
                'country_code'  => 'required',
                
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                
                return response()->json(['status' => false, 'msg' => $errors]);
            }
            else{
                $userData =  ModelsUser::find(Auth::id());
                   if($userData){
                    $userData->phone = $request->phone; 
                    $userData->country_code = $request->country_code; 
                    $userData->otp_verify = 1234; 
                    
                    $userData->save();
                    return response()->json(['status' => true, 'msg' => "Otp send successfull on updated phone nunmber!!!", 'data' =>  $userData ]);

                   }else{
                return response()->json(['status' =>false, 'msg' => "User dose notexist!!" ]);

                   }
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            // dd($e);
            return response()->json(['status' =>false, 'msg' => $e ]);
        }

    }

    public function updateEmail (Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email'  => 'required',
                
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                
                return response()->json(['status' => false, 'msg' => $errors]);
            }
            else{

                $userData =  ModelsUser::find(Auth::id());
                   if($userData){
                    $userData->email = $request->email; 
                    $userData->otp_email = 1234; 
                    
                    $userData->save();
                    return response()->json(['status' => true, 'msg' => "Otp send successfull on updated email!!!", 'data' =>  $userData ]);

                   }else{
                return response()->json(['status' =>false, 'msg' => "User dose notexist!!" ]);

                   }
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            // dd($e);
            return response()->json(['status' =>false, 'msg' => $e ]);
        }

    }


}
