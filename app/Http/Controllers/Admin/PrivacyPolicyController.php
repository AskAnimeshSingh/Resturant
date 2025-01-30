<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Validator;

class PrivacyPolicyController extends Controller
{
   public function viewPrivacyPolicy()
   {
    $privacypolicy = PrivacyPolicy::first();
    return view('admin.settings.view-privacypolicy',compact('privacypolicy'));
   }

    public function formPrivacyPolicy()
    {   $privacypolicy = PrivacyPolicy::first();
        return view('admin.settings.add-privacypolicy', compact('privacypolicy'));
    }

    public function storePrivacyPolicy(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'heading1'  => 'required',
            'answer1'  => 'required',
            'heading2'  => 'required',
            'answer2'  => 'required',
            'heading3'  => 'required',
            'answer3'  => 'required',
            'heading4'  => 'required',
            'answer4'  => 'required',
            'heading5'  => 'required',
            'answer5'  => 'required',

        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {


            $data = PrivacyPolicy::findOrFail($request->id);
            $data->heading1 = $request->heading1;
            $data->answer1 = $request->answer1;
            $data->heading2 = $request->heading2;
            $data->answer2 = $request->answer2;
            $data->heading3 = $request->heading3;
            $data->answer3 = $request->answer3;
            $data->heading4 = $request->heading4;
            $data->answer4 = $request->answer4;
            $data->heading5 = $request->heading5;
            $data->answer5 = $request->answer5;
            $data->heading6 = $request->heading6;
            $data->answer6 = $request->answer6;
            $data->heading7 = $request->heading7;
            $data->answer7 = $request->answer7;
            $data->heading8 = $request->heading8;
            $data->answer8 = $request->answer8;
            $data->heading9 = $request->heading9;
            $data->answer9 = $request->answer9;

            $save = $data->update();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Privacy Policy Updated Successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

}
