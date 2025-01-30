<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\IndItem;
use App\Models\WebOrder;
use App\Models\WebOrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function orderList()
    {
        return view('deliveryboy.order.orderlist');
    }

    public function orderListPending()
    {
        // $groups = null;        
        $branch_id =  Auth::guard('admin')->user()->branch_id;
        $deliveryGuys = Delivery::where('branch_id', $branch_id)->get();
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
            // ->where('delivery_id', Auth::guard('deliveryboy')->user()->id)->where('deliveries.status', '1')
            ->where('web_orders.branch_id', $branch_id)->where('deliveries.status', '1')
            ->where('web_orders.status', 'COOKING')->orWhere('web_orders.status', 'DISPATCHED')->get();
        // dd($groups);
        return view('deliveryboy.order.order_pending', compact('deliveryGuys', 'groups'));
    }

    public function orderListajaxPending(Request $request, $id)
    {
        $deliveryGuy = Delivery::findOrFail($id);
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
            'user_addresses.cross_street'
        )
            ->leftJoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftJoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftJoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->where('web_orders.delivery_id', $deliveryGuy->id)
            ->where('deliveries.status', '1')
            ->where(function ($query) {
                $query->where('web_orders.status', 'COOKING')
                    ->orWhere('web_orders.status', 'DISPATCHED');
            })
            ->get();

        return response()->json(['orders' => $groups]);
    }

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
        return view('deliveryboy.order.product_details', compact('data', 'dtype'));
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
    public function orderListDelivered()
    {
        $branch_id =  Auth::guard('admin')->user()->branch_id;
        $deliveryGuys = Delivery::where('branch_id', $branch_id)->get();
        return view('deliveryboy.order.order_delivered', compact('deliveryGuys'));
    }

    public function orderListajaxDelivered(Request $request, $id)
    {
        $search = $request->input('search.value', '');
        $limit = $request->input('length', 10);
        $offset = $request->input('start', 0);


        // $deliveryGuy = WebOrder::where('delivery_id',$id)->where('web_orders.status', 'COMPLETED')->whereDate('web_orders.delivery_time', now()->toDateString())->get();
        // dd($deliveryGuy);
        // Default ordering
        $orderType = 'asc';
        $nameOrder = 'web_orders.created_at';

        // Check if ordering is set in the request
        if ($request->has('order') && isset($request->order[0]['dir']) && isset($request->columns[$request->order[0]['column']]['name'])) {
            $orderType = $request->order[0]['dir'];
            $nameOrder = $request->columns[$request->order[0]['column']]['name'];
        }

        $query = WebOrder::select(
            "web_orders.*",
            'deliveries.name as delivery_guy_name',
            'users.name as uname',
            'users.phone as user_phone',
            'user_addresses.city',
            'user_addresses.state',
            'user_addresses.house',
            'user_addresses.street',
            'user_addresses.apartment',
            'user_addresses.cross_street'
        )
            ->leftJoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftJoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftJoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->where('web_orders.delivery_id', $id)
            ->where('deliveries.status', '1')
            ->where('web_orders.status', 'COMPLETED')
            ->whereDate('web_orders.delivery_time', now()->toDateString());

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->orWhere('txn_id', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->orWhere('user_addresses.city', 'like', '%' . $search . '%');
            });
        }

        $total = $query->count();
        $orders = $query->orderBy($nameOrder, $orderType)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $data = [];
        foreach ($orders as $order) {
            $status = '<button class="btn btn-sm btn-success">Delivered</button>';
            $data[] = [
                date('d-m-Y', strtotime($order->delivery_time)),
                $order->uname,
                $order->house . ', ' . $order->street . ', ' . $order->apartment . ', ' . $order->city . ', ' . $order->state,
                $order->user_phone,
                $status,
                $order->id
            ];
        }

        $records = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ];

        return response()->json($records);
    }
}
