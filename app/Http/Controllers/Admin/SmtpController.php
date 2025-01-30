<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Smtp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SmtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function smtp_index()
    {
        //
        return view('admin.settings.smtp');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function smtp_store(Request $request)
    {
        //
        // print_r($request->all());
        // exit;
        $validator = Validator::make($request->all() , [

            'mailer'  => 'required',
            'host'  => 'required',
            'port'  => 'required',
            'name'  => 'required',
            'password'  => 'required',
            'encryption'  => 'required',
            'address'  => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {

            $data = new Smtp();
            $input['mailer'] = $request->mailer;
            $input['host'] = $request->host;
            $input['port'] = $request->port;
            $input['name'] = $request->name;
            $input['password'] = $request->password;
            $input['encryption'] = $request->encryption;
            $input['address'] = $request->address;



            $save = $data->fill($input)->save();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "smtp/mailer save successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Smtp  $smtp
     * @return \Illuminate\Http\Response
     */
    public function show(Smtp $smtp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Smtp  $smtp
     * @return \Illuminate\Http\Response
     */
    public function edit(Smtp $smtp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Smtp  $smtp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Smtp $smtp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Smtp  $smtp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Smtp $smtp)
    {
        //
    }
}
