<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IngredientPurchaseNew;
use App\Models\IngredientStocks;
use App\Models\StockInventry;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FoodPurchase;

class SupplierController extends Controller
{
    /**
     * @return view group index
     */
    public function index()
    {
        return view('admin.supplier.index');
    }

    /**
     * @method use for show coupon ajax list
     */
    public function supplier_AjaxList(Request $request)
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

        $total = Supplier::orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            $query->orWhere('phone', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
        })->count();

        $groups = Supplier::orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            $query->orWhere('phone', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $cate) {
            $status = '<button class="statusVerifiedClick btn ' . ($cate->status == 1 ? "btn-success btn-sm" : "btn-danger btn-sm") . '  " data-status="' . ($cate->status == 1 ? '0' : '1') . '" data-id="' . $cate->id . '">' . ($cate->status == 1 ? "Active" : "De-Active") . '</button>';
            $data[] = array(
                $i++,
                $cate->name,
                $cate->email,
                $cate->phone,
                $cate->address,
                $status,
                '<a  href="javascript:void(0)" class="editSupplier btn btn-info btn-sm "  data-id="' . $cate->id . '" data-name="' . $cate->name . '" data-email="' . $cate->email . '" data-phone="' . $cate->phone . '" data-address="' . $cate->address . '" > <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm delet_supplier" data-id="' . $cate->id . '"><i class="fa fa-trash"></i></a>',
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
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = new Supplier();
            $input['name'] = $request->name;
            $input['email'] = $request->email;
            $input['phone'] = $request->phone;
            $input['address'] = $request->address;
            $save = $data->fill($input)->save();
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Supplier created successfully"]);
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
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = Supplier::findOrFail($request->edit_user_id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Update supplier update successfully"]);
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

        $update = Supplier::where($where)->update($data);

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
            $del = Supplier::where($where)->delete();
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

    public function supplierHistory(Request $request)
    {

        $data = [];

        if ($request->type === "food") {
            $data = FoodPurchase::select('suppliers.name', 'food_purchases.*', 'food_purchases.total_amnt as totalAmount', 'food_purchases.due_amnt as dueAmount', 'food_purchases.paid_amnt as paidAmount')->join('suppliers', 'suppliers.id', 'food_purchases.supplier_id')->where('supplier_id', $request->supplier)->whereBetween('purchase_date', [date('Y-m-d', strtotime($request->from)), date('Y-m-d', strtotime($request->to))])->get();
            $type = $request->type;
        } elseif ($request->type === "ingredient") {
            $data = IngredientPurchaseNew::select('suppliers.name', 'ingredient_purchase.*', 'ingredient_purchase.total_amount as totalAmount', 'ingredient_purchase.due_amount as dueAmount', 'ingredient_purchase.paid_amount as paidAmount')->join('suppliers', 'suppliers.id', 'ingredient_purchase.supplier_id')->where('supplier_id', $request->supplier)->whereBetween('purchase_date', [date('Y-m-d', strtotime($request->from)), date('Y-m-d', strtotime($request->to))])->get();
            $type = $request->type;
        }else{
            $type = "";
        }

        $supplier = Supplier::where('status', 1)->get();
        return view('admin.supplier.history', compact('supplier', 'data', 'type'));
    }

    public function supplierViewDetails(Request $request)
    {

        if ($request->type === "food") {
            $data = FoodPurchase::select('suppliers.name', 'food_purchases.*', 'food_purchases.total_amnt as totalAmount', 'food_purchases.due_amnt as dueAmount', 'food_purchases.paid_amnt as paidAmount')->join('suppliers', 'suppliers.id', 'food_purchases.supplier_id')->where('food_purchases.id', $request->id)->first();
            if (!empty($data)) {
                $stock = StockInventry::select('stock_inventries.*', 'products.product_name as itemName')
                    ->join('products', 'products.id', 'stock_inventries.product_id')
                    ->where('food_purchase_id', $request->id)->get();
            } else {
                $stock = [];
            }
        } elseif ($request->type === "ingredient") {
            $data = IngredientPurchaseNew::select('suppliers.name', 'ingredient_purchase.*', 'ingredient_purchase.total_amount as totalAmount', 'ingredient_purchase.due_amount as dueAmount', 'ingredient_purchase.paid_amount as paidAmount')->join('suppliers', 'suppliers.id', 'ingredient_purchase.supplier_id')->where('ingredient_purchase.id', $request->id)->first();
            if (!empty($data)) {
                $stock = IngredientStocks::select('ingredient_stocks.*', 'ind_items.name as itemName')
                    ->join('ind_items', 'ind_items.id', 'ingredient_stocks.ingredient_id')
                    ->where('ingredients_purchase_id', $request->id)->get();
            } else {
                $stock = [];
            }
        } else {
            $data = "";
        }

        if (!empty($data)) {

            $html = '<table class="table table-bordered text-center table-striped">
                        <tr class="bg-info">
                            <th colspan="2" class="tableCellHeight text-white">PURCHASE DETAILS</th>
                        </tr>
                        <tr>
                            <th class="tableCellHeight">Supplier</th>
                            <td class="tableCellHeight">' . $data->name . '</td>
                        </tr>
                        <tr>
                            <th class="tableCellHeight">Invoice</th>
                            <td class="tableCellHeight">' . $data->invoice . '</td>
                        </tr>
                        <tr>
                            <th class="tableCellHeight">Purchased Date</th>
                            <td class="tableCellHeight">' . date("F d, Y", strtotime($data->purchase_date)) . '</td>
                        </tr>
                        <tr>
                            <th class="tableCellHeight">Total Bill</th>
                            <td class="tableCellHeight">$ ' . $data->totalAmount . '</td>
                        </tr>
                        <tr>
                            <th class="tableCellHeight">Paid Amount</th>
                            <td class="tableCellHeight">$ ' . $data->paidAmount . '</td>
                        </tr>
                        <tr>
                            <th class="tableCellHeight">Due</th>
                            <td class="tableCellHeight">$ ' . $data->dueAmount . '</td>
                        </tr>
                    </table><table class="table table-bordered text-center table-striped">
                        <tr class="bg-danger">
                            <th colspan="4" class="tableCellHeight text-white">PURCHASED ITEMS</th>
                        </tr>
                        <tr>
                            <th class="tableCellHeight">S/L</th>
                            <th class="tableCellHeight">Name</th>
                            <th class="tableCellHeight">Qty</th>
                            <th class="tableCellHeight">Rate</th>
                        </tr>';
            foreach ($stock as $key => $getStock) {
                $html .= '<tr>
                            <td class="tableCellHeight">' . ++$key . '</td>
                            <td class="tableCellHeight">' . $getStock->itemName . '</td>
                            <td class="tableCellHeight">' . $getStock->stock . '</td>
                            <td class="tableCellHeight">$ ' . $getStock->price . '</td>
                        </tr>';
            }

            $html .= '</table>';
        }else{
            $html = "";
        }

        return response()->json(array('status' => true, 'msg' => 'fetched', 'data' => $html));
    }

}
