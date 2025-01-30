<?php

namespace App\Http\Controllers;

use App\Models\HomeDeliveryAddress;
use Illuminate\Http\Request;
use App\Models\homeDeliveryAddressesModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addressData = homeDeliveryAddressesModel::where('user_id', auth()->user()->id)->get();

        if ($addressData) {
            return response()->json([
                'message' => 'Address List',
                'address' => $addressData
            ], 201);
        } else {
            return response()->json([
                'message' => 'Data Not Available',
                'address' => '',
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $userData = auth()->user();

        $name = Self::split_name($userData->name);

        $validator = Validator::make($request->all(), [
            'apartment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $addressData = [];
        $addressData = array_merge(
            $validator->validated(),
            [
                'first_name' => $name['first_name'],
                'last_name' => $name['last_name'],
                'middle_name' => $name['middle_name'],
                'email' => $userData->email,
                'phone' => $userData->phone,
                'house' => $request->house,
                'apartment' => $request->apartment,
                'street' => $request->street,
                'cross_street' => $request->cross_street,
                'city' => $request->city,
                'state' => $request->state,
                'user_id' => $userData->id,
            ]
        );

        $addData = HomeDeliveryAddress::create($addressData);
        return response()->json([
            'status' => true,
            'message' => 'Address successfully Stored',
            'data' => $addData
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = HomeDeliveryAddress::where(['id' => $id, 'user_id' => auth()->user()->id])->first();

        if ($address) {
            return response()->json([
                'status' => true,
                'message' => 'Address Details',
                'data' => $address,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Address Not Found',
                'data' => ""
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        // try{
        $rul = [
            'id' => 'required|exists:home_delivery_addresses,id',
            'house' => ['required'],
            'city' => ['required'],
            'state' => ['required'],

        ];

        $msg = Validator::make($request->all(), $rul);
        if ($msg->fails()) {
            return response()->json(array('status' => false, 'message' => $msg->errors()->first(), 'data' => ''));
            exit;
        }

        $addressFind = HomeDeliveryAddress::where(['id' => $request->id, 'user_id' => auth()->user()->id])->first();
        $addressFind->house = $request->house;
        $addressFind->apartment = $request->apartment;
        $addressFind->street = $request->street;
        $addressFind->cross_street = $request->cross_street;
        $addressFind->city = $request->city;
        $addressFind->state = $request->state;
        $addressFind->user_id = auth()->user()->id;

        $result = $addressFind->update();
        if ($result) {
            return response()->json(array('status' => true, 'message' => 'Address Updated', 'data' => $addressFind));
        } else {
            return response()->json(array('status' => false, 'message' => 'something wrong', 'data' => []));
        }


        // }catch(Exception $e){
        //     return response()->json(['status'=>false , 'message'=>'Something Went Wrong', 'data'=>""]);
        //     exit;
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        $address = HomeDeliveryAddress::where(['id' => $id, 'user_id' => auth()->user()->id])->delete();

        if ($address) {
            return response()->json([
                'status' => true,
                'message' => 'Address successfully Deleted',
                "Data" => ""
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed',
                'data' => ""
            ], 201);
        }
    }

    /**
     * Function for separate Firstname,Middlename,Lastname.
     *
     */
    function split_name($string)
    {
        $arr = explode(' ', $string);
        $num = count($arr);
        $first_name = $middle_name = $last_name = null;

        if ($num == 2) {
            //list($first_name, $last_name) = $arr;
            $first_name = $arr[0] ?? null;
            $last_name = $arr[2] ?? null;
        } else {
            $first_name = $arr[0] ?? null;
            $middle_name = $arr[1] ?? null;
            $last_name = $arr[2] ?? null;
        }

        return (empty($first_name) || $num > 3) ? false : compact(
            'first_name', 'middle_name', 'last_name'
        );
    }
}
