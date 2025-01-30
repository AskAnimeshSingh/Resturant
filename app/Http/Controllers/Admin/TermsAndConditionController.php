<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TermsAndCondition;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TermsAndConditionController extends Controller
{
    public function formTermandCondition()
    {   $terms = TermsAndCondition::first();
        return view('admin.settings.add-term_and_condition', compact('terms'));
    }

    public function viewTermandCondition()
    {
     $terms = TermsAndCondition::first();
     return view('admin.settings.view-term_and_condition',compact('terms'));
    }

    public function updateTermandCondition(Request $request)
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


        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {


            $data = TermsAndCondition::findOrFail($request->id);
            $data->heading1 = $request->heading1;
            $data->answer1 = $request->answer1;
            $data->heading2 = $request->heading2;
            $data->answer2 = $request->answer2;
            $data->heading3 = $request->heading3;
            $data->answer3 = $request->answer3;
            $data->heading4 = $request->heading4;
            $data->answer4 = $request->answer4;


            $save = $data->update();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Terms and Condition Updated Successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }



}
