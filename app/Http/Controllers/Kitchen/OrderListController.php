<?php

namespace App\Http\Controllers\Kitchen;

use PDF;
use DateTime;
use App\Models\Chef;
use App\Models\IndGrp;
use App\Models\IndItem;
use App\Models\Branches;
use App\Models\Delivery;
use App\Models\WebOrder;
use App\Models\ComboProduct;
use Illuminate\Http\Request;
use App\Models\ProductToppings;
use App\Models\ProductVarients;
use App\Models\PropertiesItems;
use App\Models\WebOrderProduct;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OrderListController extends Controller
{
    public function orderList()
    {
        $chefs = Chef::all();
        return view('kitchen.order.orderlist', compact('chefs'));
    }

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
            'users.name as uname',
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
            })->count();

        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
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
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;

        // dd($groups);exit;
        $data = [];

        foreach ($groups as $cate) {

            $startCooking = \Carbon\Carbon::parse($cate->cookingstart);
            $endCooking = \Carbon\Carbon::parse($cate->endcooking);
            $timeDifference = $startCooking->diff($endCooking)->format('%HH:%IM:%SS:');

            $endkuking = \Carbon\Carbon::parse($cate->endcooking);
            $dltime = \Carbon\Carbon::parse($cate->delivery_time);
            $td = $endkuking->diff($dltime)->format('%HH:%IM:%SS:');




            $status = '';
            if ($cate->status == "PENDING") {
                $status = '<badge class="badge badge-sm badge-primary w-100" >' . "Pending" . '  </badge>';
            } else if ($cate->status == "COOKING") {
                $status = '<badge class="badge badge-sm badge-secondary w-100 ">' . "Cooking" . '  </badge>';
            } else if ($cate->status == "READY") {
                $status = '<badge class="badge badge-sm badge-warning w-100 ">' . "Cooking Complete, Ready For HandOver" . '  </badge>';
            } else if ($cate->status == "DISPATCHED") {
                $status = '<badge class="badge badge-sm badge-info w-100  ">' . "On The Way" . '</badge>';
            } else if ($cate->status == "COMPLETED") {
                $status = '<badge class="badge badge-sm badge-success w-100 ">' . "Delivered" . '</badge>';
            }
            if ($cate->status == "CANCELLED") {
                $status = '<button class="badge badge-sm badge-danger w-100 " style="filter: brightness(80%);">' . "Cancelled" . '</button>';
            }

            $data[] = array(

                date('d-m-Y', strtotime($cate->created_at)),
                $cate->uname,

                // $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
                $cate->pay_amount,
                $cate->status == 'PENDING' ? '--' : ($cate->status == 'COOKING' ? '--' : ($cate->status == 'DISPATCHED' ? $timeDifference : $timeDifference)),
                $cate->status == 'COMPLETED' ? $td : '--',
                $status,
                '<div class=""><a href="' . url("kitchen/order-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> Order Details </a></div>',


            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    // Order Pending List
    public function orderPendingList()
    {
        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
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
            ->where('web_orders.status', 'PENDING')->orWhere('web_orders.status', 'COOKING')->orderBy('web_orders.id', 'DESC')->get();

        $chefs = Chef::get();
        $dboys = Delivery::get();

        return view('kitchen.order.order_pending_list', compact('groups', 'chefs', 'dboys'));
    }
    
    // public function orderPendingListAjax(Request $request)
    // {
    //     if (isset($_GET['search']['value'])) {
    //         $search = $_GET['search']['value'];
    //     } else {
    //         $search = '';
    //     }
    //     if (isset($_GET['length'])) {
    //         $limit = $_GET['length'];
    //     } else {
    //         $limit = 10;
    //     }

    //     if (isset($_GET['start'])) {
    //         $ofset = $_GET['start'];
    //     } else {
    //         $ofset = 0;
    //     }

    //     $orderType = $_GET['order'][0]['dir'];
    //     $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];


    //     $total = WebOrder::select(
    //         "web_orders.*",
    //         'deliveries.name',
    //         'users.name as uname',
    //         'user_addresses.city',
    //         'user_addresses.state',
    //         'user_addresses.house',
    //         'user_addresses.street',
    //         'user_addresses.apartment',
    //         'user_addresses.cross_street',
    //     )
    //         ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
    //         ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
    //         ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
    //         ->orWhere(function ($query) use ($search) {
    //             $query->orWhere('txn_id', 'like', '%' . $search . '%');
    //         })->where('web_orders.status', 'PENDING')->count();

    //     $groups = WebOrder::select(
    //         "web_orders.*",
    //         'deliveries.name',
    //         'users.name as uname',
    //         'user_addresses.city',
    //         'user_addresses.state',
    //         'user_addresses.house',
    //         'user_addresses.street',
    //         'user_addresses.apartment',
    //         'user_addresses.cross_street',
    //     )
    //         ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
    //         ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
    //         ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')

    //         ->orWhere(function ($query) use ($search) {
    //             $query->orWhere('txn_id', 'like', '%' . $search . '%');
    //         })
    //         ->offset($ofset)->limit($limit)
    //         ->orderBy($nameOrder, $orderType)->where('web_orders.status', 'PENDING')->get();
    //     $i = 1 + $ofset;

    //     // dd($groups);exit;
    //     $data = [];

    //     foreach ($groups as $cate) {

    //         $status = '';
    //         if ($cate->status == "PENDING") {
    //             $status = '<button class="btn btn-sm btn-success">' . "Pending" . '</button>';
    //         }

    //         $data[] = array(

    //             date('d-m-Y', strtotime($cate->created_at)),
    //             $cate->uname,

    //             $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
    //             $cate->pay_amount,
    //             $status,
    //             '<div class=""><a href="' . url("kitchen/order-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> Order Details </a></div>',


    //         );
    //     }
    //     $records['recordsTotal'] = $total;
    //     $records['recordsFiltered'] =  $total;
    //     $records['data'] = $data;
    //     echo json_encode($records);
    // }


    // Order Cooking List
    public function orderCookingList()
    {

        $cooking = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
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
            ->where('web_orders.status', 'COOKING')->get();
        $chefs = Chef::get();
        $dboys = Delivery::get();
        return view('kitchen.order.order_cooking_list', compact('cooking', 'chefs', 'dboys'));
    }

    public function orderCookingListAjax(Request $request)
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
            'users.name as uname',
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
            })->where('web_orders.status', 'COOKING')->count();

        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
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
            ->orderBy($nameOrder, $orderType)->where('web_orders.status', 'COOKING')->get();
        $i = 1 + $ofset;

        // dd($groups);exit;
        $data = [];

        foreach ($groups as $cate) {

            $status = '';
            if ($cate->status == "COOKING") {
                $status = '<button class="btn btn-sm btn-success">' . "Cooking" . '</button>';
            }

            $data[] = array(

                date('d-m-Y', strtotime($cate->created_at)),
                $cate->uname,

                $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
                $cate->pay_amount,
                $status,
                '<div class=""><a href="' . url("kitchen/order-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> Order Details </a></div>',


            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    // Order Dispatched List
    public function orderCookedList()
    {
        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
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
            ->where('web_orders.status', 'READY')
            ->where('web_orders.delivery_type', 'Home Delivery')
            ->get();

        $chefs = Chef::get();
        $dboys = Delivery::get();
        return view('kitchen.order.order_cooked_list', compact('groups', 'chefs', 'dboys'));
    }

    // public function orderCookedListAjax(Request $request)
    // {
    //     if (isset($_GET['search']['value'])) {
    //         $search = $_GET['search']['value'];
    //     } else {
    //         $search = '';
    //     }
    //     if (isset($_GET['length'])) {
    //         $limit = $_GET['length'];
    //     } else {
    //         $limit = 10;
    //     }

    //     if (isset($_GET['start'])) {
    //         $ofset = $_GET['start'];
    //     } else {
    //         $ofset = 0;
    //     }

    //     $orderType = $_GET['order'][0]['dir'];
    //     $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];


    //     $total = WebOrder::select(
    //         "web_orders.*",
    //         'deliveries.name',
    //         'users.name as uname',
    //         'user_addresses.city',
    //         'user_addresses.state',
    //         'user_addresses.house',
    //         'user_addresses.street',
    //         'user_addresses.apartment',
    //         'user_addresses.cross_street',
    //     )
    //         ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
    //         ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
    //         ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
    //         ->orWhere(function ($query) use ($search) {
    //             $query->orWhere('txn_id', 'like', '%' . $search . '%');
    //         })->where('web_orders.status', 'DISPATCHED')->count();

    //     $groups = WebOrder::select(
    //         "web_orders.*",
    //         'deliveries.name',
    //         'users.name as uname',
    //         'user_addresses.city',
    //         'user_addresses.state',
    //         'user_addresses.house',
    //         'user_addresses.street',
    //         'user_addresses.apartment',
    //         'user_addresses.cross_street',
    //     )
    //         ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
    //         ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
    //         ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')

    //         ->orWhere(function ($query) use ($search) {
    //             $query->orWhere('txn_id', 'like', '%' . $search . '%');
    //         })
    //         ->offset($ofset)->limit($limit)
    //         ->orderBy($nameOrder, $orderType)->where('web_orders.status', 'DISPATCHED')->get();
    //     $i = 1 + $ofset;

    //     // dd($groups);exit;
    //     $data = [];

    //     foreach ($groups as $cate) {

    //         $status = '';
    //         if ($cate->status == "DISPATCHED") {
    //             $status = '<button class="btn btn-sm btn-success">' . "On The Way" . '</i></button>';
    //         }

    //         $data[] = array(

    //             date('d-m-Y', strtotime($cate->created_at)),
    //             $cate->uname,

    //             $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
    //             $cate->pay_amount,
    //             $status,
    //             '<div class=""><a href="' . url("kitchen/order-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> Order Details </a></div>',


    //         );
    //     }
    //     $records['recordsTotal'] = $total;
    //     $records['recordsFiltered'] =  $total;
    //     $records['data'] = $data;
    //     echo json_encode($records);
    // }


    // Order Delivered List
    public function orderDeliveredList()
    {
        return view('kitchen.order.order_deliver_list');
    }

    public function orDerdeliveredListAjax(Request $request)
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
            'users.name as uname',
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
            })->where('web_orders.status', 'COMPLETED')->count();

        $groups = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
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
            ->orderBy($nameOrder, $orderType)->where('web_orders.status', 'COMPLETED')->get();
        $i = 1 + $ofset;

        // dd($groups);exit;
        $data = [];

        foreach ($groups as $cate) {

            $status = '';
            if ($cate->status == "COMPLETED") {
                $status = '<button class="btn btn-sm btn-success">' . "Delivered" . '</i></button>';
            }

            $data[] = array(

                date('d-m-Y', strtotime($cate->created_at)),
                $cate->uname,

                $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
                $cate->pay_amount,
                $status,
                '<div class=""><a href="' . url("kitchen/order-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> Order Details </a></div>',


            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    public function orderDetails($id)
    {
        $d = WebOrderProduct::where('order_id', $id)->get();
        $order_id = $id;
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
        )
            ->leftjoin('products', 'web_order_products.product_id', '=', 'products.id')
            ->leftjoin('combopacks', 'web_order_products.combo_pack_id', '=', 'combopacks.id')
            ->where('web_order_products.order_id', $id)
            ->get();




        $comboes = WebOrderProduct::where('order_id', $id)->get();
        $productId = [];
        $comboid = [];


        foreach ($comboes as $keyf => $pid) {
            $productId = $pid;

            $comboProducts = ComboProduct::select('combo_products.*', 'products.product_name', 'products.product_des')
                ->leftJoin('products', 'combo_products.product_id', '=', 'products.id')
                ->where('combo_products.pack_id', $productId->combo_pack_id)
                ->get();


            foreach ($comboProducts as $key => $comboProduct) {
                $comboid[$keyf][$key]['product_name'] = $comboProduct->product_name;
                $comboid[$keyf][$key]['product_des'] = $comboProduct->product_des;
            }
        }



        $comboid = array_filter($comboid);
        $product_name = [];
        $product_des = [];


        $combo = [];
        foreach ($comboid as $c) {
            $combo = $c;
        }

        // $top_prices = null;
        // foreach ($data as $top_price) {
        //     $top_prices = $top_price->product_id;
        // }

        // $vat_prices = null;
        // foreach ($data as $top_price) {
        //     $vat_prices = $top_price->product_id;
        // }


        $status = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
            'users.phone as uphone',
            'users.email as uemail',
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
            ->where('web_orders.id', $id)->first();

        $order = WebOrder::findOrFail($id);

        $delivery = Delivery::select('deliveries.id', 'deliveries.name')->where('status', '1')->get();

        $AssignedDelivery = null;
        if ($order->status == "READY") {
            $AssignedDelivery = Delivery::findOrFail($order->delivery_id);
        }
        $dtype = WebOrder::where('delivery_type', 'Take Away')->where('id', $id)->pluck('shipping_address')->first();
        $branchss = Branches::where('id', $dtype)->first();
        $chefs = Chef::all();
        // dd($branchss);

        return view('kitchen.order.orderdetails', compact('AssignedDelivery', 'data', 'status', 'delivery', 'order_id', 'branchss', 'combo', 'chefs'));
    }




    public function orderDetailsUpdate(Request $request)
    {
        // print_r(Auth::guard('admin')->user()->id);
        // exit;
        $where = array('id' => $request->id);
        $data = array(
            'kitchen_status' => $request->status,
        );

        // $update = WebOrderProduct::where(["id" => $request->id])->update(["kitchen_status" => $request->status]);
        $data = WebOrderProduct::findOrFail($request->id);
        $data->kitchen_status = $request->status;
        if ($request->status == "ONGOING") {
            $data->start_time = new DateTime();
        }
        if ($request->status == "COMPLETED") {
            $data->end_time = new DateTime();
        }
        $data->kitchen_id = Auth::guard('admin')->user()->id;


        $update = $data->update();
        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    public function updateOrderStatusApprove(Request $request)
    {
        $order = WebOrder::findOrFail($request->id);
        if (!$order->delivery_id) {
            return response()->json(array('status' => false, 'msg' => "Please Assign Delivery Guy"));
            exit;
        }
        $order->status = $request->status;
        $update = $order->update();
        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    public function updateOrderStatusDispatch(Request $request)
    {
        $all_items = WebOrderProduct::where('order_id', $request->id)->whereNull('chef_id')->get();
        if (count($all_items) == 0) {
            $currentDateTime = Carbon::now();
            $order = WebOrder::findOrFail($request->id);
            $order->status = $request->status;
            $order->endcooking = $currentDateTime;

            // print_r(WebOrder::findOrFail(66));exit;
            $id =  $request->id;
            if (WebOrder::where('id', $id)->exists()) {
                $id = $request->id + 1;
            } else {
                $id = $request->id - 1;
            }

            $update = $order->update();
            if ($update) {
                return response()->json(array('status' => true, 'id' => $id, 'msg' => "Successfully Updated !"));
                exit;
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
                exit;
            }
        } else {
            return response()->json(array('status' => false, 'msg' => "Please assign a Chef for all the Items before making it Ready for Handover"));
            exit;
        }
    }

    public function updateOrderStatusTakeaway(Request $request)
    {
        dd($request->all());
        $order = WebOrder::findOrFail($request->id);
        $order->status = $request->status;
        $update = $order->update();
        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }


    // Order Details Invoice
    public function orderDetailsInvoice($id)
    {
        $order_id = $id;
        $data = WebOrderProduct::select(
            "web_order_products.*",
            'products.product_name',
            'products.qty',
            'products.price',
            'products.type as product_type',
            'products.size',
            'combopacks.package_name',
            'combopacks.image',
            'web_order_products.qty as pro_qty',
        )
            ->leftjoin('products', 'web_order_products.product_id', '=', 'products.id')
            ->leftjoin('combopacks', 'web_order_products.combo_pack_id', '=', 'combopacks.id')
            ->where('web_order_products.order_id', $id)->get();


        $status = WebOrder::select(
            "web_orders.*",
            'deliveries.name',
            'users.name as uname',
            'users.phone as uphone',
            'users.email as uemail',
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
            ->where('web_orders.id', $id)->first();
        //   $body = [
        //     'data'=> $data,
        //     'status'=> $status
        //    ];

        //   $pdf = PDF::loadView('kitchen.order.order_details_print', $body);
        //   return $pdf->download('xyzfood.pdf');

        $dtype = WebOrder::where('delivery_type', 'Take Away')->where('id', $id)->pluck('shipping_address')->first();
        $branchss = Branches::where('id', $dtype)->first();

        return view('kitchen.order.order_details_print', compact('status', 'data', 'order_id', 'branchss'));
    }

    public function getDeliveryGuyDetail($id)
    {
        $deliveryGuy = Delivery::findOrFail($id);
        if ($deliveryGuy) {
            return response()->json(['status' => true, 'data' => $deliveryGuy]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error Getting Delivery Guy Detail"]);
            exit;
        }
    }

    public function checkDeliveryCount($id)
    {
        $pendingDeliveriesCount = WebOrder::where('delivery_id', $id)
            ->where('status', '!=', 'COMPLETED')
            ->count();

        return response()->json(['success' => true, 'count' => $pendingDeliveriesCount]);
    }

    public function countOrdersByDeliveryGuys()
    {
        $branch_id = Auth::guard('admin')->user()->branch_id;

        // Query to get delivery guys and their pending orders count
        $deliveryGuys = Delivery::select('id', 'name')
            ->where('branch_id', $branch_id)
            ->withCount(['web_orders as orders_count' => function ($query) {
                $query->where('status', '!=', 'COMPLETED');
            }])
            ->orderBy('orders_count') // Sort by orders_count in descending order
            ->get();

        return response()->json(['success' => true, 'deliveryGuys' => $deliveryGuys]);
    }

    // Store Delivery Boy
    public function orderStoreDeliveryboy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_id' => 'required|exists:deliveries,id',
            'delivery_order_id'    => 'required|exists:web_orders,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        }

        $order = WebOrder::findOrFail($request->id);
        if ($order->status != "COOKING") {
            return response()->json(array('status' => false, 'msg' => "Please assign a Chef for all the Items before making it Ready for Handover"));
            exit;
        }

        $all_items = WebOrderProduct::where('order_id', $request->id)->whereNull('chef_id')->get();
        if (count($all_items) == 0) {
            $currentDateTime = Carbon::now();
            $order = WebOrder::findOrFail($request->id);
            $order->status = $request->status;
            $order->endcooking = $currentDateTime;

            // print_r(WebOrder::findOrFail(66));exit;
            $id =  $request->id;
            if (WebOrder::where('id', $id)->exists()) {
                $id = $request->id + 1;
            } else {
                $id = $request->id - 1;
            }
            $update = $order->update();
            if (!$update) {
                return response()->json(['status' => false, 'msg' => "Error Occured, please try again"]);
                exit;
            }
        }
        $data = WebOrder::findOrFail($request->delivery_order_id);
        $data->delivery_id = $request->delivery_id;
        $save = $data->update();

        if ($save) {
            return redirect()->route('kitchen.order_pending_list')->with('status', 'Updated successfully');
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error's Occour try again later"));
            exit;
        }
    }

    // Assign Chef

    public function assignChef(Request $request)
    {
        //        echo json_encode($request->all());exit;
        $currentDateTime = Carbon::now();

        $validator = Validator::make($request->all(), [
            'chef_id'          => 'required',
            'web_order_product_id'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $admin = Auth::guard('admin')->user();
            if ($admin->branch_id) {
                $web_order = WebOrder::find($request->web_order_id);
                $web_order->branch_id = $admin->branch_id;
                $web_order->save();
            }

            $web_order_products = WebOrderProduct::where('id', $request->web_order_product_id)->first();
            $web_order_products->chef_id = $request->chef_id;
            $save = $web_order_products->save();

            $all_items = WebOrderProduct::where('order_id', $web_order_products->order_id)->where('chef_id',null)->get();
            if (count($all_items) == 0) {
                $data = WebOrder::findOrFail($web_order_products->order_id);
                $data->status          = 'COOKING';
                $data->cookingstart    = $currentDateTime;
                $data->update();
            }
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Updated successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
            exit;
        }
    }
}
