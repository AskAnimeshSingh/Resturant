<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductVarients;
use App\Models\ProductProperty;
use App\Models\ProductToppings;
use App\Models\IndItem;
use App\Models\IndGrp;
use App\Models\Propertie;
use App\Models\Combopack;
use App\Models\ComboProduct;
use App\Models\PropertiesItems;
use App\Models\Products;
use App\Models\Variation;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\WebOrderProduct;
use App\Models\userCart;
use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function get_categories(){
        $categoriesData = Category::where('status', 1)->get();

        if ($categoriesData) {
            return response()->json([
                'status' => true,
                'message' => 'Categories Available',
                'data' => $categoriesData
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Not Available',
                'data' => '',
            ], 401);
        }
    }


    public function get_subcategories(Request $request){
        $categoriesData = SubCategory::where(['cate_id' => $request->category_id, 'status' => 1])->get();

        if ($categoriesData) {
            return response()->json([
                'status' => true,
                'message' => 'Sub-categories Available',
                'data' => $categoriesData
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Not Available',
                'data' => '',
            ], 401);
        }
    }


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
            $name = 'product_name';
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
            if ($p->has_varients) {
                $allVarients = [];
                $Productvarient = ProductVarients::where(['product_id' => $p->id])->get();
                foreach($Productvarient as $pvkey => $pv){
                    $allVarients[$pvkey]['varient_id'] = $pv->varients_id;
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

            if ($p->has_properties) {
                $allProperties = [];
                $ProducProperty = ProductProperty::where(['product_id' => $p->id])->get();
                foreach($ProducProperty as $ppkey => $pp){
                    $propertyItem = [];
                    $PropertiesDetails = Propertie::where(['id' => $pp->properties_id, 'status' => 1])->first();
                    $allProperties[$ppkey]['properties_id'] = $PropertiesDetails->id;
                    $allProperties[$ppkey]['property_name'] = $PropertiesDetails->name;
                    $PropertiesItems = PropertiesItems::where(['properties_id' => $pp->properties_id, 'status' => 1])->get();
                    $allProperties[$ppkey]['PropertiesItems'] = $PropertiesItems;
                }
                $hasProperties = true;
            } else {
                $allProperties = [];
                $hasProperties = false;
            }
            $productss[$key]['allProperties'] = $allProperties;
            $productss[$key]['hasProperties'] = $hasProperties;

            $ProductInd = ProductToppings::where(['product_id' => $p->id])->get();
            $allIngredients = [];
            if (count($ProductInd) > 0){
                foreach($ProductInd as $Idnkey => $Idn){
                    $IndItemsDetails = IndItem::where(['id' => $Idn->ingredients_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_id'] = $Idn->ingredients_id;
                    $allIngredients[$Idnkey]['ing_name'] = $IndItemsDetails->name;
                    $allIngredients[$Idnkey]['ing_price'] = $Idn->ingredents_price;
                    $IndGroupsDetails = IndGrp::where(['id' => $IndItemsDetails->ind_grp_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_group'] = $IndGroupsDetails->name;
                }
                $hasIngredents = true;
            }else{
                $allIngredients = [];
                $hasIngredents = false;
            }
            $productss[$key]['allIngreients'] = $allIngredients;
            $productss[$key]['hasIngrients'] = $hasIngredents;
        }
        return response()->json(['status' => true , 'products' => $productss , "limit" => $limit , "total" => $total ]);
    }


    public function product_details(Request $request){
        if ($request->product_id) {
            $product_id = $request->product_id;
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Product id cannot be empty',
                'data' => null
            ], 401);
        }

        $p = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
            'offers.start_date' , 'offers.end_date')
            ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
            ->where('products.id', $product_id)
            ->first();
        if (!$p){
            return response()->json([
                'status' => false,
                'message' => 'Product id is invalid',
                'data' => null
            ], 401);
        }

            $productss = [];
            if (strtotime($p->start_date) <= strtotime(date('Y-m-d')) && strtotime($p->end_date) >= strtotime(date('Y-m-d'))){
                $discount = $p->discount;
            }else{
                $discount = 0;
            }
            $productss['id'] = $p->id;
            $productss['product_name'] = $p->product_name;
            $productss['product_img'] = $p->product_img;
            $productss['product_des'] = $p->product_des;
            $productss['qty'] = $p->qty;
            $productss['price'] = $p->price;
            $productss['tax'] = $p->tax;
            $productss['status'] = $p->status;
            $productss['category'] = $p->category;
            $productss['sub_category'] = $p->sub_category;
            $productss['child_category'] = $p->child_category;
            $productss['size'] = $p->size;
            $productss['type'] = $p->type;
            $productss['addon'] = $p->addon;
            $productss['extra'] = $p->extra;
            $productss['has_varients'] = $p->has_varients;
            $productss['has_properties'] = $p->has_properties;
            $productss['created_at'] = $p->created_at;
            $productss['updated_at'] = $p->updated_at;
            $productss['product_img'] = $p->product_img;
            $productss['product_name'] = $p->product_name;
            $productss['discount'] = $discount;
            $productss['package_name'] = $p->package_name;
            $productss['image'] = $p->image;
            $productss['offer_name'] = $p->offer_name;
            $productss['start_date'] = $p->start_date;
            $productss['end_date'] = $p->end_date;
            if ($p->has_varients) {
                $allVarients = [];
                $Productvarient = ProductVarients::where(['product_id' => $p->id])->get();
                foreach($Productvarient as $pvkey => $pv){
                    $allVarients[$pvkey]['varient_id'] = $pv->varients_id;
                    $allVarients[$pvkey]['price'] = $pv->varients_price;
                    $varients = Variation::where(['id' => $pv->varients_id])->first();
                    $allVarients[$pvkey]['name'] = $varients->name;
                }
                $hasVarient = true;
            } else {
                $allVarients = [];
                $hasVarient = false;
            }
            $productss['allVarients'] = $allVarients;
            $productss['hasVarient'] = $hasVarient;

            if ($p->has_properties) {
                $allProperties = [];
                $ProducProperty = ProductProperty::where(['product_id' => $p->id])->get();
                foreach($ProducProperty as $ppkey => $pp){
                    $propertyItem = [];
                    $PropertiesDetails = Propertie::where(['id' => $pp->properties_id, 'status' => 1])->first();
                    $allProperties[$ppkey]['properties_id'] = $PropertiesDetails->id;
                    $allProperties[$ppkey]['property_name'] = $PropertiesDetails->name;
                    $PropertiesItems = PropertiesItems::where(['properties_id' => $pp->properties_id, 'status' => 1])->get();
                    $allProperties[$ppkey]['PropertiesItems'] = $PropertiesItems;
                }
                $hasProperties = true;
            } else {
                $allProperties = [];
                $hasProperties = false;
            }
            $productss['allProperties'] = $allProperties;
            $productss['hasProperties'] = $hasProperties;

            $ProductInd = ProductToppings::where(['product_id' => $p->id])->get();
            $allIngredients = [];
            if (count($ProductInd) > 0){
                foreach($ProductInd as $Idnkey => $Idn){
                    $IndItemsDetails = IndItem::where(['id' => $Idn->ingredients_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_id'] = $Idn->ingredients_id;
                    $allIngredients[$Idnkey]['ing_name'] = $IndItemsDetails->name;
                    $allIngredients[$Idnkey]['ing_price'] = $Idn->ingredents_price;
                    $IndGroupsDetails = IndGrp::where(['id' => $IndItemsDetails->ind_grp_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_group'] = $IndGroupsDetails->name;
                }
                $hasIngredents = true;
            }else{
                $allIngredients = [];
                $hasIngredents = false;
            }
            $productss['allIngreients'] = $allIngredients;
            $productss['hasIngrients'] = $hasIngredents;
            // $cart = userCart::where(['product_id' => $product_id, 'user_id' => $request->user_id])->first();
            // if (!$cart){
            //     $productss['isAddedInCart'] = false;
            // }else{
            //     $productss['isAddedInCart'] = true;
            // }

        return response()->json([
            'status' => true,
            'message' => 'Product details found!!',
            'data' => $productss
        ], 201);
    }


   public function combo_list(Request $request) {
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
            $name = 'package_name';
            $order_by = 'DESC';
        }

        $products = Combopack::select("combopacks.*");
        $products = $products->limit($limit)->orderBy('combopacks.'.$name, $order_by)
            ->get();
        $pp = [];
        foreach($products as $key => $p){
            $pp[$key]['id'] = $p->id;
            $pp[$key]['package_name'] = $p->package_name;
            $pp[$key]['start_date'] = $p->start_date;
            $pp[$key]['end_date'] = $p->end_date;
            $pp[$key]['status'] = $p->status;
            $pp[$key]['price'] = $p->price;
            $pp[$key]['tax'] = $p->tax;
            $pp[$key]['image'] = $p->image;
            $pp[$key]['created_at'] = $p->created_at;
            $pp[$key]['updated_at'] = $p->updated_at;

            // $cart = userCart::where(['combo_id' => $p->id, 'user_id' => $request->user_id])->first();
            // if (!$cart){
            //     $pp[$key]['isAddedInCart'] = false;
            // }else{
            //     $pp[$key]['isAddedInCart'] = true;
            // }
        }
        $total = Combopack::select("combopacks.*");
        $total = $total->limit($limit)->orderBy('combopacks.'.$name, $order_by)
            ->count();

        return response()->json(['status' => true , 'products' => $pp , "limit" => $limit , "total" => $total ]);
    }

    public function combo_product_details(Request $request) {
        $data   = ComboProduct::select("combo_products.*" , "products.product_name" , "products.product_img" ,
            "products.price")
            ->join('products' , 'combo_products.product_id' , '=' , 'products.id')
            ->where(['combo_products.pack_id' => $request->combo_id])->get();

        return response()->json(['status' => true , 'data' => $data]);
    }

    public function latest_menu(Request $request)
    {
        if ($request->limit) {
            $limit = $request->limit;
        }else{
            $limit = 15;
        }

        $order_by = 'ASC';
        $name = 'product_name';

        if ($request->asc) {
            $name = 'id';
            $order_by = 'ASC';
        } elseif ($request->newest) {
            $name = 'id';
            $order_by = 'DESC';
        }
        $price = $request->price_sort;
        $topic = $request->topic_sort;

        $products = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
            'offers.start_date' , 'offers.end_date')
            ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id');
//         ->whereDate('offers.start_date' , '>=' , date('Y-m-d'))
//         ->whereDate('offers.end_date' , '<=' , date('Y-m-d'));

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
            if ($p->has_varients) {
                $allVarients = [];
                $Productvarient = ProductVarients::where(['product_id' => $p->id])->get();
                foreach($Productvarient as $pvkey => $pv){
                    $allVarients[$pvkey]['varient_id'] = $pv->varients_id;
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

            if ($p->has_properties) {
                $allProperties = [];
                $ProducProperty = ProductProperty::where(['product_id' => $p->id])->get();
                foreach($ProducProperty as $ppkey => $pp){
                    $propertyItem = [];
                    $PropertiesDetails = Propertie::where(['id' => $pp->properties_id, 'status' => 1])->first();
                    $allProperties[$ppkey]['properties_id'] = $PropertiesDetails->id;
                    $allProperties[$ppkey]['property_name'] = $PropertiesDetails->name;
                    $PropertiesItems = PropertiesItems::where(['properties_id' => $pp->properties_id, 'status' => 1])->get();
                    $allProperties[$ppkey]['PropertiesItems'] = $PropertiesItems;
                }
                $hasProperties = true;
            } else {
                $allProperties = [];
                $hasProperties = false;
            }
            $productss[$key]['allProperties'] = $allProperties;
            $productss[$key]['hasProperties'] = $hasProperties;

            $ProductInd = ProductToppings::where(['product_id' => $p->id])->get();
            $allIngredients = [];
            if (count($ProductInd) > 0){
                foreach($ProductInd as $Idnkey => $Idn){
                    $IndItemsDetails = IndItem::where(['id' => $Idn->ingredients_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_id'] = $Idn->ingredients_id;
                    $allIngredients[$Idnkey]['ing_name'] = $IndItemsDetails->name;
                    $allIngredients[$Idnkey]['ing_price'] = $Idn->ingredents_price;
                    $IndGroupsDetails = IndGrp::where(['id' => $IndItemsDetails->ind_grp_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_group'] = $IndGroupsDetails->name;
                }
                $hasIngredents = true;
            }else{
                $allIngredients = [];
                $hasIngredents = false;
            }
            $productss[$key]['allIngreients'] = $allIngredients;
            $productss[$key]['hasIngrients'] = $hasIngredents;
        }
        return response()->json(['status' => true , 'products' => $productss , "limit" => $limit , "total" => $total ]);
    }

    public function polular_menu(Request $request)
    {

        $orderProducts = WebOrderProduct::whereNotNull('product_id')->get();
        $product_ids = [];
        foreach($orderProducts as $op){
            $product_ids[] = $op->product_id;
        }

        $array = array_count_values($product_ids); //get all occurrences of each values
        arsort($array);
        $value=[];

        foreach($array as $key=>$val){

            $value= array_merge($value,array_fill(0,$val,$key));
        }
        $ids = [];
        foreach($value as $vv){
            if (!in_array($vv, $ids)){
                $ids[] = $vv;
            }
        }

        $products = [];
        foreach($ids as $Pid){
            $product = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
                'offers.start_date' , 'offers.end_date')
                ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id')
                ->where('products.id', $Pid);

            if($request->cate_id) {
                $product = $product->where(['category' => $request->cate_id]);
            }
            if($request->sub_cate_id) {
                $product = $product->where(['sub_category' => $request->sub_cate_id]);
            }
            $product = $product->first();
            $products[] = $product;
        }


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
            if ($p->has_varients) {
                $allVarients = [];
                $Productvarient = ProductVarients::where(['product_id' => $p->id])->get();
                foreach($Productvarient as $pvkey => $pv){
                    $allVarients[$pvkey]['varient_id'] = $pv->varients_id;
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

            if ($p->has_properties) {
                $allProperties = [];
                $ProducProperty = ProductProperty::where(['product_id' => $p->id])->get();
                foreach($ProducProperty as $ppkey => $pp){
                    $propertyItem = [];
                    $PropertiesDetails = Propertie::where(['id' => $pp->properties_id, 'status' => 1])->first();
                    $allProperties[$ppkey]['properties_id'] = $PropertiesDetails->id;
                    $allProperties[$ppkey]['property_name'] = $PropertiesDetails->name;
                    $PropertiesItems = PropertiesItems::where(['properties_id' => $pp->properties_id, 'status' => 1])->get();
                    $allProperties[$ppkey]['PropertiesItems'] = $PropertiesItems;
                }
                $hasProperties = true;
            } else {
                $allProperties = [];
                $hasProperties = false;
            }
            $productss[$key]['allProperties'] = $allProperties;
            $productss[$key]['hasProperties'] = $hasProperties;

            $ProductInd = ProductToppings::where(['product_id' => $p->id])->get();
            $allIngredients = [];
            if (count($ProductInd) > 0){
                foreach($ProductInd as $Idnkey => $Idn){
                    $IndItemsDetails = IndItem::where(['id' => $Idn->ingredients_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_id'] = $Idn->ingredients_id;
                    $allIngredients[$Idnkey]['ing_name'] = $IndItemsDetails->name;
                    $allIngredients[$Idnkey]['ing_price'] = $Idn->ingredents_price;
                    $IndGroupsDetails = IndGrp::where(['id' => $IndItemsDetails->ind_grp_id, 'status' => 1])->first();
                    $allIngredients[$Idnkey]['ing_group'] = $IndGroupsDetails->name;
                }
                $hasIngredents = true;
            }else{
                $allIngredients = [];
                $hasIngredents = false;
            }
            $productss[$key]['allIngreients'] = $allIngredients;
            $productss[$key]['hasIngrients'] = $hasIngredents;
        }
        return response()->json(['status' => true , 'products' => $productss  ]);
    }

    public function search_menu(Request $request)
    {
        if ($request->limit) {
            $limit = $request->limit;
        }else{
            $limit = 15;
        }

        $products = Products::select("products.*" , "offers.name as offer_name" , 'offers.discount' ,
            'offers.start_date' , 'offers.end_date')
            ->leftjoin('offers' , 'products.id' , '=' , 'offers.product_id');
        if($request->search) {
            $products = $products->orWhere('product_name', 'like', '%' . $request->search . '%')->orWhere('product_des', 'like', '%' . $request->search . '%');
        }

        if($request->cate_id) {
            $products = $products->where(['category' => $request->cate_id]);
        }
        if($request->sub_cate_id) {
            $products = $products->where(['sub_category' => $request->sub_cate_id]);
        }
        $products = $products->limit($limit)->get();


        if (count($products) > 0){
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
                if ($p->has_varients) {
                    $allVarients = [];
                    $Productvarient = ProductVarients::where(['product_id' => $p->id])->get();
                    foreach($Productvarient as $pvkey => $pv){
                        $allVarients[$pvkey]['varient_id'] = $pv->varients_id;
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

                if ($p->has_properties) {
                    $allProperties = [];
                    $ProducProperty = ProductProperty::where(['product_id' => $p->id])->get();
                    foreach($ProducProperty as $ppkey => $pp){
                        $propertyItem = [];
                        $PropertiesDetails = Propertie::where(['id' => $pp->properties_id, 'status' => 1])->first();
                        $allProperties[$ppkey]['properties_id'] = $PropertiesDetails->id;
                        $allProperties[$ppkey]['property_name'] = $PropertiesDetails->name;
                        $PropertiesItems = PropertiesItems::where(['properties_id' => $pp->properties_id, 'status' => 1])->get();
                        $allProperties[$ppkey]['PropertiesItems'] = $PropertiesItems;
                    }
                    $hasProperties = true;
                } else {
                    $allProperties = [];
                    $hasProperties = false;
                }
                $productss[$key]['allProperties'] = $allProperties;
                $productss[$key]['hasProperties'] = $hasProperties;

                $ProductInd = ProductToppings::where(['product_id' => $p->id])->get();
                $allIngredients = [];
                if (count($ProductInd) > 0){
                    foreach($ProductInd as $Idnkey => $Idn){
                        $IndItemsDetails = IndItem::where(['id' => $Idn->ingredients_id, 'status' => 1])->first();
                        $allIngredients[$Idnkey]['ing_id'] = $Idn->ingredients_id;
                        $allIngredients[$Idnkey]['ing_name'] = $IndItemsDetails->name;
                        $allIngredients[$Idnkey]['ing_price'] = $Idn->ingredents_price;
                        $IndGroupsDetails = IndGrp::where(['id' => $IndItemsDetails->ind_grp_id, 'status' => 1])->first();
                        $allIngredients[$Idnkey]['ing_group'] = $IndGroupsDetails->name;
                    }
                    $hasIngredents = true;
                }else{
                    $allIngredients = [];
                    $hasIngredents = false;
                }
                $productss[$key]['allIngreients'] = $allIngredients;
                $productss[$key]['hasIngrients'] = $hasIngredents;
            }
            return response()->json(['status' => true , 'products' => $productss  ]);
        }else{
            return response()->json(['status' => false , 'msg' => 'No data found']);
        }
    }




}
