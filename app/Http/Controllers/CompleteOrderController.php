<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WebOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompleteOrderController extends Controller
{
    public function completeOrderindex()
    {
        return view('admin.complete_order.index');
    }

    public function completeOrderList(Request $request)
    {
        // dd('hlo  ');
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

        // DB::enableQueryLog();

        $total = WebOrder::select("web_orders.*", 'deliveries.name', 'users.name as uname', 'users.phone as users_phone', 'home_delivery_addresses.first_name', 'home_delivery_addresses.last_name', 'home_delivery_addresses.house', 'home_delivery_addresses.street', 'home_delivery_addresses.apartment', 'home_delivery_addresses.city', 'home_delivery_addresses.state')
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('home_delivery_addresses', 'web_orders.shipping_address', '=', 'home_delivery_addresses.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');

            })
            ->where('web_orders.status', '=', 'COMPLETED')
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->count();
            // $queries = DB::getQueryLog();

// Optionally, dump the query log
// dd($queries);left
            // dd($total);
        $groups = WebOrder::select("web_orders.*", 'deliveries.name', 'users.name as uname', 'users.phone as users_phone', 'home_delivery_addresses.first_name', 'home_delivery_addresses.last_name', 'home_delivery_addresses.house', 'home_delivery_addresses.street', 'home_delivery_addresses.apartment', 'home_delivery_addresses.city', 'home_delivery_addresses.state')
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('home_delivery_addresses', 'web_orders.shipping_address', '=', 'home_delivery_addresses.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');

            })
            ->where('web_orders.status', '=', 'COMPLETED')
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;

        $data = [];

        foreach ($groups as $cate) {

            $data[] = array(
                date('d-m-Y', strtotime($cate->created_at)),
                $cate->uname,
                $cate->users_phone,
                $cate->house,
                $cate->txn_id,
                $cate->first_e_id,
                $cate->payment_mode,
                $cate->pay_amount,
                '<button class="btn btn-success" >Completed</button>',
                $cate->name,
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }
}
