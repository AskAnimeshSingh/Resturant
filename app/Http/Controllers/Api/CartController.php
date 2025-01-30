<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupons;
use App\Models\Variation;
use App\Models\Products;
use App\Models\ProductVarients;
use App\Models\UserCart;
use App\Models\PropertiesItems;
use App\Models\IndItem;
use App\Models\Combopack;
use App\Models\ProductToppings;
use App\Models\DeliveryCharges;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{


    public function add_to_cart_without_varient(Request $request)
    {
        $rules = [
            'product_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'discount_percent' => 'required|numeric',
            'discounted_price' => 'required|numeric',
        ];
        $msg = [
            'product_id.required' => 'Product ID cannot be empty',
            'user_id.required' => 'User ID cannot be empty',
            'discount_percent.required' => 'Discount percentage cannot be empty',
            'discounted_price.required' => 'Discount price cannot be empty',
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
                return response()->json([
                    'status' => false,
                    'message' => 'User id is invalid',
                    'data' => null
                ], 401);
            }

            $product = Products::where('id', $request->product_id)->first();
            if (!$product){
                return response()->json([
                    'status' => false,
                    'message' => 'Product id is invalid',
                    'data' => null
                ], 201);
            }else{
                if ($product->has_varients == 1){
                    return response()->json([
                        'status' => false,
                        'message' => 'Product has varients!!',
                        'data' => null
                    ], 401);
                }
            }



            $checkProductExixt = UserCart::where(['product_id' => $request->product_id , 'user_id' => $request->user_id])->count();

            if($checkProductExixt == 0)
            {
                $data                   = new UserCart();
                $input['product_id']    = $product->id;
                $input['user_id']       = $request->user_id;
                $input['qty']           = 1;
                $input['price']         = $product->price;
                $input['discount_percent']         = $request->discount_percent;
                $input['discounted_price']         = $request->discounted_price;
                $input['tax']           = $product->tax;
                $save = $data->fill($input)->save();

                if($save)
                {
                    return response()->json(['status' => true , 'msg' => 'Menu successfully added into cart', 'type'=>'new']);
                    exit;
                }
                else
                {
                    return response()->json(['status' => false , 'msg' => "Error's occurs try again later !!"]);
                    exit;
                }
            }
            else
            {
                $increaseProduct = UserCart::where(['product_id' => $request->product_id , 'user_id' => $request->user_id])->first();

                $increaseProduct->qty = ($increaseProduct->qty + 1);

                $update = $increaseProduct->update();
                if($update)
                {
                    return response()->json(['status' => true , 'msg' => 'Menu successfully added into cart', 'type'=>'already_add']);
                    exit;
                }
                else
                {
                    return response()->json(['status' => false , 'msg' => "Error's occurs try again later !!"]);
                    exit;
                }
            }
        }
    }




    public function add_to_cart_with_varient(Request $request)
    {
        $rules = [
            'product_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'discount_percent' => 'required|numeric',
            'varients' => 'required',
        ];
        $msg = [
            'product_id.required' => 'Product ID cannot be empty',
            'user_id.required' => 'User ID cannot be empty',
            'discount_percent.required' => 'Discount percentage cannot be empty',
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
                return response()->json([
                    'status' => false,
                    'message' => 'User id is invalid',
                    'data' => null
                ], 401);
            }

            $product = Products::where('id', $request->product_id)->first();
            if (!$product){
                return response()->json([
                    'status' => false,
                    'message' => 'Product id is invalid',
                    'data' => null
                ], 401);
            }else{
                if ($product->has_varients == 0){
                    return response()->json([
                        'status' => false,
                        'message' => 'Product doesnot have varients!!',
                        'data' => null
                    ], 401);
                }
            }

            if (!empty($request->varients)){
                $varient = $request->varients;
            }else{
                $varient = '';
            }

            if (!empty($request->properties)){
                $properties = json_encode($request->properties);
            }else{
                $properties = '';
            }

            if (!empty($request->toppings)){
                $toppings = json_encode($request->toppings);
            }else{
                $toppings = '';
            }

            if (!empty($varient)){
                $vv = ProductVarients::where(['varients_id' => $varient, 'product_id' => $product->id])->first();
                $v_price = $vv->varients_price;
            }else{
                $v_price = $product->price;
            }

            if ($request->discount_percent != 0){
                $price_after_discount = $v_price - (($request->discount_percent/100)*$v_price);
            }else{
                $price_after_discount = $v_price;
            }

            $data                   = new UserCart();
            $input['product_id']    = $product->id;
            $input['user_id']       = $request->user_id;
            $input['qty']           = 1;
            $input['price']         = $v_price;
            $input['tax']           = $product->tax;
            $input['varients']         = $varient;
            $input['properties']         = $properties;
            $input['toppings']         = $toppings;
            $input['discount_percent']         = $request->discount_percent;
            $input['discounted_price']         = $price_after_discount;
            $save = $data->fill($input)->save();

            if($save)
            {
                return response()->json(['status' => true , 'msg' => 'Menu successfully added into cart']);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => "Error's occurs try again later !!"]);
                exit;
            }
        }
    }



    public function cart_list(Request $request)
    {
        $productss = [];
        $deliveryChargesData = [];
        $subTotal = 0;
        $tax = 0;
        $deliveryChargesData['hasDeliveryCharges'] = false;
        $deliveryChargesData['deliveryChargesss'] = 0;
        $products = UserCart::select("user_carts.*" , "products.product_img" , "products.product_name" ,
            "offers.discount" , "combopacks.package_name"  , "combopacks.image")
            ->leftjoin("products" , "user_carts.product_id" , "=" , "products.id")
            ->leftjoin("combopacks" , "user_carts.combo_id" , "=" , "combopacks.id")
            ->leftjoin("offers" , "user_carts.product_id" , "=" , "offers.product_id")
            ->where(['user_id' => $request->user_id])->get();
        foreach($products as $key => $p){
            $productss[$key]['id'] = $p->id;
            $productss[$key]['product_id'] = $p->product_id;
            $productss[$key]['combo_id'] = $p->combo_id;
            $productss[$key]['user_id'] = $p->user_id;
            $productss[$key]['qty'] = $p->qty;
            $productss[$key]['price'] = $p->price;
            $productss[$key]['tax'] = $p->tax;
            $productss[$key]['status'] = $p->status;
            $productss[$key]['extra'] = $p->extra;
            $productss[$key]['varients'] = $p->varients;
            $productss[$key]['properties'] = $p->properties;
            $productss[$key]['toppings'] = $p->toppings;
            $productss[$key]['type'] = $p->type;
            $productss[$key]['created_at'] = $p->created_at;
            $productss[$key]['updated_at'] = $p->updated_at;
            $productss[$key]['product_img'] = $p->product_img;
            $productss[$key]['product_name'] = $p->product_name;
            $productss[$key]['discount'] = $p->discount;
            $productss[$key]['package_name'] = $p->package_name;
            $productss[$key]['image'] = $p->image;

            $productsDEt = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
                'offers.start_date' , 'offers.end_date')
                ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
                ->where('products.id', $p->product_id)
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
            if (!empty($p->varients)){
                $Productvarient = ProductVarients::where(['product_id' => $p->product_id, 'varients_id' => $p->varients])->first();
                $varientPrice = $Productvarient->varients_price - (($discount/100)*$Productvarient->varients_price);
                $varients = Variation::where(['id' => $p->varients])->first();
                $varientName = $varients->name;
                $hasVarient = true;
            }else{
                $varientPrice = 0;
                $varientName = '';
                $hasVarient = false;
            }
            $productss[$key]['varientPrice'] = $varientPrice;
            $productss[$key]['varientName'] = $varientName;
            $productss[$key]['hasVarient'] = $hasVarient;
            if(!empty($p->properties)){
                if (isset($p->properties) && count(json_decode($p->properties)) > 0){
                    $ProductPropertiesItems = PropertiesItems::whereIn('id', json_decode($p->properties))->get();
                    $propertyItems = [];
                    $propertyItemTotalPrice = 0;
                    foreach($ProductPropertiesItems as $keyPI => $pi){
                        $propertyItems[$keyPI]['name'] = $pi->name;
                        $propertyItems[$keyPI]['price'] = $pi->price;
                        $propertyItemTotalPrice += $pi->price;
                    }
                    $hasProperties = true;
                }else{
                    $propertyItems = [];
                    $propertyItemTotalPrice = 0;
                    $hasProperties = false;
                }
            }else{
                $propertyItems = [];
                $propertyItemTotalPrice = 0;
                $hasProperties = false;
            }

            $productss[$key]['propertyItems'] = $propertyItems;
            $productss[$key]['propertyItemTotalPrice'] = $propertyItemTotalPrice;
            $productss[$key]['hasProperties'] = $hasProperties;
            if (!empty($p->toppings)){
                if (!empty($p->toppings) && count(json_decode($p->toppings)) > 0){

                    $ProductToppingsItems = IndItem::whereIn('id', json_decode($p->toppings))->get();
                    $ToppingItems = [];
                    $ToppingItemTotalPrice = 0;
                    foreach($ProductToppingsItems as $keyPT => $pt){
                        $ToppingItems[$keyPT]['name'] = $pt->name;
                        $ProductToppingsPrice = ProductToppings::where(['product_id' => $p->product_id, 'ingredients_id' => $pt->id])->first();
                        $ToppingItems[$keyPT]['price'] = $ProductToppingsPrice->ingredents_price;
                        $ToppingItemTotalPrice += $ProductToppingsPrice->ingredents_price;
                    }
                    $hasToppings = true;
                }else{
                    $ToppingItems = [];
                    $ToppingItemTotalPrice = 0;
                    $hasToppings = false;
                }
            }else{
                $ToppingItems = [];
                $ToppingItemTotalPrice = 0;
                $hasToppings = false;
            }

            $productss[$key]['ToppingItems'] = $ToppingItems;
            $productss[$key]['ToppingItemTotalPrice'] = $ToppingItemTotalPrice;
            $productss[$key]['hasToppings'] = $hasToppings;
            $grandTotal = 0;
            if (!empty($p->varients)){
                $grandTotal += $varientPrice;
                if (!empty($p->properties)){
                    if (isset($p->properties) && count(json_decode($p->properties)) > 0){
                        $grandTotal += $propertyItemTotalPrice;
                    }
                }
                if (!empty($p->toppings)){
                    if (!empty($p->toppings) && count(json_decode($p->toppings)) > 0){
                        $grandTotal += $ToppingItemTotalPrice;
                    }
                }
            }else{
                $grandTotal += $p->price;
            }
            $productss[$key]['grandTotal'] = $grandTotal;

            $deliveryPrices = DeliveryCharges::first();
            if ($deliveryPrices->status == 1){
                $deliveryChargesData = [];
                $deliveryChargesData['hasDeliveryCharges'] = true;
                $deliveryChargesData['deliveryChargesss'] = $deliveryPrices->charges;
            }else{
                $deliveryChargesData = [];
                $deliveryChargesData['hasDeliveryCharges'] = false;
                $deliveryChargesData['deliveryChargesss'] = 0;
            }
            $subTotal += $grandTotal;
            $tax += (($p->tax / 100) * $grandTotal ) * $p->qty;
        }

        $total = floatval($subTotal)+floatval($tax)+floatval($deliveryChargesData['deliveryChargesss']);

        return response()->json(['status' => true, 'products' => $productss, 'subTotal' => $subTotal, 'tax' => $tax, 'deliveryCharges' => $deliveryChargesData, 'grandTotalBeforeDiscount' => $total]);
    }

    public function cart_remove(Request $request)
    {

        try{
            $where = array('id' => $request->cart_id);
            $del = UserCart::where($where)->delete();
            if ($del) {
                return response()->json(array('status' => true, 'msg' => "Successfully remove !!!!"));
                exit;
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
                exit;
            }
        }
        catch (\Illuminate\Database\QueryException $e ) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }

    public function increase_cart(Request $request)
    {
        $increaseProduct = UserCart::where(['id' => $request->cart_id])->first();

        $increaseProduct->qty = ($request->qty + $increaseProduct->qty);

        $update = $increaseProduct->update();

        if($update)
        {
            return response()->json(['status' => true , 'msg' => "Qty increase successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Something went wrong try again later"]);
            exit;
        }
    }


    public function decrease_cart(Request $request)
    {
        $increaseProduct = UserCart::where(['id' => $request->cart_id])->first();
        if($increaseProduct->qty - $request->qty >= 1) {
            $increaseProduct->qty = ($increaseProduct->qty - $request->qty);

            $update = $increaseProduct->update();

            if($update)
            {
                return response()->json(['status' => true , 'msg' => "Qty decrease successfully"]);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => "Something went wrong try again later"]);
                exit;
            }
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Minimum Qty 1"]);
            exit;
        }
    }


    public function add_to_cart_combo(Request $request){

        $product = Combopack::where('id', $request->combo_id)->first();
        if (!$product){
            return response()->json([
                'status' => false,
                'message' => 'Combo id is invalid',
                'data' => null
            ], 401);
        }
        $checkProductExixt = UserCart::where(['combo_id' => $request->combo_id , 'user_id' => $request->user_id])->count();

        if($checkProductExixt == 0)
        {
            $data                   = new UserCart();
            $input['combo_id']      = $product->id;
            $input['user_id']       = $request->user_id;
            $input['qty']           = 1;
            $input['price']         = $product->price;
            $input['discount_percent']         = 0;
            $input['discounted_price']         = $product->price;
            $input['tax']           = $product->tax;
            $input['type']          = "combo";
            $save = $data->fill($input)->save();

            if($save)
            {
                return response()->json(['status' => true , 'msg' => 'Combo Package  successfully added into cart']);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => "Error's occurs try again later !!"]);
                exit;
            }
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Already exists !!"]);
            exit;
        }
    }

    public function add_coupon(Request $request){
        $rules = [
            'user_id' => 'required|numeric',
            'discount_coupon_code' => 'required',
        ];
        $msg = [
            'user_id.required' => 'Product ID cannot be empty',
            'discount_coupon_code.required' => 'Discount coupon cannot be empty',
        ];

        $validator = Validator::make($request->all() , $rules , $msg);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit();
        }
        else
        {
            $productss = [];
            $deliveryChargesData = [];
            $subTotal = 0;
            $tax = 0;
            $deliveryChargesData['hasDeliveryCharges'] = false;
            $deliveryChargesData['deliveryChargesss'] = 0;
            $products = UserCart::select("user_carts.*" , "products.product_img" , "products.product_name" ,
                "offers.discount" , "combopacks.package_name"  , "combopacks.image")
                ->leftjoin("products" , "user_carts.product_id" , "=" , "products.id")
                ->leftjoin("combopacks" , "user_carts.combo_id" , "=" , "combopacks.id")
                ->leftjoin("offers" , "user_carts.product_id" , "=" , "offers.product_id")
                ->where(['user_id' => $request->user_id])->get();
            foreach($products as $key => $p){
                $productss[$key]['id'] = $p->id;
                $productss[$key]['product_id'] = $p->product_id;
                $productss[$key]['combo_id'] = $p->combo_id;
                $productss[$key]['user_id'] = $p->user_id;
                $productss[$key]['qty'] = $p->qty;
                $productss[$key]['price'] = $p->price;
                $productss[$key]['tax'] = $p->tax;
                $productss[$key]['status'] = $p->status;
                $productss[$key]['extra'] = $p->extra;
                $productss[$key]['varients'] = $p->varients;
                $productss[$key]['properties'] = $p->properties;
                $productss[$key]['toppings'] = $p->toppings;
                $productss[$key]['type'] = $p->type;
                $productss[$key]['created_at'] = $p->created_at;
                $productss[$key]['updated_at'] = $p->updated_at;
                $productss[$key]['product_img'] = $p->product_img;
                $productss[$key]['product_name'] = $p->product_name;
                $productss[$key]['discount'] = $p->discount;
                $productss[$key]['package_name'] = $p->package_name;
                $productss[$key]['image'] = $p->image;

                $productsDEt = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
                    'offers.start_date' , 'offers.end_date')
                    ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
                    ->where('products.id', $p->product_id)
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
                if (!empty($p->varients)){
                    $Productvarient = ProductVarients::where(['product_id' => $p->product_id, 'varients_id' => $p->varients])->first();
                    $varientPrice = $Productvarient->varients_price - (($discount/100)*$Productvarient->varients_price);
                    $varients = Variation::where(['id' => $p->varients])->first();
                    $varientName = $varients->name;
                    $hasVarient = true;
                }else{
                    $varientPrice = 0;
                    $varientName = '';
                    $hasVarient = false;
                }
                $productss[$key]['varientPrice'] = $varientPrice;
                $productss[$key]['varientName'] = $varientName;
                $productss[$key]['hasVarient'] = $hasVarient;
                if(!empty($p->properties)){
                    if (isset($p->properties) && count(json_decode($p->properties)) > 0){
                        $ProductPropertiesItems = PropertiesItems::whereIn('id', json_decode($p->properties))->get();
                        $propertyItems = [];
                        $propertyItemTotalPrice = 0;
                        foreach($ProductPropertiesItems as $keyPI => $pi){
                            $propertyItems[$keyPI]['name'] = $pi->name;
                            $propertyItems[$keyPI]['price'] = $pi->price;
                            $propertyItemTotalPrice += $pi->price;
                        }
                        $hasProperties = true;
                    }else{
                        $propertyItems = [];
                        $propertyItemTotalPrice = 0;
                        $hasProperties = false;
                    }
                }else{
                    $propertyItems = [];
                    $propertyItemTotalPrice = 0;
                    $hasProperties = false;
                }

                $productss[$key]['propertyItems'] = $propertyItems;
                $productss[$key]['propertyItemTotalPrice'] = $propertyItemTotalPrice;
                $productss[$key]['hasProperties'] = $hasProperties;
                if (!empty($p->toppings)){
                    if (!empty($p->toppings) && count(json_decode($p->toppings)) > 0){

                        $ProductToppingsItems = IndItem::whereIn('id', json_decode($p->toppings))->get();
                        $ToppingItems = [];
                        $ToppingItemTotalPrice = 0;
                        foreach($ProductToppingsItems as $keyPT => $pt){
                            $ToppingItems[$keyPT]['name'] = $pt->name;
                            $ProductToppingsPrice = ProductToppings::where(['product_id' => $p->product_id, 'ingredients_id' => $pt->id])->first();
                            $ToppingItems[$keyPT]['price'] = $ProductToppingsPrice->ingredents_price;
                            $ToppingItemTotalPrice += $ProductToppingsPrice->ingredents_price;
                        }
                        $hasToppings = true;
                    }else{
                        $ToppingItems = [];
                        $ToppingItemTotalPrice = 0;
                        $hasToppings = false;
                    }
                }else{
                    $ToppingItems = [];
                    $ToppingItemTotalPrice = 0;
                    $hasToppings = false;
                }

                $productss[$key]['ToppingItems'] = $ToppingItems;
                $productss[$key]['ToppingItemTotalPrice'] = $ToppingItemTotalPrice;
                $productss[$key]['hasToppings'] = $hasToppings;
                $grandTotal = 0;
                if (!empty($p->varients)){
                    $grandTotal += $varientPrice;
                    if (!empty($p->properties)){
                        if (isset($p->properties) && count(json_decode($p->properties)) > 0){
                            $grandTotal += $propertyItemTotalPrice;
                        }
                    }
                    if (!empty($p->toppings)){
                        if (!empty($p->toppings) && count(json_decode($p->toppings)) > 0){
                            $grandTotal += $ToppingItemTotalPrice;
                        }
                    }
                }else{
                    $grandTotal += $p->price;
                }
                $productss[$key]['grandTotal'] = $grandTotal;

                $deliveryPrices = DeliveryCharges::first();
                if ($deliveryPrices->status == 1){
                    $deliveryChargesData = [];
                    $deliveryChargesData['hasDeliveryCharges'] = true;
                    $deliveryChargesData['deliveryChargesss'] = $deliveryPrices->charges;
                }else{
                    $deliveryChargesData = [];
                    $deliveryChargesData['hasDeliveryCharges'] = false;
                    $deliveryChargesData['deliveryChargesss'] = 0;
                }
                $subTotal += $grandTotal;
                $tax += (($p->tax / 100) * $grandTotal ) * $p->qty;
            }
            $discout = Coupons::where('coupon_name', $request->discount_coupon_code)->first();
            if ($discout){
                $total = floatval($subTotal)+floatval($tax)+floatval($deliveryChargesData['deliveryChargesss']);
                $discount_value = ($discout->discount/100)*$total;
                $subtotal_after_discount = $total - $discount_value;
                return response()->json(['status' => true , 'msg' => "Discount applied !!", 'data' => [
                    'total_before_discount' => $total,
                    'discount_amount' => $discount_value,
                    'discount_code' => $request->discount_coupon_code,
                    'total_after_discount' => $subtotal_after_discount,
                    'tax' => $tax,
                    'delivery_charge' => $deliveryChargesData
                ]]);
                exit;
            }else{
                return response()->json(['status' => false , 'msg' => "Coupon code not valid !!"]);
                exit;
            }
        }
    }



}
