<?php
namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\RegisterOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgetPassword', 'resetPassword', ]]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'password' => 'required|string|min:6',
            // 'phone' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        
        return response()->json(['status'=>true, 'message'=>"success" ,'Data'=>auth()->user()]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserProfile(Request $request) {
        
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|max:100|unique:users,email,'.Auth::user()->id,           
            'phone' => 'required|unique:users,phone,'.Auth::user()->id,
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user =Auth::user();
        if ($request->hasFile('profile_img')) {
            $ext = $request->file('profile_img')->getClientOriginalExtension();

            $name = substr(uniqid(), 0, 9) . '.' . $ext;
            $profile = 'public/assets/website/images/profile-image/' . $name;
            $request->file('profile_img')->move(public_path() . '/assets/website/images/profile-image/', $name);
        } else {
            $profile = $user->profile_image;
        }
        
        $user->name   = $request['name'];
        $user->email  = $request['email'];
        $user->phone  =  $request['phone'];       
        $user->profile_img  =  $profile;
         
        $user->save();
       
        return response()->json([
            'status' => true,
            'message' => 'Profile Updated',
            'user' => $user
        ], 201);
        
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    /**
     * @method use for update password
     */

    public function updatePassword(Request $request)
    {
        $validate  =Validator::make($request->all(),[
            'old_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        if($validate->fails())
        {            
            return response()->json(['status' => false, 'message' =>  $validate->errors()->first(), 'data'=> []]);
            exit;
        }else{

           $id =  Auth::user()->id;           
           $data = User:: find($id);           
           if((!Hash::check($request->old_password, $data->password))){
                return response()->json(['status' => false, 'message' => 'Old  Password is Incorrect !', 'data' =>[]]);
           }else{
            $data->password = Hash::make($request->password);
            $data->update();
                return response()->json(['status' => true, 'message' => 'password changed successfully !!', 'Data'=>[]]);
                exit;
            } 
        }
    }


    /**
     * @method use for forget password
     */
    public function forgetPassword(Request $request)
    {
        try{
        
            $validator = Validator::make($request->all(), [
                
                'email' => 'required|exists:users,email'                       
            ]);
            if($validator->fails()){
                return response()->json(['status' => false, 'message' => $validator->errors()->toJson(), 400]);
            }else{
                // $otp = random_int(100000, 999999);
                $otp = 123456;
                    $savedOtp = RegisterOtp::where('email',$request->email)->first();
                if(empty($savedOtp)){
                        $otpData =  new RegisterOtp();
                        $data['email'] = $request->email;
                        $data['otp'] = $otp;
                        $otpData->fill($data)->save();
                    }else{
                        $savedOtp->otp = $otp;
                        $savedOtp->save();                    
                    }

                    // $details = [
                    //     'subject' => 'Forget Password OTP',
                    //     'title'   => 'Forget Password',
                    //     'email'   =>  $request->email,
                    //     'otp'    => $otp,
                    //     'page'    => 'emails.user_otp_forget'
                    // ];
                    
                    // Mail::to($request->email)->send(new SendMail($details));
                    return response()->json(['status' => true, 'message' => 'OTP Send On Email', 'Data' => ['otp' => $otp]]);
                    exit();
            }
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!!', 'data' => '']);
            exit();
        }

    }

    /**
     * @method use for reset password
     */
    public function resetPassword(Request $request)
    {
        try{
            $validate = Validator::make($request->all(),[
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
                'email' => 'required|exists:users,email',
                'otp'  =>  'required|exists:register_otps,otp,email,'.$request->email,
            ]);
            
            if($validate->fails()){
                return response()->json(['status' => false, 'message' =>$validate->errors()->first(), 'data' => []]);
                exit;
            }else{
                
                $newPassword = User::where('email', $request->email)->update(['password' => Hash::make($request->new_password)]);
                if($newPassword){
                    return response()->json(['status' => true , 'message' => 'Success', 'Data' =>[]]);
                    exit();
                }else{
                    return response()->json(['status' => false, 'message' => 'Failed', 'data' => []]);
                    exit();
                }
            }
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!!!', 'data' => []]);
            exit;
        }
    }

}