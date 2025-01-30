<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomeDeliveryAddress;
use App\Models\IndItem;
use App\Models\ProductProperty;
use App\Models\Products;
use App\Models\ProductToppings;
use App\Models\ProductVarients;
use App\Models\PropertiesItems;
use App\Models\SubCategory;
use App\Models\UserCart;
use App\Models\User;
use App\Models\WebOrder;
use App\Models\WebOrderProduct;
use App\Models\ProductExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\ResponseFactory;
use App\Models\AddtoExtra;
use App\Models\Combopack;
use App\Models\ComboProduct;
use App\Models\Coupons;
use App\Models\UserAddress;

use function Ramsey\Uuid\v1;

class Pos_C extends Controller
{
    /**
     * @return view pos detail
     */
    public function index()
    {

        $category = Category::get();
        $ship = UserAddress::where('user_id',Auth::guard('web')->user()->id)->get();
        $extra = ProductExtra::get();

        return view('website.pos_detail' , compact('category','ship','extra'));
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
        $checkProductExixt = UserCart::where(['product_id' => $request->id , 'user_id' => Auth::user()->id])->count();

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
        $data = ProductVarients::select('product_variants.*','variations.name')->where(['product_id' => $request->id])->join('variations','variations.id','=','product_variants.varients_id')->get();
        $html = '<form class="new_add_to_cart" method="POST">
                    <div class="col-md-12">
                        <div class="funkyradio row">';
        foreach($data as $key => $var){
            $html .= '<div class="col">
                        <div class="funkyradio-success">
                            <input type="radio" name="radio" id="radio'.$key.'" value="'.$var->varients_id.'" />
                            <label for="radio'.$key.'">'.$var->name.' - $'.$var->varients_price.'</label>
                        </div>
                    </div>';
        }

        $html .= '</div>
                    </div>';
        $ProductProperty = ProductProperty::where(['product_id' => $request->id])->get();
        if (count($ProductProperty) > 0){
            $property_ids = [];
            foreach($ProductProperty as $pp){
                $property_ids[] = $pp->properties_id;
            }
            $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;margin-top: 4%">Properties</h6>';
            $ProductPropertyItems = PropertiesItems::whereIn('properties_id', $property_ids)->get();
            foreach($ProductPropertyItems as $ppi){
                $html .= '<div class="card mb-3 main-cart pb-3 mt-0">
                        <div class="row align-items-center">
                        <div class="col-md-5">
                        <div class="card-body">
                        <h5 class="card-title  fw-bold"> '.$ppi->name.'</h5>
                        <p class="mb-0">$'.$ppi->price.'</p>
                        </div>
                        </div>
                        <div class="col-md-5">';
                if ($ppi->is_multiple == 1){
                    $html .= '<div class="qty-block">
                        <div class="qty">
                        <input type="text" name="qty" maxlength="12" value="12" title="" class="input-text" />
                        <div class="qty_inc_dec">
                        <i style="float: left;text-align: center;width: 30px;cursor: pointer;font-size: 1.2em;line-height: 20px;height: 25px;vertical-align: middle;background-color: #fff;border: 1px solid #ccc;" data-id="48" data-qty="1">+</i>
                        <i style="float: left;text-align: center;width: 30px;cursor: pointer;font-size: 1.2em;line-height: 20px;height: 25px;vertical-align: middle;background-color: #fff;border: 1px solid #ccc;" data-id="48" data-qty="1">-</i>
                        </div>
                        </div>
                        </div>';
                }
                $html .='</div>
                        <div class="col-md-2 text-center">
                            <button type="button" class="btn btn-success btn-sm">Add</button>
                        </div>
                        </div>
                        </div>';
            }

            $html.= '</div>';
        }

        $ProductToppings = ProductToppings::where(['product_id' => $request->id])->get();
        if (count($ProductToppings) > 0){
            $product_toppings_ids = [];
            foreach($ProductToppings as $ppI){
                $product_toppings_ids[] = $ppI->ingredients_id;
            }
            $html .= '<div class="col-md-12">
                    <h6 style="color: #fe4e2b;margin-top: 4%">Add Toppings</h6>
                    <div class="owl-carousel owl-theme">';
            $ProductToppingsItems = IndItem::whereIn('id', $product_toppings_ids)->get();
            foreach($ProductToppingsItems as $pti){
                $ProductToppingsPrice = ProductToppings::where(['ingredients_id' => $pti->id])->first();
                $html .=    '<div class="item">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>'.$pti->name.'</h4>
                                    <h6>'.$ProductToppingsPrice->ingredents_price.'</h6>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-success btn-sm" type="button">Add</button>
                                </div>
                            </div>
                        </div>';
            }
            $html .='</div>
                </div>';
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
