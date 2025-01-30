<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebOrder;
use App\Models\WebOrderProduct;
use App\Models\Variation;
use App\Models\IndItem;
use App\Models\PropertiesItems;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function order_history(Request $request)
    {
        if(isset($request->search)){
            $search = $request->search;
        }
        else{
            $search = '';
        }
        if(isset($request->limit)){
            $limit = $request->limit;
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

        $orderType = $request->order_by;
        // $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

        $total = WebOrder::orWhere('txn_id' , 'like' , '%'. $search.'%')->where(['user_id' => $request->user_id])->count();
        $orders = WebOrder::select("web_orders.*" , 'users.name' , 'users.phone' , 'user_addresses.city' , 'user_addresses.state' ,
            'user_addresses.house' , 'user_addresses.street' , 'user_addresses.apartment' , 'user_addresses.cross_street')
            ->join('users' , 'web_orders.user_id' , '=' , 'users.id')
            ->join('user_addresses' , 'web_orders.shipping_address' , '=' , 'user_addresses.id')
            ->orWhere('txn_id' , 'like' , '%'. $search.'%')
            ->where(['web_orders.user_id' => $request->user_id])
            ->offset($ofset)->limit($limit)
            ->orderBy('id' , $orderType)->get();
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
                    $pp[$key][$key2]['img'] = $order->image;
                    $pp[$key][$key2]['new_name'] = $order->package_name;
                }else{
                    $pp[$key][$key2]['img'] = $order->product_img;
                    $pp[$key][$key2]['new_name'] = $order->product_name;
                }
                if(!empty($order->varients)){
                    $varientDetails = Variation::where(['id' => $order->varients])->first();
                    $pp[$key][$key2]['varient'] = $varientDetails->name;
                }else{
                    $pp[$key][$key2]['varient'] = '';
                }

                if(!empty($order->toppings) && count(json_decode($order->toppings)) > 0){
                    foreach(json_decode($order->toppings) as $keyTop => $top){
                        $topping = IndItem::where(['id' => $top])->first();
                        $pp[$key][$key2]['crust'] = $topping->name;
                    }
                }else{
                    $pp[$key][$key2]['crust'] = [];
                }

                if(!empty($order->properties) && count(json_decode($order->properties)) > 0){
                    $properties = PropertiesItems::whereIn('id', json_decode($order->properties))->get();
                    foreach($properties as $keyPOP => $pop){
                        $pp[$key][$key2]['toppings'][$keyPOP] = $pop->name;
                    }
                }else{
                    $pp[$key][$key2]['toppings'] = [];
                }

                $pp[$key][$key2]['base_price'] = $order->base_price;
                $pp[$key][$key2]['qty'] = $order->qty;
                $pp[$key][$key2]['total_price'] = number_format($order->qty * $order->base_price , 2);


//                $data[] = array(
//                    '<img src="'.url($img).'" class="rounded" style="height: 30px; width: 30px;"><br><b>'.$new_name .'</b>'.$varient.$crust.$toppings,
//                    $order->base_price,
//                    $order->qty,
//                    ($order->type == "combo" ? $order->type .'&nbsp;<a href="javascrit:void(0)" class="btn btn-success show_detail" data-id="'.$order->combo_pack_id.'"><i class="fa fa-eye"></i></a>' : $order->product_type),
//                    number_format($order->qty * $order->base_price , 2),
//                );

            }
            $data[$key]['procudts_list'] = $pp;

        }

        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $orders;
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
            ], 201);
        }
    }

    public function order_details(Request $request)
    {

        $orders = WebOrder::select("web_orders.*" , 'users.name' , 'users.phone' , 'user_addresses.city' , 'user_addresses.state' ,
            'user_addresses.house' , 'user_addresses.street' , 'user_addresses.apartment' , 'user_addresses.cross_street')
            ->join('users' , 'web_orders.user_id' , '=' , 'users.id')
            ->join('user_addresses' , 'web_orders.shipping_address' , '=' , 'user_addresses.id')
            ->where(['web_orders.user_id' => $request->user_id, 'web_orders.id' => $request->web_order_id])
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
//            $data[$key]['procudts_list'] = $pp;

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

    public function order_counter(Request $request){
        if ($request->order_type === 'ALL'){
            $order = WebOrder::get();
        }else{
            $order = WebOrder::where('status', $request->order_type)->get();
        }

        return response()->json([
            'status' => true,
            'message' => 'Order Count!!',
            'data' => count($order)
        ], 201);

    }

    public function todays_order(Request $request){

        $orders = WebOrder::select("web_orders.*" , 'users.name' , 'users.phone' , 'user_addresses.city' , 'user_addresses.state' ,
            'user_addresses.house' , 'user_addresses.street' , 'user_addresses.apartment' , 'user_addresses.cross_street')
            ->join('users' , 'web_orders.user_id' , '=' , 'users.id')
            ->join('user_addresses' , 'web_orders.shipping_address' , '=' , 'user_addresses.id')
            ->whereDate('web_orders.created_at', Carbon::today())
            ->orderBy('id' , 'DESC')->get();
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
                    $pp[$key][$key2]['img'] = $order->image;
                    $pp[$key][$key2]['new_name'] = $order->package_name;
                }else{
                    $pp[$key][$key2]['img'] = $order->product_img;
                    $pp[$key][$key2]['new_name'] = $order->product_name;
                }
                if(!empty($order->varients)){
                    $varientDetails = Variation::where(['id' => $order->varients])->first();
                    $pp[$key][$key2]['varient'] = $varientDetails->name;
                }else{
                    $pp[$key][$key2]['varient'] = '';
                }

                if(!empty($order->toppings) && count(json_decode($order->toppings)) > 0){
                    foreach(json_decode($order->toppings) as $keyTop => $top){
                        $topping = IndItem::where(['id' => $top])->first();
                        $pp[$key][$key2]['crust'] = $topping->name;
                    }
                }else{
                    $pp[$key][$key2]['crust'] = [];
                }

                if(!empty($order->properties) && count(json_decode($order->properties)) > 0){
                    $properties = PropertiesItems::whereIn('id', json_decode($order->properties))->get();
                    foreach($properties as $keyPOP => $pop){
                        $pp[$key][$key2]['toppings'][$keyPOP] = $pop->name;
                    }
                }else{
                    $pp[$key][$key2]['toppings'] = [];
                }

                $pp[$key][$key2]['base_price'] = $order->base_price;
                $pp[$key][$key2]['qty'] = $order->qty;
                $pp[$key][$key2]['total_price'] = number_format($order->qty * $order->base_price , 2);

            }
            $data[$key]['procudts_list'] = $pp;

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
            ], 201);
        }

    }

    public function test(Request $request){
        $this->storeNotification(11,'dev','message','test');
    }
}
