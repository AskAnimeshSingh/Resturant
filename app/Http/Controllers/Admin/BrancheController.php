<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branches;
use App\Models\Delivery;
use App\Models\WebOrder;
use Illuminate\Http\Request;
use App\Models\WebOrderProduct;
use App\Models\HomeDeliveryAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BrancheController extends Controller
{
    /**
     * @return view group index
     */
    public function index()
    {
        return view('admin.branches.index');
    }

    /**
     * @method use for show coupon ajax list
     */
    public function brancheAjaxList(Request $request)
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

        $total = Branches::orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            $query->orWhere('address', 'like', '%' . $search . '%');
            $query->orWhere('address', 'like', '%' . $search . '%');
        })->count();

        $groups = Branches::orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            $query->orWhere('address', 'like', '%' . $search . '%');
            $query->orWhere('address', 'like', '%' . $search . '%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $cate) {

            $status = '<button class="statusVerifiedClick btn ' . ($cate->status == 1 ? "btn-success btn-sm" : "btn-danger btn-sm") . '  " data-status="' . ($cate->status == 1 ? '0' : '1') . '" data-id="' . $cate->id . '">' . ($cate->status == 1 ? "Active" : "De-Active") . '</button>
                       ';
            $data[] = array(
                $i++,
                $cate->name,
                $cate->phone,
                $cate->address,
                '₹ ' . $cate->delivery_fee,
                $status,
                '<a  href="javascript:void(0)" class="editBranch btn btn-info btn-sm "  data-id="' . $cate->id . '" data-name="' . $cate->name . '" data-phone="' . $cate->phone . '" data-address="' . $cate->address . '" data-delivery_fee="' . $cate->delivery_fee . '"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm branch-delete" data-id="' . $cate->id . '"><i class="fa fa-trash"></i></a>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for store new blogs
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'delivery_fee' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = new Branches();
            $input['name'] = $request->name;
            $input['phone'] = $request->phone;
            $input['address'] = $request->address;
            $input['delivery_fee'] = $request->delivery_fee;
            $save = $data->fill($input)->save();
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Branch created successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for update blog
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'delivery_fee' => 'required',
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = Branches::findOrFail($request->edit_branch_id);
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->delivery_fee = $request->delivery_fee;
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Branch Update successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

    /**
     * @param $coupon_id
     * @method use for Request $request
     */
    public function statusUpdate(Request $request)
    {
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = Branches::where($where)->update($data);

        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for delete sub Category
     */
    public function destroy(Request $request)
    {
        try {
            $where = array('id' => $request->id);
            $del = Branches::where($where)->delete();
            if ($del) {
                return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
                exit;
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
                exit;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }

    //Order Details

    public function order_details()
    {
        $delivery = Delivery::select('deliveries.id', 'deliveries.name')->get();
        return view('admin.order.list', compact('delivery'));
    }

    public function order_ajax(Request $request)
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


        $total = WebOrder::select("web_orders.*", 'deliveries.name', 'users.name as uname',
            'users.phone as users_phone', 'user_addresses.city', 'user_addresses.state',
            'user_addresses.house', 'user_addresses.street', 'user_addresses.apartment', 'user_addresses.cross_street',)
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');
            })->count();

        $groups = WebOrder::select("web_orders.*", 'deliveries.name', 'users.name as uname',
            'users.phone as users_phone', 'user_addresses.city', 'user_addresses.state',
            'user_addresses.house', 'user_addresses.street', 'user_addresses.apartment', 'user_addresses.cross_street',)
            ->leftjoin('deliveries', 'web_orders.delivery_id', '=', 'deliveries.id')
            ->leftjoin('users', 'web_orders.user_id', '=', 'users.id')
            ->leftjoin('user_addresses', 'web_orders.shipping_address', '=', 'user_addresses.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('txn_id', 'like', '%' . $search . '%');

            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;

        // print_r($groups);exit;
        $data = [];

        foreach ($groups as $cate) {

            $data[] = array(

                date('d-m-Y', strtotime($cate->created_at)),
                $cate->uname,
                $cate->users_phone,
                $cate->house . ', ' . $cate->street . ', ' . $cate->apartment . ', ' . $cate->city . ', ' . $cate->state,
                $cate->txn_id,
                $cate->invoice_id,
                $cate->payment_mode,
                $cate->pay_amount,
                '<select name="status" style="width: 120px"  id="status_update" data-status="' . $cate->status . '" class="form-control list-dropdown ' . ($cate->status == "PENDING" ? 'bg-secondary' : ($cate->status == "COMPLETED" ? 'bg-success' : ($cate->status == "CANCELLED" ? 'bg-warning' : ''))) . '" data-id="' . $cate->id . '">
                    <option value="PENDING" ' . ($cate->status == "PENDING" ? 'selected' : '') . ' data-value ="PENDING">Pending</option>
                    <option value="COMPLETED" ' . ($cate->status == "COMPLETED" ? 'selected' : '') . ' data-value ="COMPLETED" >Completed</option>
                    <option value="CANCELLED" ' . ($cate->status == "CANCELLED" ? 'selected' : '') . ' data-value ="CANCELLED" >Cancelled</option>
                    </select>',
                '<div class=""><a href="' . url("admin/order-particular-details", $cate->id) . '" class="btn btn-warning btn-sm" style="width: 120px"> Order Details </a></div>' . '' .
                '<div class="mt-2"><a href="javascript: void(0);" class="editUser btn btn-primary btn-sm" data-id="' . $cate->id . '" style="width: 120px"> <i class="fa fa-plus"></i>Delivery Boy</a>&emsp;</div>'

            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    public function order_particular_details($id)
    {


        $data = WebOrderProduct::select("web_order_products.*", 'products.product_name',
            'products.qty', 'products.price', 'products.type as product_type', 'products.size',
            'combopacks.package_name', 'combopacks.image', 'web_order_products.qty as pro_qty')
            ->leftjoin('products', 'web_order_products.product_id', '=', 'products.id')
            ->leftjoin('combopacks', 'web_order_products.combo_pack_id', '=', 'combopacks.id')
            ->where('web_order_products.order_id', $id)->get();

        return view('admin.order.detail', compact('data'));
    }


    public function orderStoreDeliveryboy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {

            $data = WebOrder::findOrFail($request->order_id);
            $data->delivery_user_id = $request->delivery_user_id;
            $save = $data->update();

        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Updated successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
            exit;
        }
    }

    public function updateOrderDeliveryStatus(Request $request)
    {
        // print_r($request->all());
        // exit;
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = WebOrder::where(["id" => $request->id])->update(["status" => $request->status]);

        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }


}
