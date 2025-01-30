<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeliveryCharges;
use App\Models\HomeDeliveryAddress;
use App\Models\IndItem;
use App\Models\ProductProperty;
use App\Models\Products;
use App\Models\ProductToppings;
use App\Models\ProductVarients;
use App\Models\Propertie;
use App\Models\PropertiesItems;
use App\Models\SubCategory;
use App\Models\UserCart;
use App\Models\User;
use App\Models\Variation;
use App\Models\WebOrder;
use App\Models\WebOrderProduct;
use App\Models\ProductExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\ResponseFactory;
use App\Models\AddtoExtra;
use App\Models\Branches;
use App\Models\Combopack;
use App\Models\ComboProduct;
use App\Models\Coupons;
use App\Models\UserAddress;

class CheckoutController extends Controller
{
    public function place_order(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'type' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            if($request->type == "undefined") {
                return response()->json(['status' => false , 'msg' => "Select Payment Method!!"]);
                exit;
            }
            if($request->type_of_delivery === 'Home Delivery'){
                $shipping_address = UserAddress::where(['user_id' => $request->user_id])->first();
                // $extra = ProductExtra::where(['id' => $request->user_id])->first();

                if(!$shipping_address) {
                    return response()->json(['status' => false , 'msg' => "Add shipping address first."]);
                    exit;
                }
            }

            if(($request->type_of_delivery === 'Home Delivery' && $request->address == "undefined") ) {
                return response()->json(['status' => false , 'msg' => "Shipping address required!!"]);
                exit;
            }

            if(($request->type_of_delivery === 'Take Away' && $request->branch_id == "Select Branch") ) {
                return response()->json(['status' => false , 'msg' => "Please select branch!!"]);
                exit;
            }


            $checkCard = UserCart::where(['user_id' => $request->user_id])->get();
            // dd($request->address === 'undefined' ? 'Take Away' : 'Home Delivery');
            if($checkCard)
            {
                $order                      = new WebOrder();
                $input['user_id']           = $request->user_id;
                $input['payment_mode']      = $request->type;
                $input['pay_amount']        = $request->total;
                $input['tax']        = $request->tax;
                $input['discount_value']        = $request->discount_value;
                $input['invoice_id']        = uniqid(time()) . "" . rand(0, 50);
                $input['txn_id']            = uniqid(time());
                $input['coupon_code']  = $request->coupon_code;
                $input['shipping_address']  = $request->type_of_delivery === 'Take Away' ? $request->branch_id : $request->address;
                $input['delivery_type'] = $request->type_of_delivery === 'Take Away' ? 'Take Away' : 'Home Delivery';
                $input['delivery_charge'] = $request->delivery_charge;
                $orderSave = $order->fill($input)->save();

                if($orderSave)
                {
                    foreach($checkCard as $item) {
                        $productsDEt = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
                            'offers.start_date' , 'offers.end_date')
                            ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
                            ->where('products.id', $item->product_id)
                            ->first();
                        if (!empty($productsDEt->discount)){
                            if (strtotime($productsDEt->start_date) <= strtotime(date('Y-m-d')) && strtotime($productsDEt->end_date) >= strtotime(date('Y-m-d'))){
                                $discount = $productsDEt->discount;
                            }else{
                                $discount = 0;
                            }
                        }else{
                            $discount = 0;
                        }
                        if (!empty($item->varients)){
                            $Productvarient = ProductVarients::where(['product_id' => $item->product_id, 'varients_id' => $item->varients])->first();
                            $varientPrice = $Productvarient->varients_price - (($discount/100)*$Productvarient->varients_price);
                            $hasVarient = true;
                        }else{
                            $varientPrice = 0;
                            $hasVarient = false;
                        }
                        if(!empty($item->properties)){
                            if (isset($item->properties) && count(json_decode($item->properties)) > 0){
                                $ProductPropertiesItems = PropertiesItems::whereIn('id', json_decode($item->properties))->get();
                                $propertyItemTotalPrice = 0;
                                foreach($ProductPropertiesItems as $keyPI => $pi){
                                    $propertyItemTotalPrice += $pi->price;
                                }
                                $hasProperties = true;
                            }else{
                                $propertyItemTotalPrice = 0;
                                $hasProperties = false;
                            }
                        }else{
                            $propertyItemTotalPrice = 0;
                            $hasProperties = false;
                        }

                        if (!empty($item->toppings)){
                            if (!empty($item->toppings) && count(json_decode($item->toppings)) > 0){

                                $ProductToppingsItems = IndItem::whereIn('id', json_decode($item->toppings))->get();
                                $ToppingItemTotalPrice = 0;
                                foreach($ProductToppingsItems as $keyPT => $pt){
                                    $ProductToppingsPrice = ProductToppings::where(['product_id' => $item->product_id, 'ingredients_id' => $pt->id])->first();
                                    $ToppingItemTotalPrice += $ProductToppingsPrice->ingredents_price;
                                }
                                $hasToppings = true;
                            }else{
                                $ToppingItemTotalPrice = 0;
                                $hasToppings = false;
                            }
                        }else{
                            $ToppingItemTotalPrice = 0;
                            $hasToppings = false;
                        }

                        $grandTotal = 0;
                        if (!empty($item->varients)){
                            $grandTotal += $varientPrice;
                            if (!empty($item->properties)){
                                if (isset($item->properties) && count(json_decode($item->properties)) > 0){
                                    $grandTotal += $propertyItemTotalPrice;
                                }
                            }
                            if (!empty($item->toppings)){
                                if (!empty($item->toppings) && count(json_decode($item->toppings)) > 0){
                                    $grandTotal += $ToppingItemTotalPrice;
                                }
                            }

                        }else{
                            $grandTotal += $item->price;
                        }


                        $orderProduct           = new WebOrderProduct();
                        $input1['user_id']      = $request->user_id;
                        $input1['product_id']   = $item->product_id;
                        $input1['qty']          = $item->qty;
                        $input1['base_price']   = $item->discounted_price;
                        $input1['discount_percent']   = $item->discount_percent;
                        $input1['price_before_discount']   = $item->price;
                        $input1['normal_price']   = $grandTotal;
                        $input1['tax_percent']   = $item->tax;
                        $input1['order_id']     = $order->id;
                        $input1['combo_pack_id']= $item->combo_id;
                        $input1['type']         = $item->type;
                        $input1['varients']        = $item->varients;
                        $input1['properties']        = $item->properties;
                        $input1['toppings']        = $item->toppings;
                        $orderProductSave  = $orderProduct->fill($input1)->save();
                    }
                    if($orderProductSave)
                    {
                        // delete product form cart
                        UserCart::where(['user_id' => $request->user_id])->delete();

                        return response()->json(['status' => true , 'msg' => "Order Place successfully!!"]);
                        exit;
                    }
                    else
                    {
                        return response()->json(['status' => false , 'msg' => "Something went wrong try again later!!"]);
                        exit;
                    }
                }
                else
                {
                    return response()->json(['status' => false , 'msg' => "Something went wrong try again later!!"]);
                    exit;
                }

            }
            else
            {
                return response()->json(['status' => false , 'msg' => "First add product into cart"]);
                exit;
            }

        }
    }
}
