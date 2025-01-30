<?php

namespace App\Http\Controllers\deliveryboy;

use DateTime;
use Carbon\Carbon;
use App\Models\IndItem;
use App\Models\Branches;
use App\Models\Delivery;
use App\Models\WebOrder;
use App\Models\ComboProduct;
use Illuminate\Http\Request;
use App\Models\WebOrderProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderListController extends Controller
{
    public function orderList()
    {
        return view('deliveryboy.order.orderlist');
    }

    // public function getOrderListPending($id){

    //     $orders = WebOrder::where('delivery_id', $id)->where('status','READY')->get();

    //     if($orders){
    //         return response()->json(array('status' => true, 'orders' => $orders, 'msg' => "Available Deliveries !"));
    //         exit;
    //     }else{
    //         return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
    //         exit;
    //     }
    // }

    public function orderListajax(Request $request)
    {

        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

        $total = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'deliveries.status as delivery_status',
            'users.name as uname',
            'users.phone as user_phone',
            'user_addresses.city',
            'user_addresses.state',
            'user_addresses.house',
            'user_addresses.street',
            'user_addresses.apartment',
            'user_addresses.cross_street',
        )
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');
            })->where('delivery_id', Auth::guard('deliveryboy')->user()->id)->where('deliveries.status', '1')->where('web_orders.status', 'COMPLETED')->count();

        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'deliveries.status as delivery_status',
            'users.name as uname',
            'users.phone as user_phone',
            'user_addresses.city',
            'user_addresses.state',
            'user_addresses.house',
            'user_addresses.street',
            'user_addresses.apartment',
            'user_addresses.cross_street',
        )
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')

            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->where('delivery_id', Auth::guard('deliveryboy')->user()->id)->where('deliveries.status', '1')->where('web_orders.status', 'COMPLETED')->get();
        $i = 1 + $ofset;

        // dd(Auth::guard('deliveryboy')->user()->id);exit;
        $data = [];

        foreach ($groups as $cate) {

            $status = '';
            // $payment_status = '';
            if ($cate->status == "DISPATCHED") {
                $status = '<button class="statusdeliver btn btn-sm btn-warning " data-status="' . "COMPLETED" . '" data-id="' . $cate->id . '">' . "Deliver" . '  </button>';
            } elseif ($cate->status == "COOKING") {
                $status = '<button class="btn btn-sm btn-info">' . "Pickup the food" . '</button>';
            } else if ($cate->status == "COMPLETED") {
                $status = '<button class="btn btn-sm btn-success" style="filter: brightness(80%);">' . "Delivered" . ' <i class="fa fa-check"></i> </button>';
            }
            if ($cate->status == "CANCELLED") {
                $status = '<button class="btn btn-sm btn-danger" style="filter: brightness(80%);">' . "Cancelled" . ' <i class="fa fa-check"></i> </button>';
            }

            // if( $cate->payment_status == "PENDING")
            // {
            //     $payment_status = '<button class="statuspaid btn btn-sm btn-warning " data-payment_status="' . "PAID" . '" data-id="' . $cate->id . '">' . "Pending" . '  </button>';
            // }
            // else
            // {
            //     $payment_status = '<button class="btn btn-sm btn-success" style="filter: brightness(80%);">' . "Paid" . ' <i class="fa fa-check"></i> </button>';
            // }

            $data[] = array(

                date('d-m-Y', strtotime($cate->created_at)),
                $cate->uname,
                $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
                $cate->user_phone,
                $cate->payment_mode,
                //    $payment_status,
                $status,
                '<div class=""><a href="' . url("deliveryboy/view-product-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> View </a></div>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    // Pending Order List

    public function orderListPending()
    {
        // $groups = null;        
        // $branch_id = auth()->guard('admin')
        $deliveryGuys = Delivery::all();
        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'deliveries.status as delivery_status',
            'users.name as uname',
            'users.phone as user_phone',
            'user_addresses.city',
            'user_addresses.state',
            'user_addresses.house',
            'user_addresses.street',
            'user_addresses.apartment',
            'user_addresses.cross_street',
        )
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->where('delivery_id', Auth::guard('deliveryboy')->user()->id)->where('deliveries.status', '1')
            ->where('web_orders.status', 'COOKING')->orWhere('web_orders.status', 'DISPATCHED')->get();
            // dd($groups);
        return view('deliveryboy.order.order_pending', compact('deliveryGuys','groups'));
    }

    public function orderListajaxPending(Request $request, $id)
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
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];


        $total = WebOrder::select("web_orders.*" , 'deliveries.name', 'deliveries.status as delivery_status', 'users.name as uname', 'users.phone as user_phone',
        'user_addresses.city','user_addresses.state',
        'user_addresses.house','user_addresses.street','user_addresses.apartment' , 'user_addresses.cross_street',)
        ->leftjoin('deliveries' , 'web_orders.delivery_id' , '=' , 'deliveries.id')
        ->leftjoin('users' , 'web_orders.user_id' , '=' , 'users.id')
        ->leftjoin('user_addresses', 'web_orders.shipping_address' , '=' , 'user_addresses.id')
        ->orWhere(function($query) use ($search){
            $query->orWhere('txn_id' , 'like' , '%'. $search.'%');
        })->where('delivery_id', $id )->where('deliveries.status', '1')->where('web_orders.status', 'COOKING')->orWhere('web_orders.status', 'DISPATCHED')->count();

        $groups = WebOrder::select("web_orders.*" , 'deliveries.name', 'deliveries.status as delivery_status', 'users.name as uname', 'users.phone as user_phone',
        'user_addresses.city','user_addresses.state',
        'user_addresses.house','user_addresses.street','user_addresses.apartment' , 'user_addresses.cross_street',)
        ->leftjoin('deliveries' , 'web_orders.delivery_id' , '=' , 'deliveries.id')
        ->leftjoin('users' , 'web_orders.user_id' , '=' , 'users.id')
        ->leftjoin('user_addresses', 'web_orders.shipping_address' , '=' , 'user_addresses.id')

        ->orWhere(function($query) use ($search){
            $query->orWhere('txn_id' , 'like' , '%'. $search.'%');

        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->where('delivery_id', $id )->where('deliveries.status', '1')->where('web_orders.status', 'COOKING')->orWhere('web_orders.status', 'DISPATCHED')->get();
        $i = 1 + $ofset;

        // dd($groups);exit;
        $data = [];

        foreach ($groups as $cate) {

            $status = '';
             if( $cate->status == "COOKING" || $cate->status == "DISPATCHED")
            {
                $status = '<button class="statusdeliver btn btn-sm btn-warning " data-status="' . "COMPLETED" . '" data-id="' . $cate->id . '">' . "Deliver" . '  </button>';
            }
            if($cate->status == "COOKING")
            {
                $status = '<button class="btn btn-sm btn-info">' . "Pickup the food" . '</button>';
            }

            $data[] = array(

                date('d-m-Y' , strtotime($cate->created_at)),
                   $cate->uname,
                   $cate->house.', '.$cate->street.', '.$cate->apartment.', '.$cate->city.', '.$cate->state,
                   $cate->user_phone,
                   $status,
                   '<div class=""><a href="' . url("deliveryboy/view-product-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> View </a></div>',
                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    // Delivered Order List

    public function orderListDelivered()
    {
        return view('deliveryboy.order.order_delivered');
    }

    public function orderListajaxDelivered(Request $request)
    {
        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];


        $total = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'deliveries.status as delivery_status',
            'users.name as uname',
            'users.phone as user_phone',
            'user_addresses.city',
            'user_addresses.state',
            'user_addresses.house',
            'user_addresses.street',
            'user_addresses.apartment',
            'user_addresses.cross_street',
        )
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');
            })->where('delivery_id', Auth::guard('deliveryboy')->user()->id)->where('deliveries.status', '1')
            ->where('web_orders.status', 'COMPLETED')->whereDay('web_orders.created_at', now()->day)->count();

        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'deliveries.status as delivery_status',
            'users.name as uname',
            'users.phone as user_phone',
            'user_addresses.city',
            'user_addresses.state',
            'user_addresses.house',
            'user_addresses.street',
            'user_addresses.apartment',
            'user_addresses.cross_street',
        )
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')

            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->where('delivery_id', Auth::guard('deliveryboy')->user()->id)->where('deliveries.status', '1')
            ->where('web_orders.status', 'COMPLETED')->whereDay('web_orders.created_at', now()->day)->get();
        $i = 1 + $ofset;

        // dd($groups);exit;
        $data = [];

        foreach ($groups as $cate) {

            $status = '';

            if ($cate->status == "COMPLETED") {
                $status = '<button class="btn btn-sm btn-success">' . "Delivered" . '</button>';
            }

            $data[] = array(

                date('d-m-Y', strtotime($cate->created_at)),
                $cate->uname,
                $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
                $cate->user_phone,
                $status,
                '<div class=""><a href="' . url("deliveryboy/view-product-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> View </a></div>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function updateOrderStatusApprove(Request $request)
    {
        $currentDateTime = Carbon::now();
        $order = WebOrder::findOrFail($request->id);
        $order->status = $request->status;
        $order->delivery_time = $currentDateTime;
        $update = $order->update();
        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    // public function updateOrderStatusDispatch(Request $request)
    // {
    //     $order = WebOrder::findOrFail($request->id);
    //     $order->status = $request->status;
    //     $update = $order->update();
    //     if($update)
    //     {
    //         return response()->json(array('status' => true,'msg' => "Successfully Updated !"));
    //         exit;
    //     }
    //     else
    //     {
    //         return response()->json(array('status' => false,'msg' => "Error Occured, please try again"));
    //         exit;
    //     }
    // }

    public function viewProductDetails($id)
    {

        $d = WebOrderProduct::where('order_id', $id)->get();
        // $order_id = $id;
        $ind_ids = [];
        foreach ($d as $dd) {
            if ($dd->toppings) {
                $ind_details = IndItem::whereIn('id', json_decode($dd->toppings))->get();
                foreach ($ind_details as $dt) {
                    $ind_ids[] = $dt->id;
                }
            }
        }

        $data = WebOrderProduct::select(
            "web_order_products.*",
            'products.product_name',
            'products.qty',
            'products.product_des',
            'products.price',
            'products.type as product_type',
            'products.size',
            'combopacks.package_name',
            'combopacks.image',
            'web_order_products.qty as pro_qty',
            // 'admins.fname as admin_fname',
            // 'admins.lname as admin_lname'
        )
            ->leftjoin('products', 'web_order_products.product_id', '=', 'products.id')
            ->leftjoin('combopacks', 'web_order_products.combo_pack_id', '=', 'combopacks.id')
            // ->leftjoin('admins', 'web_order_products.user_id', '=', 'admins.id')
            ->where('web_order_products.order_id', $id)
            ->get();

        $dtype = WebOrder::where('id', $id)->first();
        // dd($dtype);

        return view('deliveryboy.order.product_details', compact('data', 'dtype'));
    }


    public function updateOrderStatusPayment(Request $request)
    {
        // dd($request);
        $order = WebOrder::findOrFail($request->id);
        $order->payment_status = $request->payment_status;
        $update = $order->update();
        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Payment Status Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    public function DeliveryBoyQueue()
    {
        $deliveryBoy = Auth::guard('deliveryboy')->user();
        $branch_id = $deliveryBoy->branch_id;
        $branch_id = $deliveryBoy->branch_id;

        $deliveryBoys = Delivery::select('deliveries.*', 'last_completed.last_completed_delivery')
            ->leftJoin(
                DB::raw('(
                SELECT delivery_id, MAX(updated_at) as last_completed_delivery
                FROM web_orders
                WHERE status = "COMPLETED"
                GROUP BY delivery_id
            ) as last_completed'),
                'deliveries.id',
                '=',
                'last_completed.delivery_id'
            )
            ->where('branch_id', $branch_id)
            ->orderBy(DB::raw('COALESCE(last_completed_delivery, "1970-01-01 00:00:00")'), 'asc')
            ->get();
        return view('deliveryboy.order.deliveryBoy_queue', compact('deliveryBoys'));
    }
}
