<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Combopack;
use App\Models\ComboProduct;
use App\Models\Coupons;
use App\Models\HomeDeliveryAddress;
use App\Models\ProductExtra;
use App\Models\Products;
use App\Models\SubCategory;
use App\Models\UserAddress;
use App\Models\userCart;
use App\Models\WebOrder;
use App\Models\WebOrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PosController extends Controller
{
    //
    public function index()
    {
        $category = Category::get();
        $extra = ProductExtra::get();
        return view('admin.pos.index' , compact('category', 'extra'));
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
        return response()->json(['status' => true , 'products' => $products , "limit" => $limit , "total" => $total ]);
    }

    /**
     * @param Request $request
     * @method use for add to cart 
     */
    public function add_to_cart(Request $request)
    {
        
        $product = Products::findOrFail($request->id);
        $checkProductExixt = userCart::where(['product_id' => $request->id , 'user_id' => Auth::user()->id])->count();
       
        if($checkProductExixt == 0) 
        {
            $data                   = new UserCart();
            $input['product_id']    = $product->id;
            $input['user_id']       = Auth::user()->id;
            $input['qty']           = 1;
            $input['price']         = $product->price;
            $input['tax']           = $product->tax;
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
        else
        {
            return response()->json(['status' => false , 'msg' => "Already exists !!"]);
            exit; 
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
        $products = UserCart::select("user_carts.*" , "products.product_img" , "products.product_name" , 
        "offers.discount" , "combopacks.package_name"  , "combopacks.image")
        ->leftjoin("products" , "user_carts.product_id" , "=" , "products.id")
        ->leftjoin("combopacks" , "user_carts.combo_id" , "=" , "combopacks.id")
        ->leftjoin("offers" , "user_carts.product_id" , "=" , "offers.product_id")
        ->where(['user_id' => Auth::user()->id])->get();
        return response()->json(['products' => $products]);
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
            if($request->address == "undefined") {
                return response()->json(['status' => false , 'msg' => "Shipping address required!!"]);
                 exit; 
            }
           

            $shipping_address = UserAddress::where(['user_id' => Auth::user()->id])->first();
            // $extra = ProductExtra::where(['id' => Auth::user()->id])->first();

            if($shipping_address) {
                $checkCard = UserCart::where(['user_id' => Auth::user()->id])->get();
                if($checkCard)
                {
                    $order                      = new WebOrder();
                    $input['user_id']           = Auth::user()->id;
                    $input['payment_mode']      = $request->type;
                    $input['pay_amount']        = $request->total;    
                    $input['invoice_id']        = uniqid(time()) . "" . rand(0, 50);
                    $input['txn_id']            = uniqid(time());
                    $input['shipping_address']  = $request->address;
                    $orderSave = $order->fill($input)->save();

                    if($orderSave) 
                    {
                        foreach($checkCard as $item) {
                            $orderProduct           = new WebOrderProduct();
                            $input1['user_id']      = Auth::user()->id;
                            $input1['product_id']   = $item->product_id;
                            $input1['qty']          = $item->qty;
                            $input1['base_price']   = $item->price;
                            $input1['order_id']     = $order->id;
                            $input1['combo_pack_id']= $item->combo_id;
                            $input1['type']         = $item->type;
                            $input1['extra']        = $item->extra;
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
            else
            {
                return response()->json(['status' => false , 'msg' => "Add shipping address"]);
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
            $data[] = array(
                    date('d-m-Y' , strtotime($order->created_at)),
                    $order->phone,
                    $order->name,
                    $order->city . ' ' . $order->state . ' ' . $order->house . ' ' . $order->street . ' ' . $order->apartment . ' ' . $order->cross_street , 
                    $order->txn_id,
                    $order->invoice_id,
                    $order->payment_mode,
                    $order->pay_amount,
                    ($order->status == "COPMLETED" ? '<button class="btn btn-sm btn-success">'.$order->status.'</button>' : ($order->status == "PENDING" ? '<button class="btn btn-sm btn-warning">'.$order->status.'</button>' : ($order->status == "CANCELLED" ? '<button class="btn btn-sm btn-danger">'.$order->status.'</button>' : ''))),
                    '<a href="javascript:void(0)" class="btn btn-warning btn-sm order_detail" data-id="'.$order->id.'"> Order Details </a>'
                   
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
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

    /**
     * @method use for add extra into add to cart
     */
    public function extra_add_to_cart(Request $request)
    {
        $product = Products::findOrFail($request->product_id);
        $checkProductExixt = UserCart::where(['product_id' => $request->product_id , 'user_id' => Auth::user()->id])->count();
       
        if($checkProductExixt == 0) 
        {
            if($request->Spicy) {
                $extra['Spicy'] = $request->Spicy;
            }
            if($request->Chees) {
                $extra['Chees'] = $request->Chees;
            }
            if($request->Saas) {
                $extra['Saas'] = $request->Saas;
            }
            $data                   = new UserCart();
            $input['product_id']    = $product->id;
            $input['user_id']       = Auth::user()->id;
            $input['qty']           = 1;
            $input['price']         = $product->price;
            $input['tax']           = $product->tax;
            $input['extra']         = json_encode($extra);
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
        else
        {
            return response()->json(['status' => false , 'msg' => "Already exists !!"]);
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
            
            $data[] = array(
                    '<img src="'.url($img).'" class="rounded" style="height: 30px; width: 30px;"><br><b>'.$new_name .'</b>',
                    $order->base_price,
                    $order->size,
                    $order->qty,
                    ($order->type == "combo" ? $order->type .'&nbsp;<a href="javascrit:void(0)" class="btn btn-success show_detail" data-id="'.$order->combo_pack_id.'"><i class="fa fa-eye"></i></a>' : $order->product_type),
                    $order->extra,
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
}
