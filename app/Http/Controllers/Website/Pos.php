<?php

namespace App\Http\Controllers\Website;

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
use App\Models\PropertiesSidesInCart;
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
 
use function Ramsey\Uuid\v1;

class Pos extends Controller
{
    /**
     * @return view pos detail
     */
    public function index()
    {
        $branches = Branches::all();
        $category = Category::get();
        $ship = UserAddress::where('user_id',Auth::guard('web')->user()->id)->get();
        $extra = ProductExtra::get();

        return view('website.pos_detail' , compact('category','ship','extra','branches'));
    }

    /**
     * @param Request $request
     * @method use for get sub category
     */
    public function get_sub_category(Request $request)
    {
        $data = SubCategory::where(['cate_id' => $request->cate_id])->get();
        return response()->json(['data' => $data]);
    }


    /**
     * @param Request $request
     * @method use for get menu
     */
    public function get_menu(Request $request)
    {
        if ($request->limit) {
            $limit = $request->limit;
        }else{
            $limit = 15;
        }

            $order_by = 'ASC';
            $name = 'product_name';

        if ($request->asc) {
            $name = 'product_name';
            $order_by = 'ASC';
        } elseif ($request->newest) {
            $name = 'name';
            $order_by = 'DESC';
        }
        $price = $request->price_sort;
        $topic = $request->topic_sort;

        $products = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
        'offers.start_date' , 'offers.end_date')
        ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id');
        // ->whereDate('offers.start_date' , '>=' , date('Y-m-d'))
        // ->whereDate('offers.end_date' , '<=' , date('Y-m-d'));

        if($request->cate_id) {
            $products = $products->where(['category' => $request->cate_id]);
        }
        if($request->sub_cate_id) {
            $products = $products->where(['sub_category' => $request->sub_cate_id]);
        }
        $products = $products->limit($limit)->orderBy('products.'.$name, $order_by)
        ->get();
        $total = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
        'offers.start_date' , 'offers.end_date')
        ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
        ->whereDate('offers.start_date' , '>=' , date('Y-m-d'))
        ->whereDate('offers.start_date' , '<=' , date('Y-m-d'));
        if($request->cate_id) {
            $total = $total->where(['category' => $request->cate_id]);
        }
        if($request->sub_cate_id) {
            $total = $total->where(['sub_category' => $request->sub_cate_id]);
        }
        $total = $total->limit($limit)->orderBy('products.'.$name, $order_by)
        ->count();


        foreach($products as $key => $p) {
            if (strtotime($p->start_date) <= strtotime(date('Y-m-d')) && strtotime($p->end_date) >= strtotime(date('Y-m-d'))){
                $discount = $p->discount;
            }else{
                $discount = 0;
            }
            $productss[$key]['id'] = $p->id;
            $productss[$key]['product_name'] = $p->product_name;
            $productss[$key]['product_img'] = $p->product_img;
            $productss[$key]['product_des'] = $p->product_des;
            $productss[$key]['qty'] = $p->qty;
            $productss[$key]['price'] = $p->price;
            $productss[$key]['tax'] = $p->tax;
            $productss[$key]['status'] = $p->status;
            $productss[$key]['category'] = $p->category;
            $productss[$key]['sub_category'] = $p->sub_category;
            $productss[$key]['child_category'] = $p->child_category;
            $productss[$key]['size'] = $p->size;
            $productss[$key]['type'] = $p->type;
            $productss[$key]['addon'] = $p->addon;
            $productss[$key]['extra'] = $p->extra;
            $productss[$key]['has_varients'] = $p->has_varients;
            $productss[$key]['has_properties'] = $p->has_properties;
            $productss[$key]['created_at'] = $p->created_at;
            $productss[$key]['updated_at'] = $p->updated_at;
            $productss[$key]['product_img'] = $p->product_img;
            $productss[$key]['product_name'] = $p->product_name;
            $productss[$key]['discount'] = $discount;
            $productss[$key]['package_name'] = $p->package_name;
            $productss[$key]['image'] = $p->image;
            $productss[$key]['offer_name'] = $p->offer_name;
            $productss[$key]['start_date'] = $p->start_date;
            $productss[$key]['end_date'] = $p->end_date;
            $productss[$key]['default_varients'] = $p->default_varients;
            $productss[$key]['default_toppings'] = $p->default_toppings;
            $productss[$key]['default_crust'] = $p->default_crust;
            $priceTotal = 0;
            if (!empty($p->default_varients)){
                $ProductDvarient = ProductVarients::where(['varients_id' => $p->default_varients, 'product_id' => $p->id])->get();
                foreach($ProductDvarient as $pvDkey => $pDv){
                    $priceTotal += $pDv->varients_price;
                }
                $hasDefaultVarient = true;
            }else{
                $hasDefaultVarient = false;
            }

            if (!empty($p->default_toppings)){
                $ProductDToping = PropertiesItems::whereIn('id', json_decode($p->default_toppings))->get();
                foreach($ProductDToping as $pvtop => $pDTop){
                    $priceTotal += (integer)$pDTop->price;
                }
            }

            if (!empty($p->default_crust)){
                $ProductCrust = ProductToppings::where(['ingredients_id' => $p->default_crust, 'product_id' => $p->id])->get();
                foreach($ProductCrust as $pvcrust => $pCrust){
                    $priceTotal += (integer)$pCrust->ingredents_price;
                }
            }


            if ($p->has_varients) {
                $allVarients = [];
                $Productvarient = ProductVarients::where(['product_id' => $p->id])->get();
                foreach($Productvarient as $pvkey => $pv){
                    $allVarients[$pvkey]['price'] = $pv->varients_price;
                    $varients = Variation::where(['id' => $pv->varients_id])->first();
                    $allVarients[$pvkey]['name'] = $varients->name;
                }
                $hasVarient = true;
            } else {
                $allVarients = [];
                $hasVarient = false;
            }
            $productss[$key]['allVarients'] = $allVarients;
            $productss[$key]['hasVarient'] = $hasVarient;


            $productss[$key]['total_default_price'] = $priceTotal;
            $productss[$key]['hasDefaultVarient'] = $hasDefaultVarient;
//            if (isset($p->properties) && count(json_decode($p->properties)) > 0) {
//                $ProductPropertiesItems = PropertiesItems::whereIn('id', json_decode($p->properties))->get();
//                $propertyItems = [];
//                $propertyItemTotalPrice = 0;
//                foreach ($ProductPropertiesItems as $keyPI => $pi) {
//                    $propertyItems[$keyPI]['name'] = $pi->name;
//                    $propertyItems[$keyPI]['price'] = $pi->price;
//                    $propertyItemTotalPrice += $pi->price;
//                }
//                $hasProperties = true;
//            } else {
//                $propertyItems = [];
//                $propertyItemTotalPrice = 0;
//                $hasProperties = false;
//            }
//            $productss[$key]['propertyItems'] = $propertyItems;
//            $productss[$key]['propertyItemTotalPrice'] = $propertyItemTotalPrice;
//            $productss[$key]['hasProperties'] = $hasProperties;
//            if (!empty($p->toppings) && count(json_decode($p->toppings)) > 0) {
//
//                $ProductToppingsItems = IndItem::whereIn('id', json_decode($p->toppings))->get();
//                $ToppingItems = [];
//                $ToppingItemTotalPrice = 0;
//                foreach ($ProductToppingsItems as $keyPT => $pt) {
//                    $ToppingItems[$keyPT]['name'] = $pt->name;
//                    $ProductToppingsPrice = ProductToppings::where(['product_id' => $p->product_id, 'ingredients_id' => $pt->id])->first();
//                    $ToppingItems[$keyPT]['price'] = $ProductToppingsPrice->ingredents_price;
//                    $ToppingItemTotalPrice += $ProductToppingsPrice->ingredents_price;
//                }
//                $hasToppings = true;
//            } else {
//                $ToppingItems = [];
//                $ToppingItemTotalPrice = 0;
//                $hasToppings = false;
//            }
//            $productss[$key]['ToppingItems'] = $ToppingItems;
//            $productss[$key]['ToppingItemTotalPrice'] = $ToppingItemTotalPrice;
//            $productss[$key]['hasToppings'] = $hasToppings;
//            $grandTotal = 0;
//            if (!empty($p->varients)) {
//                $grandTotal += $p->price;
//                $grandTotal += $varientPrice;
//                if (isset($p->properties) && count(json_decode($p->properties)) > 0) {
//                    $grandTotal += $propertyItemTotalPrice;
//                }
//                if (!empty($p->toppings) && count(json_decode($p->toppings)) > 0) {
//                    $grandTotal += $ToppingItemTotalPrice;
//                }
//            } else {
//                $grandTotal += $p->price;
//            }
//            $productss[$key]['grandTotal'] = $grandTotal;
        }
        return response()->json(['status' => true , 'products' => $productss , "limit" => $limit , "total" => $total, 'priceTotal' => $priceTotal  ]);
    }

    /**
     * @param Request $request
     * @method use for add to cart
     */
    public function add_to_cart(Request $request)
    {

        $product = Products::findOrFail($request->id);
        $checkProductExixt = UserCart::where(['product_id' => $request->id , 'user_id' => Auth::user()->id])->count();

        if($checkProductExixt == 0)
        {
            $data                   = new UserCart();
            $input['product_id']    = $product->id;
            $input['user_id']       = Auth::user()->id;
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
            $increaseProduct = UserCart::where(['product_id' => $request->id , 'user_id' => Auth::user()->id])->first();

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

    //extra product
    public function extra_Prod(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'extra_prod'=>'required'
        ],
    [
        'extra_prod.required' => 'extra product is required',
    ]);
        if($validator->fails())
        {
            $this->sendResponse(400,$validator->errors()->first(),[]);
        }

        else
        {
            $input                   = new WebOrderProduct();
            $input['prod_extra_id']         = $request->prod_extra;
            $save =$input->save();

            if($save)
            {
                return response()->json(['status' => true , 'msg' => 'Extra Product successfully added into cart']);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => "Error's occurs try again later !!"]);
                exit;
            }
        }
        // else
        // {
        //     return response()->json(['status' => false , 'msg' => "Already exists !!"]);
        //     exit;
        // }


    }

    /**
     * @method use for show cart list ajax
     */
    public function get_cart_list_ajax(Request $request)
    {
        $productss = [];
        $deliveryChargesData = [];
        $deliveryChargesData['hasDeliveryCharges'] = false;
        $deliveryChargesData['deliveryChargesss'] = 0;
        $products = UserCart::select("user_carts.*" , "products.product_img" , "products.product_name" ,
        "offers.discount" , "combopacks.package_name"  , "combopacks.image")
        ->leftjoin("products" , "user_carts.product_id" , "=" , "products.id")
        ->leftjoin("combopacks" , "user_carts.combo_id" , "=" , "combopacks.id")
        ->leftjoin("offers" , "user_carts.product_id" , "=" , "offers.product_id")
        ->where(['user_id' => Auth::user()->id])->get();
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
            if (!empty($p->properties)){
                if (isset($p->properties) && count(json_decode($p->properties)) > 0){
                    $ProductPropertiesItems = PropertiesItems::whereIn('id', json_decode($p->properties))->get();
                    $propertyItems = [];
                    $propertyItemTotalPrice = 0;
                    $wholeName = '';
                    $rightName = '';
                    $leftName = '';
                    $quatarName = '';
                    foreach($ProductPropertiesItems as $keyPI => $pi){
                        $properties_sides = PropertiesSidesInCart::where(['usercart_id' => $p->id, 'property_id' => $pi->id])->first();
                            if($properties_sides->sides === 'whole'){
                                $wholeName .= $pi->name.'('.$pi->price.'), ';
                                $wholesideZ = '<div class="avatar-container p-100"></div>';
                            }elseif($properties_sides->sides === 'left'){
                                $leftName .= $pi->name.'('.$pi->price.'), ';
                                $leftsideZ = '<div class="avatar-container p--50"></div>';
                            }elseif($properties_sides->sides === 'right'){
                                $rightName .= $pi->name.'('.$pi->price.'), ';
                                $rightsideZ = '<div class="avatar-container p-50"></div>';
                            }elseif($properties_sides->sides === 'quarter'){
                                $quatarName .= $pi->name.'('.$pi->price.'), ';
                                $quartersideZ = '<div class="avatar-container p-25"></div>';
                            }else{
                                $wholeName .= $pi->name.'('.$pi->price.'), ';
                            }

                            if (!empty($wholeName)){
                                $wholeSidePizza = '<div class="row"><div class="col-md-2" style="display: flex; justify-content: center;align-items: center"><span class="avatar-container p-100"></span></div><div class="col-md-10">'.$wholeName.'</div></div> <hr style="color: #ff9494;">';
                            }else{
                                $wholeSidePizza = '';
                            }

                            if (!empty($leftName)){
                                $leftSidePizza = '<div class="row"><div class="col-md-2" style="display: flex; justify-content: center;align-items: center"><span class="avatar-container p--50"></span></div><div class="col-md-10">'.$leftName.'</div></div> <hr style="color: #ff9494;">';
                            }else{
                                $leftSidePizza = '';
                            }

                            if (!empty($rightName)){
                                $rightSidePizza = '<div class="row"><div class="col-md-2" style="display: flex; justify-content: center;align-items: center"><span class="avatar-container p-50"></span></div><div class="col-md-10">'.$rightName.'</div></div> <hr style="color: #ff9494;">';
                            }else{
                                $rightSidePizza = '';
                            }

                            if (!empty($quatarName)){
                                $quatarSidePizza = '<div class="row"><div class="col-md-2" style="display: flex; justify-content: center;align-items: center"><span class="avatar-container p-25"></span></div><div class="col-md-10">'.$quatarName.'</div></div> <hr style="color: #ff9494;">    ';
                            }else{
                                $quatarSidePizza = '';
                            }

                        $propertyItems[0]['name'] = $wholeSidePizza.$leftSidePizza.$rightSidePizza.$quatarSidePizza;
                        $propertyItems[0]['price'] = $pi->price;
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
                if(!empty($p->toppings)){
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
        }

        return response()->json(['products' => $productss, 'deliveryCharges' => $deliveryChargesData]);
    }

    /**
     * @param Request $request
     * @method use for remove product form user cart
     */
    public function remove_from_cart(Request $request)
    {

        try{
            $where = array('id' => $request->cart_id);
            $cate = UserCart::find($request->cart_id);
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

    /**
     * @param Request $request
     * @method use for qty increase
     */
    public function qty_increase(Request $request)
    {
        $increaseProduct = UserCart::where(['id' => $request->id])->first();

        $increaseProduct->qty = ($request->qty + 1);

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

    /**
     * @param Request $request
     * @method use for qty qty_decrease
     */
    public function qty_decrease(Request $request)
    {
        $increaseProduct = UserCart::where(['id' => $request->id])->first();
        if($increaseProduct->qty > 1) {
            $increaseProduct->qty = ($request->qty - 1);

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
        else
        {
            return response()->json(['status' => false , 'msg' => "Minimum Qty 1"]);
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for place order
     */
    public function place_order(Request $request)
    {
//        echo json_encode($request->all());exit;
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
                $shipping_address = UserAddress::where(['user_id' => Auth::user()->id])->first();
                // $extra = ProductExtra::where(['id' => Auth::user()->id])->first();

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


                $checkCard = UserCart::where(['user_id' => Auth::user()->id])->get();
                // dd($request->address === 'undefined' ? 'Take Away' : 'Home Delivery');
                if($checkCard)
                {
                    $order                      = new WebOrder();
                    $input['user_id']           = Auth::user()->id;
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
                            $input1['user_id']      = Auth::user()->id;
                            $input1['product_id']   = $item->product_id;
                            $input1['cart_id']   = $item->id;
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
                            UserCart::where(['user_id' => Auth::user()->id])->delete();

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

    /**
     * @method use for show order history ajax list
     */
    public function order_history(Request $request)
    {
        if(isset($_GET['search']['value'])){
            $search = $_GET['search']['value'];
        }
        else{
            $search = '';
        }
        if(isset($_GET['length'])){
            $limit = $_GET['length'];
        }
        else{
            $limit = 10;
        }

        if(isset($_GET['start'])){
            $ofset = $_GET['start'];
        }
        else{
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        // $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

        $total = WebOrder::orWhere('txn_id' , 'like' , '%'. $search.'%')->where(['user_id' => Auth::user()->id])->count();
        $orders = WebOrder::select("web_orders.*" , 'users.name' , 'users.phone' , 'user_addresses.city' , 'user_addresses.state' ,
            'user_addresses.house' , 'user_addresses.street' , 'user_addresses.apartment' , 'user_addresses.cross_street')
            ->join('users' , 'web_orders.user_id' , '=' , 'users.id')
            ->join('user_addresses' , 'web_orders.shipping_address' , '=' , 'user_addresses.id')
            ->orWhere('txn_id' , 'like' , '%'. $search.'%')
            ->where(['web_orders.user_id' => Auth::user()->id])
            ->offset($ofset)->limit($limit)
            ->orderBy('id' , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($orders as $order) {
            $cancel = '';
             if( $order->status == "PENDING" || $order->status == "COOKING" || $order->status == "DISPATCHED")
            {
                $cancel = '<button class="statuscancel btn btn-sm btn-danger " data-status="' . "CANCELLED" . '" data-id="' . $order->id . '">' . "Cancel Order" . '  </button>';
            }
            $data[] = array(
                    date('d-m-Y' , strtotime($order->created_at)),
                    $order->phone,
                    $order->name,
                    $order->city . ' ' . $order->state . ' ' . $order->house . ' ' . $order->street . ' ' . $order->apartment . ' ' . $order->cross_street,
                    $order->txn_id,
                    $order->invoice_id,
                    $order->payment_mode,
                    $order->pay_amount,
                    ($order->status == "COMPLETED" ? '<button class="btn btn-sm btn-success">DELIVERED</button>' : ($order->status == "PENDING" ? '<button class="btn btn-sm btn-warning">PENDING</button>' : ($order->status == "CANCELLED" ? '<button class="btn btn-sm btn-danger">CANCELLED</button>' : ($order->status == "COOKING" ? '<button class="btn btn-sm btn-info">COOKING</button>' :($order->status == "DISPATCHED" ? '<button class="btn btn-sm btn-info">Food On the Way</button>' :''))))),
                    '<a href="javascript:void(0)" class="btn btn-warning btn-sm order_detail" data-id="'.$order->id.'"> Order Details </a>  '.$cancel.''

            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    // Cancel Order
    public function candelOrder(Request $request)
    {
        $order = WebOrder::findOrFail($request->id);
        $order->status = $request->status;
        $update = $order->update();
        if($update)
        {
            return response()->json(array('status' => true,'msg' => "Successfully Updated !"));
            exit;
        }
        else
        {
            return response()->json(array('status' => false,'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    public function Order_details($id)
    {
        $ship = HomeDeliveryAddress::where('user_id',Auth::guard('web')->user()->id)->first();


       $data = WebOrderProduct::select('web_order_products.*','products.product_name','products.product_name',
       'products.qty','products.price','products.type' , 'web_order_products.qty as order_qty')
        ->join('products','web_order_products.product_id','=','products.id')
        ->where('web_order_products.order_id',$id)
        ->paginate(10);

        return view('website.order_detail',compact('data','ship'));
    }
    public function extra_topping(Request $request)
    {
        $data = ProductExtra::where(['product_id' => $request->id])->get();
        return response()->json(['status' => true , "data" => $data]);
    }

    public function extra_variants(Request $request)
    {
        $products = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
        'offers.start_date' , 'offers.end_date')
        ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
        ->where('products.id', $request->id)
        ->first();
        if (!empty($products->discount)){
            if (strtotime($products->start_date) <= strtotime(date('Y-m-d')) && strtotime($products->end_date) >= strtotime(date('Y-m-d'))){
                $discount = $products->discount;
            }else{
                $discount = 0;
            }
        }else{
            $discount = 0;
        }
        $data = ProductVarients::select('product_variants.*','variations.name')->where(['product_id' => $request->id])->join('variations','variations.id','=','product_variants.varients_id')->get();
        $html = '<form class="new_add_to_cart" method="POST">';
        if (count($data)){
            $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;font-size: 1rem">Size</h6>
                        <div class="funkyradio row">
                        <input type="hidden" name="product_id" value="'.$request->id.'">
                        <input type="hidden" name="discount_percent" value="'.$discount.'">';
            foreach($data as $key => $var){
                $new_price = $var->varients_price - (($discount/100)*$var->varients_price);
                if ($var->varients_id == $products->default_varients){
                    $varientCheckedStatus = 'checked';
                }else{
                    $varientCheckedStatus = '';
                }
                $html .= '<div class="col">
                        <div class="funkyradio-success">
                            <input type="radio" name="varients" id="radio'.$key.'" value="'.$var->varients_id.'" '.$varientCheckedStatus.' required/>
                            <label for="radio'.$key.'"><span style="font-size: 12px">'.$var->name.' - $'.$new_price.'</span></label>
                        </div>
                    </div>';
            }

            $html .= '</div>
                    </div>';
        }

        $ProductToppings = ProductToppings::where(['product_id' => $request->id])->get();
        if (count($ProductToppings) > 0){
            $product_toppings_ids = [];
            foreach($ProductToppings as $ppI){
                $product_toppings_ids[] = $ppI->ingredients_id;
            }
            $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;margin-top: 1%;font-size: 1rem">Select Crust</h6>
                    <div class="owl-carousel owl-theme">';
            $ProductToppingsItems = IndItem::whereIn('id', $product_toppings_ids)->get();
            foreach($ProductToppingsItems as $keyPTI => $pti){
                $ProductToppingsPrice = ProductToppings::where(['ingredients_id' => $pti->id])->first();
                if ($pti->id == $products->default_crust){
                    $crustCheckedStatus = 'checked';
                }else{
                    $crustCheckedStatus = '';
                }
                $html .=    '
                        <div class="item">
                            <div class="card">
                                <div class="card-body text-center" style="padding: 0">
                                   <span>
                                       <input id="top'.$keyPTI.'" type="radio" class="custom-check" name="toppings[]" value="'.$pti->id.'" '.$crustCheckedStatus.'/>
                                       <label for="top'.$keyPTI.'" class="custom-label">'.$pti->name.' - $'.$ProductToppingsPrice->ingredents_price.'</label>
                                    </span>
                                </div>
                            </div>
                        </div>';
            }
            $html .='</div>
                </div>';
        }

        $ProductPropertyAll = ProductProperty::where(['product_id' => $request->id])->get();
        $pp_ids = [];
        foreach($ProductPropertyAll as $pps){
            $pp_ids[] = $pps['properties_id'];
        }

        $PropertiesNameAll = Propertie::get();
        $unArrangedProperties = [];
        foreach($PropertiesNameAll as $kkk => $pprs){
            $unArrangedProperties[$kkk]['id'] = $pprs['id'];
            $unArrangedProperties[$kkk]['position'] = $pprs['position'];
        }

        // Filter data array to include only elements with IDs present in $ids
        $filteredData = array_filter($unArrangedProperties, function ($item) use ($pp_ids) {
            return in_array($item['id'], $pp_ids);
        });

        // Sort the filtered data array based on 'id' and 'position'
        usort($filteredData, function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        // Extract the 'id' values from the sorted filtered data array
        $ProductProperty = array_column($filteredData, 'id');

        // echo json_encode($sortedIds); exit;
        if (count($ProductProperty) > 0){
            foreach($ProductProperty as $keyPP => $pp){
                $PropertiesName = Propertie::where(['id' => $pp])->first();
                $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;margin-top: 1%;font-size: 1rem">'.$PropertiesName->name.'</h6>
                    <div class="owl-carousel owl-theme">';
                $PropertiesItems = PropertiesItems::where(['properties_id' => $pp])->get();
                foreach($PropertiesItems as $keyPi => $pi){
                    if(!empty($products->default_toppings)){
                        if (in_array($pi->id, json_decode($products->default_toppings))){
                            $toppingsCheckedStatus = 'checked';
                            $pz_side = '<div class="avatar-container p-100"></div><input type="hidden" name="p-'.$pi->id.'" value="whole">';
                        }else{
                            $toppingsCheckedStatus = '';
                            $pz_side = '';
                        }
                    }else{
                        $toppingsCheckedStatus = '';
                        $pz_side = '';
                    }

                    $html .=    '<div class="item">
                            <div class="card">
                                <div class="card-body text-center" style="padding: 0">
                                   <span>
                                       <input id="bah'.$keyPi.$keyPP.'"  type="checkbox" class="custom-check abc" name="properties[]" value="'.$pi->id.'" '.$toppingsCheckedStatus.'/>
                                       <label for="bah'.$keyPi.$keyPP.'"  class="custom-label">'.$pi->name.' - $'.$pi->price.'</label>
                                    </span>
                                    <div class="text-center appendSide-'.$pi->id.' mt-2">'.$pz_side.'</div>
                                </div>
                            </div>
                        </div>';
                }
                $html .='</div>
                </div>';
            }


        }




        $html.= '<div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary add_topping" data-bs-target="modal">
                        <i class="fa fa-cart-shopping"></i> Add to Cart</button>
                    </div>
                   </form>';
        return response()->json(['status' => true , "data" => $html]);
    }

    /**
     * @method use for add extra into add to cart
     */
    public function extra_add_to_cart(Request $request)
    {
        $product = Products::findOrFail($request->product_id);
        $checkProductExixt = UserCart::where(['product_id' => $request->product_id , 'user_id' => Auth::user()->id])->count();

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
            $input['user_id']       = Auth::user()->id;
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
                if(!empty($request->properties)){
                    foreach($request->properties as $sidekey => $sidep){
                        PropertiesSidesInCart::where(['usercart_id' => $data->id, 'property_id' => $sidep])->delete();
                    }

                    foreach($request->properties as $sidekey => $sidep){
                        $data2                   = new PropertiesSidesInCart();
                        $input2['usercart_id']    = $data->id;
                        $input2['product_id']    = $product->id;
                        $input2['property_id']       = $sidep;
                        $sd = 'p-'.$sidep;
                        $input2['sides']           = $request->$sd;
                        $save2 = $data2->fill($input2)->save();
                    }
                }

                return response()->json(['status' => true , 'msg' => 'Menu successfully added into cart']);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => "Error's occurs try again later !!"]);
                exit;
            }

    }

    /**
     * @method use for show order detail history
     */
    public function orderHistoryDetail(Request $request) {

        if(isset($_GET['search']['value'])){
            $search = $_GET['search']['value'];
        }
        else{
            $search = '';
        }
        if(isset($_GET['length'])){
            $limit = $_GET['length'];
        }
        else{
            $limit = 10;
        }

        if(isset($_GET['start'])){
            $ofset = $_GET['start'];
        }
        else{
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];
        $orders = WebOrderProduct::select("web_order_products.*" , "products.product_name" , "products.product_img" ,
        "products.size" , "products.type as product_type" , "combopacks.package_name" , "combopacks.image")
        ->leftjoin('products' , 'web_order_products.product_id' , '=' , 'products.id')
        ->leftjoin('combopacks' , 'web_order_products.combo_pack_id' , '=' , 'combopacks.id')
        ->where(['order_id' => $request->order_id])->get();

        $total = WebOrderProduct::select("web_order_products.*" , "products.product_name" , "products.product_img" ,
        "products.size" , "products.type" , "combopacks.package_name" , "combopacks.image")
        ->leftjoin('products' , 'web_order_products.product_id' , '=' , 'products.id')
        ->leftjoin('combopacks' , 'web_order_products.combo_pack_id' , '=' , 'combopacks.id')
        ->where(['order_id' => $request->order_id])->count();
        $i = 1 + $ofset;
        $data = [];

        foreach ($orders as $order) {
            if($order->type == "combo") {
                $img = $order->image;
                $new_name = $order->package_name;
            }else{
                $img = $order->product_img;
                $new_name = $order->product_name;
            }
            if(!empty($order->varients)){
                $varientDetails = Variation::where(['id' => $order->varients])->first();
                $varient = '<br><span>Size :</span><span>'.$varientDetails->name.'</span>';
            }else{
                $varient = '';
            }

            if(!empty($order->toppings) && count(json_decode($order->toppings)) > 0){
                $crust = '';
                foreach(json_decode($order->toppings) as $keyTop => $top){
                    $topping = IndItem::where(['id' => $top])->first();
                    $crust .= '<br><span>Crust :</span><span>'.$topping->name.'</span><br>';
                }
            }else{
                $crust = '';
            }

            if(!empty($order->properties) && count(json_decode($order->properties)) > 0){
                $toppings = '<span>Toppings :</span><span>';
                $properties = PropertiesItems::whereIn('id', json_decode($order->properties))->get();
                foreach($properties as $keyPOP => $pop){
                    $toppings .= $pop->name;
                }
                $toppings .= '</span><br>';
            }else{
                $toppings = '';
            }

            $data[] = array(
                    '<img src="'.url($img).'" class="rounded" style="height: 30px; width: 30px;"><br><b>'.$new_name .'</b>'.$varient.$crust.$toppings,
                    $order->base_price,
                    $order->qty,
//                    ($order->type == "combo" ? $order->type .'&nbsp;<a href="javascrit:void(0)" class="btn btn-success show_detail" data-id="'.$order->combo_pack_id.'"><i class="fa fa-eye"></i></a>' : $order->product_type),
                    number_format($order->qty * $order->base_price , 2),
            );

        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @method use for check coupon
     */
    public function check_coupon(Request $request)
    {
        $data   = Coupons::where(['coupon_name' => $request->value])
        // ->whereDate('start_date' , '>=' , date('Y-m-d'))->whereDate('end_date' , '<=' , date('Y-m-d'))
        ->first();

        return response()->json(['status' => true , 'data' => $data]);
    }

    /**
     * @method use for get combo pack
     */
    public function get_combo_pack(Request $request) {
        if ($request->limit) {
            $limit = $request->limit;
        }else{
            $limit = 15;
        }

            $order_by = 'ASC';
            $name = 'package_name';

        if ($request->asc) {
            $name = 'package_name';
            $order_by = 'ASC';
        } elseif ($request->newest) {
            $name = 'name';
            $order_by = 'DESC';
        }

        $products = Combopack::select("combopacks.*");
        $products = $products->limit($limit)->orderBy('combopacks.'.$name, $order_by)
        ->get();
        $total = Combopack::select("combopacks.*");
        $total = $total->limit($limit)->orderBy('combopacks.'.$name, $order_by)
        ->count();

        return response()->json(['status' => true , 'products' => $products , "limit" => $limit , "total" => $total ]);
    }

    /**
     * @method use for get combo pack detail
     */
    public function combo_pack_detail(Request $request) {
        $data   = ComboProduct::select("combo_products.*" , "products.product_name" , "products.product_img" ,
        "products.price")
        ->join('products' , 'combo_products.product_id' , '=' , 'products.id')
        ->where(['combo_products.pack_id' => $request->combo_id])->get();

        return response()->json(['status' => true , 'data' => $data]);
    }

    /**
     * @method use for combo pack add to cart
     */
    public function comboPackAddToCart(Request $request){

        $product = Combopack::findOrFail($request->combo_id);
        $checkProductExixt = UserCart::where(['combo_id' => $request->combo_id , 'user_id' => Auth::user()->id])->count();

        if($checkProductExixt == 0)
        {
            $data                   = new UserCart();
            $input['combo_id']      = $product->id;
            $input['user_id']       = Auth::user()->id;
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


    public function extra_variants_update(Request $request)
    {
        // dd($request->all());
        $cartData = UserCart::where('id',$request->orderid)->first();
        // dd(json_decode($cartData->properties));
        $products = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
        'offers.start_date' , 'offers.end_date')
        ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
        ->where('products.id', $request->id)
        ->first();
        if (!empty($products->discount)){
            if (strtotime($products->start_date) <= strtotime(date('Y-m-d')) && strtotime($products->end_date) >= strtotime(date('Y-m-d'))){
                $discount = $products->discount;
            }else{
                $discount = 0;
            }
        }else{
            $discount = 0;
        }
        $data = ProductVarients::select('product_variants.*','variations.name')->where(['product_id' => $request->id])->join('variations','variations.id','=','product_variants.varients_id')->get();
        $html = '<form class="update_cart" method="POST">';
        if (count($data)){
            $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;font-size: 1rem">Size</h6>
                        <div class="funkyradio row">
                        <input type="hidden" name="product_id" value="'.$request->id.'">
                        <input type="hidden" name="cartOrder" value="'.$request->orderid.'">
                        <input type="hidden" name="discount_percent" value="'.$discount.'">';
            foreach($data as $key => $var){
                $new_price = $var->varients_price - (($discount/100)*$var->varients_price);
                if ($var->varients_id == $cartData->varients){
                    $varientCheckedStatus = 'checked';
                }else{
                    $varientCheckedStatus = '';
                }
                $html .= '<div class="col">
                        <div class="funkyradio-success">
                            <input type="radio" name="varients" id="radio'.$key.'" value="'.$var->varients_id.'" '.$varientCheckedStatus.' required/>
                            <label for="radio'.$key.'"><span style="font-size: 12px">'.$var->name.' - $'.$new_price.'</span></label>
                        </div>
                    </div>';
            }

            $html .= '</div>
                    </div>';
        }

        $ProductToppings = ProductToppings::where(['product_id' => $request->id])->get();
        if (count($ProductToppings) > 0){
            $product_toppings_ids = [];
            foreach($ProductToppings as $ppI){
                $product_toppings_ids[] = $ppI->ingredients_id;
            }
            $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;margin-top: 1%;font-size: 1rem">Select Crust</h6>
                    <div class="owl-carousel owl-theme">';
            $ProductToppingsItems = IndItem::whereIn('id', $product_toppings_ids)->get();
            foreach($ProductToppingsItems as $keyPTI => $pti){
                $ProductToppingsPrice = ProductToppings::where(['ingredients_id' => $pti->id])->first();
                if (in_array($pti->id, json_decode($cartData->toppings))){
                    $crustCheckedStatus = 'checked';
                }else{
                    $crustCheckedStatus = '';
                }
                $html .=    '
                        <div class="item">
                            <div class="card">
                                <div class="card-body text-center" style="padding: 0">
                                   <span>
                                       <input id="top'.$keyPTI.'" type="radio" class="custom-check" name="toppings[]" value="'.$pti->id.'" '.$crustCheckedStatus.'/>
                                       <label for="top'.$keyPTI.'" class="custom-label">'.$pti->name.' - $'.$ProductToppingsPrice->ingredents_price.'</label>
                                    </span>
                                </div>
                            </div>
                        </div>';
            }
            $html .='</div>
                </div>';
        }

        $ProductPropertyAll = ProductProperty::where(['product_id' => $request->id])->get();
        $pp_ids = [];
        foreach($ProductPropertyAll as $pps){
            $pp_ids[] = $pps['properties_id'];
        }

        $PropertiesNameAll = Propertie::get();
        $unArrangedProperties = [];
        foreach($PropertiesNameAll as $kkk => $pprs){
            $unArrangedProperties[$kkk]['id'] = $pprs['id'];
            $unArrangedProperties[$kkk]['position'] = $pprs['position'];
        }

        // Filter data array to include only elements with IDs present in $ids
        $filteredData = array_filter($unArrangedProperties, function ($item) use ($pp_ids) {
            return in_array($item['id'], $pp_ids);
        });

        // Sort the filtered data array based on 'id' and 'position'
        usort($filteredData, function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        // Extract the 'id' values from the sorted filtered data array
        $ProductProperty = array_column($filteredData, 'id');

        // echo json_encode($sortedIds); exit;
        if (count($ProductProperty) > 0){
            foreach($ProductProperty as $keyPP => $pp){
                $PropertiesName = Propertie::where(['id' => $pp])->first();
                $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;margin-top: 1%;font-size: 1rem">'.$PropertiesName->name.'</h6>
                    <div class="owl-carousel owl-theme">';
                $PropertiesItems = PropertiesItems::where(['properties_id' => $pp])->get();
                foreach($PropertiesItems as $keyPi => $pi){
                    if(!empty($products->default_toppings)){
                        if (in_array($pi->id,json_decode($cartData->properties) )){

                            $sides_selected = PropertiesSidesInCart::where(['usercart_id' => $request->orderid, 'property_id' => $pi->id])->first();
                            if($sides_selected->sides === 'whole'){
                                $side_S = '<div class="avatar-container p-100"></div>';
                            }elseif($sides_selected->sides === 'left'){
                                $side_S = '<div class="avatar-container p--50"></div>';
                            }elseif($sides_selected->sides === 'right'){
                                $side_S = '<div class="avatar-container p-50"></div>';
                            }elseif($sides_selected->sides === 'quarter'){
                                $side_S = '<div class="avatar-container p-25"></div>';
                            }else{
                                $side_S = '<div class="avatar-container p-100"></div>';
                            }

                            $toppingsCheckedStatus = 'checked';
                            $pz_side = '<div class="avatar-container p-100"></div><input type="hidden" name="p-'.$pi->id.'" value="whole">';
                        }else{
                            $toppingsCheckedStatus = '';
                            $pz_side = '';
                        }
                    }else{
                        if (in_array($pi->id,json_decode($cartData->properties) )){

                            $sides_selected = PropertiesSidesInCart::where(['usercart_id' => $request->orderid, 'property_id' => $pi->id])->first();
                            if($sides_selected->sides === 'whole'){
                                $side_S = '<div class="avatar-container p-100"></div>';
                            }elseif($sides_selected->sides === 'left'){
                                $side_S = '<div class="avatar-container p--50"></div>';
                            }elseif($sides_selected->sides === 'right'){
                                $side_S = '<div class="avatar-container p-50"></div>';
                            }elseif($sides_selected->sides === 'quarter'){
                                $side_S = '<div class="avatar-container p-25"></div>';
                            }else{
                                $side_S = '<div class="avatar-container p-100"></div>';
                            }

                            $toppingsCheckedStatus = 'checked';
                            $pz_side = $side_S.'<input type="hidden" name="p-'.$pi->id.'" value="whole">';
                        }else{
                            $toppingsCheckedStatus = '';
                            $pz_side = '';
                        }
                    }

                    $html .=    '<div class="item">
                            <div class="card">
                                <div class="card-body text-center" style="padding: 0">
                                   <span>
                                       <input id="bah'.$keyPi.$keyPP.'"  type="checkbox" class="custom-check abc" name="properties[]" value="'.$pi->id.'" '.$toppingsCheckedStatus.'/>
                                       <label for="bah'.$keyPi.$keyPP.'"  class="custom-label">'.$pi->name.' - $'.$pi->price.'</label>
                                    </span>
                                    <div class="text-center appendSide-'.$pi->id.' mt-2">'.$pz_side.'</div>
                                </div>
                            </div>
                        </div>';
                }
                $html .='</div>
                </div>';
            }


        }




        $html.= '<div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updates_topping" data-bs-target="modal">
                        <i class="fa fa-cart-shopping"></i> Update Cart</button>
                    </div>
                   </form>';
        return response()->json(['status' => true , "data" => $html]);
    }


    public function update_cart(Request $request)
    {
        // dd($request->all());
        $product = Products::findOrFail($request->product_id);
        $checkProductExixt = UserCart::where(['product_id' => $request->product_id , 'user_id' => Auth::user()->id])->count();

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
            
            $data                   =  UserCart::findOrFail($request->cartOrder);
            $input['product_id']    = $product->id;
            $input['user_id']       = Auth::user()->id;
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
                if(!empty($request->properties)){
                    foreach($request->properties as $sidekey => $sidep){
                        PropertiesSidesInCart::where(['usercart_id' => $data->id, 'property_id' => $sidep])->delete();
                    }

                    foreach($request->properties as $sidekey => $sidep){
                        $data2                   = new PropertiesSidesInCart();
                        $input2['usercart_id']    = $data->id;
                        $input2['product_id']    = $product->id;
                        $input2['property_id']       = $sidep;
                        $sd = 'p-'.$sidep;
                        $input2['sides']           = $request->$sd;
                        $save2 = $data2->fill($input2)->save();
                    }
                }

                return response()->json(['status' => true , 'msg' => 'Cart Updated ']);
                exit;
            }
            else
            {
                return response()->json(['status' => false , 'msg' => "Error's occurs try again later !!"]);
                exit;
            }

    }
















}
