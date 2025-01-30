<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Product;
use App\Models\Branches;
use App\Models\HomeDeliveryAddress;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\userCart;
use App\Models\WebOrder;
use App\Models\WebOrderProduct;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Print_;

class CheckoutController extends Controller
{
    /**
     * @param Request $request
     * @method use for place order And Checkout.
     */
    public function place_order(Request $request)
    {

        $userData = auth()->user();

        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        if ($request->type == "undefined") {
            return response()->json(['status' => false, 'message' => "Select Payment Method!!"]);
        }

        $shipping_address = HomeDeliveryAddress::where(['user_id' => $userData->id, 'id' => $request->address_id])->first();

        if ($shipping_address) {
            $checkCard = UserCart::where(['user_id' => $userData->id])->get();
            
            if ($checkCard) {                
                $orderSave = WebOrder::create(array_merge(
                    $validator->validated(),
                    ['user_id'          => $userData->id],
                    ['payment_mode'     => $request->type],
                    ['pay_amount'       =>  $request->total],
                    ['instruction'      => $request->instruction],
                    ['invoice_id'       => uniqid(time()) . "" . rand(0, 50)],
                    ['txn_id'           => uniqid(time())],
                    ['shipping_address' => $shipping_address->id],
                ));

                $orderProductSave = false;

                if ($orderSave) {
                    foreach ($checkCard as $item) {                        
                        $orderProduct           = new WebOrderProduct();
                        $input1['user_id']      = $userData->id;
                        $input1['product_id']   = $item->product_id;
                        $input1['qty']          = $item->qty;
                        $input1['base_price']   = $item->price;
                        $input1['order_id']     = $orderSave->id;
                        $input1['extra']        = $item->extra;
                        
                        $orderProductSave  = $orderProduct->fill($input1)->save();
                        
                    }

                    if ($orderProductSave) {
                        // delete product form cart
                        UserCart::where(['user_id' => $userData->id])->delete();
                        return response()->json(['status' => true, 'msg' => "Order Place successfully!!"]);
                    } else {
                        return response()->json(['status' => false, 'msg' => "Something went wrong try again later!!"]);
                    }
                } else {
                    return response()->json(['status' => false, 'msg' => "Something went wrong try again later!!"]);
                }
            } else {
                return response()->json(['status' => false, 'msg' => "First add product into cart"]);
            }
        } else {
            return response()->json(['status' => false, 'msg' => "First add Addresses"]);
        }
    }


    /**
     * @method use for orderList
     */
    public function orderList(Request $request)
    {
        
        try {
        
            $order_list = WebOrder::select(
                "web_orders.*",
                'deliveries.name',
                'users.name as uname',
                'users.phone as users_phone',
                'home_delivery_addresses.city',
                'home_delivery_addresses.state',
                'home_delivery_addresses.phone',
                'home_delivery_addresses.house',
                'home_delivery_addresses.street',
                'home_delivery_addresses.apartment',
                'home_delivery_addresses.cross_street',                            
                
            )
                ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
                ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
                ->leftjoin('home_delivery_addresses', 'web_orders.shipping_address', '=', 'home_delivery_addresses.id')            
                ->where('web_orders.user_id', auth()->user()->id)
                ->get();

                    foreach($order_list as  $key => $orders){
                        $order_list[$key]['OrderItem'] = WebOrderProduct::select('web_order_products.*', 'products.product_name','products.product_img')
                        ->join('products', 'web_order_products.product_id', '=', 'products.id')
                        ->where('order_id' , $orders->id)->get();
                    }
            
                    return response()->json(['status' => true, 'message' => 'success', 'Data' => $order_list]);
                    exit;
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!!', 'Data' => []]);
            exit;
        }
    }

    /**
     * @method use for order details
     */
    public function orderDetail(Request $request)
    {
        try {
            // $orderDetailss = "";
            $orderDetails = WebOrder::select(
                "web_orders.*",
                'deliveries.name',
                'users.name as uname',
                'users.phone as users_phone',
                'home_delivery_addresses.city',
                'home_delivery_addresses.state',
                'home_delivery_addresses.phone',
                'home_delivery_addresses.house',
                'home_delivery_addresses.street',
                'home_delivery_addresses.apartment',
                'home_delivery_addresses.cross_street',
            )
                ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
                ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
                ->leftjoin('home_delivery_addresses', 'web_orders.shipping_address', '=', 'home_delivery_addresses.id')
                ->where('web_orders.user_id', auth()->user()->id)
                ->where('web_orders.id', $request->id)
                ->first();
                $orderDetails['OrderItem'] = WebOrderProduct::select('web_order_products.*', 'products.product_name','products.product_img','products.product_des')
                ->join('products', 'web_order_products.product_id', '=', 'products.id')
                ->where('order_id' , $orderDetails->id)->get();

            if (!empty($orderDetails)) {
                return response()->json(['status' => true, 'message' => 'success', 'Data' => $orderDetails]);
                exit;
            } else {
                return response()->json(['status' => false, 'message' => 'Data Not Found', 'Data' => ""]);
                exit;
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!!', 'Data' => ""]);
            exit;
        }
    }

    /**
     * @method use for get snacks list
     */
    public function snacksList(Request $request)
    {
        try {
            $getSnacks = Products::select('products.*', 'categories.cate_name as categories_name', 'sub_categories.name as sub_categories_name')
                ->join('categories', 'products.category', '=', 'categories.id')
                ->join('sub_categories', 'products.sub_category', '=', 'sub_categories.id')
                ->where('products.status', 1)->get();

            return response()->json(['status' => true, 'message' => 'Success', 'Data' => $getSnacks]);
            exit;
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!!', 'Data' => []]);
            exit;
        }
    }

    /**
     * @method use for get popular restaurant list
     */
    public function popularResturants(Request $request)
    {
        try {
            $popularRestaurant = Products::where('status', 1)->get();

            return response()->json(['status' => true, 'message' => 'Success', 'Data' => $popularRestaurant]);
            exit;
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!!', 'Data' => []]);
            exit;
        }
    }

    /**
     * @method use for Get Latest Resturants List
     */
    public function LatestResturants(Request $request)
    {
        try {
            $getLatestRestaurant = Products::where('status', 1)->orderBy('id', 'DESC')->get();
            return response()->json(['status' => true, 'message' => 'Success', 'Data' => $getLatestRestaurant]);
            exit;
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!!', 'Data' => []]);
            exit;
        }
    }
}
