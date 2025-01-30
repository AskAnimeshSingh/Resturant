<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\Models\IndItem;
use App\Models\Branches;
use App\Models\Delivery;
use App\Models\WebOrder;
use App\Models\ComboProduct;
use App\Models\WebOrderProduct;
use Illuminate\Support\Facades\Auth;
use App\Models\Variation;
use App\Models\PropertiesItems;

class DeliveryOrderController extends Controller
{
    public function delivery_order_all(Request $request)
    {
        if(isset($request->search)){
            $search = $request->search;
        }
        else{
            $search = '';
        }
        if(isset($request->length)){
            $limit = $request->length;
        }
        else{
            $limit = 10;
        }

        if(isset($request->start)){
            $ofset = $request->start;
        }
        else{
            $ofset = 0;
        }

        if(isset($request->order_by)){
            $order_by = $request->order_by;
        }
        else{
            $order_by = 'DESC';
        }

        if ($request->order_type === 'all'){
            $Order = WebOrder::select("web_orders.*" , 'deliveries.name', 'deliveries.status as delivery_status', 'users.name as uname', 'users.phone as user_phone',
                'user_addresses.city','user_addresses.state',
                'user_addresses.house','user_addresses.street','user_addresses.apartment' , 'user_addresses.cross_street',)
                ->leftjoin('deliveries' , 'web_orders.delivery_user_id' , '=' , 'deliveries.id')
                ->leftjoin('users' , 'web_orders.user_id' , '=' , 'users.id')
                ->leftjoin('user_addresses', 'web_orders.shipping_address' , '=' , 'user_addresses.id')

                ->orWhere(function($query) use ($search){
                    $query->orWhere('txn_id' , 'like' , '%'. $search.'%');

                })
                ->offset($ofset)->limit($limit)
                ->orderBy('id' , $order_by)->where('delivery_user_id', $request->delivery_boy_id)->where('deliveries.status', '1')->get();
        }elseif ($request->order_type === 'pending'){
            $Order = WebOrder::select("web_orders.*" , 'deliveries.name', 'deliveries.status as delivery_status', 'users.name as uname', 'users.phone as user_phone',
                'user_addresses.city','user_addresses.state',
                'user_addresses.house','user_addresses.street','user_addresses.apartment' , 'user_addresses.cross_street',)
                ->leftjoin('deliveries' , 'web_orders.delivery_user_id' , '=' , 'deliveries.id')
                ->leftjoin('users' , 'web_orders.user_id' , '=' , 'users.id')
                ->leftjoin('user_addresses', 'web_orders.shipping_address' , '=' , 'user_addresses.id')

                ->orWhere(function($query) use ($search){
                    $query->orWhere('txn_id' , 'like' , '%'. $search.'%');

                })
                ->offset($ofset)->limit($limit)
                ->orderBy('id' , $order_by)->where('delivery_user_id', $request->delivery_boy_id)->where('deliveries.status', '1')->where('web_orders.status', 'COOKING')->orWhere('web_orders.status', 'DISPATCHED')->get();
        }elseif ($request->order_type === 'delivered'){
            $Order = WebOrder::select("web_orders.*" , 'deliveries.name', 'deliveries.status as delivery_status', 'users.name as uname', 'users.phone as user_phone',
                'user_addresses.city','user_addresses.state',
                'user_addresses.house','user_addresses.street','user_addresses.apartment' , 'user_addresses.cross_street',)
                ->leftjoin('deliveries' , 'web_orders.delivery_user_id' , '=' , 'deliveries.id')
                ->leftjoin('users' , 'web_orders.user_id' , '=' , 'users.id')
                ->leftjoin('user_addresses', 'web_orders.shipping_address' , '=' , 'user_addresses.id')

                ->orWhere(function($query) use ($search){
                    $query->orWhere('txn_id' , 'like' , '%'. $search.'%');

                })
                ->offset($ofset)->limit($limit)
                ->orderBy('id' , $order_by)->where('delivery_user_id', $request->delivery_boy_id)->where('deliveries.status', '1')->where('web_orders.status', 'COMPLETED')->get();
        }

        if (count($Order) > 0){
            return response()->json([
                'status' => true,
                'message' => 'Orders found!!',
                'data' => $Order
            ], 201);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'No orders found!!',
                'data' => null
            ], 201);
        }
    }

    public function delivery_order_details(Request $request)
    {
        $orders = WebOrder::select("web_orders.*" , 'users.name' , 'users.phone' , 'user_addresses.city' , 'user_addresses.state' ,
            'user_addresses.house' , 'user_addresses.street' , 'user_addresses.apartment' , 'user_addresses.cross_street')
            ->join('users' , 'web_orders.user_id' , '=' , 'users.id')
            ->join('user_addresses' , 'web_orders.shipping_address' , '=' , 'user_addresses.id')
            ->where(['web_orders.id' => $request->web_order_id])
            ->get();
//        echo json_encode($orders); exit;
        $data = [];
        foreach($orders as $key => $oo){
            $data[$key]['id'] = $oo->id;
            $data[$key]['user_id'] = $oo->user_id;
            $data[$key]['delivery_user_id'] = $oo->delivery_user_id;
            $data[$key]['shipping_address'] = $oo->shipping_address;
            $data[$key]['delivery_type'] = $oo->delivery_type;
            $data[$key]['payment_mode'] = $oo->payment_mode;
            $data[$key]['pay_amount'] = $oo->pay_amount;
            $data[$key]['tax'] = $oo->tax;
            $data[$key]['discount_value'] = $oo->discount_value;
            $data[$key]['txn_id'] = $oo->txn_id;
            $data[$key]['invoice_id'] = $oo->invoice_id;
            $data[$key]['status'] = $oo->status;
            $data[$key]['payment_status'] = $oo->payment_status;
            $data[$key]['coupon_code'] = $oo->coupon_code;
            $data[$key]['delivery_charge'] = $oo->delivery_charge;
            $data[$key]['created_at'] = $oo->created_at;
            $data[$key]['updated_at'] = $oo->updated_at;
            $data[$key]['name'] = $oo->name;
            $data[$key]['phone'] = $oo->phone;
            $data[$key]['city'] = $oo->city;
            $data[$key]['state'] = $oo->state;
            $data[$key]['house'] = $oo->house;
            $data[$key]['street'] = $oo->street;
            $data[$key]['apartment'] = $oo->apartment;
            $data[$key]['cross_street'] = $oo->cross_street;

            $products = WebOrderProduct::select("web_order_products.*" , "products.product_name" , "products.product_img" ,
                "products.size" , "products.type as product_type" , "combopacks.package_name" , "combopacks.image")
                ->leftjoin('products' , 'web_order_products.product_id' , '=' , 'products.id')
                ->leftjoin('combopacks' , 'web_order_products.combo_pack_id' , '=' , 'combopacks.id')
                ->where(['order_id' => $oo->id])->get();
            $pp = [];
            foreach ($products as $key2 => $order) {
                if($order->type == "combo") {
                    $data[$key]['procudts_list'][$key2]['img'] = $order->image;
                    $data[$key]['procudts_list'][$key2]['new_name'] = $order->package_name;
                }else{
                    $data[$key]['procudts_list'][$key2]['img'] = $order->product_img;
                    $data[$key]['procudts_list'][$key2]['new_name'] = $order->product_name;
                }
                if(!empty($order->varients)){
                    $varientDetails = Variation::where(['id' => $order->varients])->first();
                    $data[$key]['procudts_list'][$key2]['varient'] = $varientDetails->name;
                }else{
                    $data[$key]['procudts_list'][$key2]['varient'] = '';
                }

                if(!empty($order->toppings) && count(json_decode($order->toppings)) > 0){
                    foreach(json_decode($order->toppings) as $keyTop => $top){
                        $topping = IndItem::where(['id' => $top])->first();
                        $data[$key]['procudts_list'][$key2]['crust'] = $topping->name;
                    }
                }else{
                    $data[$key]['procudts_list'][$key2]['crust'] = [];
                }

                if(!empty($order->properties) && count(json_decode($order->properties)) > 0){
                    $properties = PropertiesItems::whereIn('id', json_decode($order->properties))->get();
                    foreach($properties as $keyPOP => $pop){
                        $data[$key]['procudts_list'][$key2]['toppings'][$keyPOP] = $pop->name;
                    }
                }else{
                    $data[$key]['procudts_list'][$key2]['toppings'] = [];
                }

                $data[$key]['procudts_list'][$key2]['base_price'] = $order->base_price;
                $data[$key]['procudts_list'][$key2]['qty'] = $order->qty;
                $data[$key]['procudts_list'][$key2]['total_price'] = number_format($order->qty * $order->base_price , 2);

            }

        }
        if (count($orders) > 0){
            return response()->json([
                'status' => true,
                'message' => 'Orders found!!',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'No orders found!!',
                'data' => null
            ], 401);
        }


    }


}
