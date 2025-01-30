<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\FoodPurchase as ModelsFoodPurchase;
use App\Models\FoodPurchaseHistory;
use App\Models\IndItem;
use App\Models\IngredientPurchaseNew;
use App\Models\IngredientStocks;
use App\Models\PaymentType;
use App\Models\Products;
use App\Models\StockInventry;
use App\Models\Supplier;
use App\Models\Delivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FoodPurchase extends Controller
{
    /**
     * @return view group index
     */
    public function index()
    {

        $foodItems = Products::where(['status' => 1])->get();
        $branches = Branches::where(['status' => 1])->get();
        $supplier = Supplier::where(['status' => 1])->get();
        return view('admin.food_purchase.index', compact('foodItems', 'branches', 'supplier'));
    }

    /**
     * @return view food purchase list
     */
    public function food_purchase_list(Request $request)
    {
        return view('admin.food_purchase.list');
    }


    /**
     * @method use for show coupon ajax list
     */
    public function food_purchase_AjaxList(Request $request)
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

        $total = ModelsFoodPurchase::select('food_purchases.*', 'suppliers.name')->join('suppliers', 'suppliers.id', 'food_purchases.supplier_id')->orWhere(function ($query) use ($search) {
            $query->orWhere('suppliers.name', 'like', '%' . $search . '%');
        })->count();

        $groups = ModelsFoodPurchase::select('food_purchases.*', 'suppliers.name')->join('suppliers', 'suppliers.id', 'food_purchases.supplier_id')->orWhere(function ($query) use ($search) {
            $query->orWhere('suppliers.name', 'like', '%' . $search . '%');
        })->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->orderBy('id', 'DESC')->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $val) {
            $data[] = array(
                $i++,
                $val->name,
                $val->invoice,
                date('F d, Y', strtotime($val->purchase_date)),
                '$ ' . $val->total_amnt,
                '$ ' . $val->due_amnt,
                '<a  href="' . url('admin/food_purchase/edit/' . $val->id) . '" class="btn btn-info btn-sm "> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm food-delete" data-id="' . $val->id . '"><i class="fa fa-trash"></i></a>',
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
            'branch' => 'required|exists:branches,id',
            'supplier' => 'required|exists:suppliers,id',
            'invoice' => 'required',
            'purchase_date' => 'required',
            'payment_type' => 'required',
            'food' => 'required|exists:products,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {

            $data = new ModelsFoodPurchase();
            $input['branch_id'] = $request->branch;
            $input['supplier_id'] = $request->supplier;
            $input['invoice'] = $request->invoice;
            $input['purchase_date'] = $request->purchase_date;
            $input['payment_type'] = $request->payment_type;
            $input['due_amnt'] = $request->due;
            $input['paid_amnt'] = $request->paid;
            $input['total_amnt'] = ($request->due + $request->paid);
            $input['description'] = $request->description;
            $save = $data->fill($input)->save();

            if ($save) {
                foreach ($request->food as $item) {
                    $getProduct = Products::findOrFail($item);
                    $foodHistory = new FoodPurchaseHistory();
                    $input1['food_purchase_id'] = $data->id;
                    $input1['product_id'] = $item;
                    $input1['qty'] = $getProduct->sell_qty;
                    $input1['price'] = $getProduct->sell_price;
                    $input1['total_price'] = ($getProduct->sell_price * $getProduct->sell_qty);
                    $input1['branch_id'] = $request->branch;
                    $result = $foodHistory->fill($input1)->save();

                    // Manage Qty
                    $checkAvlbStock = StockInventry::where(['product_id' => $item, 'price' => $getProduct->sell_price])->first();
                    if ($checkAvlbStock) {
                        $checkAvlbStock->stock += $getProduct->sell_qty;
                        $checkAvlbStock->update();
                    } else {
                        $manageStock = new StockInventry();
                        $input2['branch_id'] = $request->branch;
                        $input2['product_id'] = $item;
                        $input2['stock'] = $getProduct->sell_qty;
                        $input2['price'] = $getProduct->sell_price;

                        $result = $manageStock->fill($input2)->save();
                    }

                    $getProduct->sell_price = 0;
                    $getProduct->sell_qty = 0;
                    $getProduct->update();
                }
            }

        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "New purchase generated successfully successfully"]);
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
        if ($request->password != "") {
            $rules = [
                'password' => 'min:4',
                'password_confirmation' => 'required_with:password|same:password|min:4'
            ];
        }
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            if ($request->file('image') != "") {
                File::delete(public_path('../' . $request->img));
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/delivery'), $favicon);
                $favicon = "/public/assets/admin/assets/img/delivery/" . $favicon;
            }

            $data = Delivery::findOrFail($request->edit_user_id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->password = Hash::make($request->password);
            $data->branch_id = $request->branch;
            if ($request->file('image') != "") {
                $data->image = $favicon;
            }
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Delivery user Update successfully"]);
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

        $update = Delivery::where($where)->update($data);

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
            $del = ModelsFoodPurchase::where($where)->delete();
            if ($del) {
                StockInventry::where('food_purchase_id', $request->id)->delete();
                return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }

    /**
     * @param Request $request
     * @method use for add product for purchase
     */
    public function show_food(Request $request)
    {
        $foodId = explode(",", $request->food_id);

        $data = Products::select("products.*")->whereIn('id', $foodId)->get();

        $html = '';
        $i = 1;
        $total = 0;
        if ($data) {
            $html .= '<table class="table table-bordered border" id="food_list_show">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th class="text-center">#</th>';
            $html .= '<th>Name</th>';
            $html .= '<th>Stock</th>';
            $html .= '<th>Qty</th>';
            $html .= '<th>Rate/Item</th>';
            $html .= '<th>Total</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<body>';
            foreach ($data as $item) {
                // check Stock
                $stock = StockInventry::where(['product_id' => $item->id, 'branch_id' => $request->branch_id])->sum(DB::raw('stock'));
                $totalPrice = ($item->sell_price * $item->sell_qty);
                $total += $totalPrice;
                $html .= '<tr>';
                $html .= '<td>' . $i++ . '</td>';
                $html .= '<td>' . $item->product_name . '</td>';
                $html .= '<td>' . $stock . '</td>';
                $html .= '<td><input type="number" name="qty" class="form-control changeQty" data-id="' . $item->id . '" id="getQty' . $item->id . '" value="' . $item->sell_qty . '" style="width:150px;"></td>';
                $html .= '<td><input type="number" name="qty" class="form-control changePrice" data-id="' . $item->id . '" id="getPrice' . $item->id . '" value="' . $item->sell_price . '" style="width:150px;"></td>';
                $html .= '<td>' . $totalPrice . '</td>';
                $html .= '</tr>';
            }
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td><b>Total Bill</b></td>';
            $html .= '<td><b>' . $total . '</b></td>';
            $html .= '<tr>';
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td><b>Paid</b></td>';
            $html .= '<td><b><input type="number" name="paid" class="form-control paid" value="' . $total . '" style="width:100px;"></b></td>';
            $html .= '<tr>';
            $html .= '<tr>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td></td>';
            $html .= '<td><b>Due</b></td>';
            $html .= '<td><b><input type="number" name="due" class="form-control due" value="" style="width:100px;"></b></td>';
            $html .= '<tr>';
            $html .= '</body>';
            $html .= '</table>';
        }
        return response()->json(['data' => $data, 'html' => $html, 'total' => $total]);
    }

    /**
     * @param Request $request
     * @method use for update qty
     */
    public function update_qty(Request $request)
    {
        $findProduct = Products::findOrFail($request->id);
        $findProduct->sell_qty = $request->qty;

        $update = $findProduct->update();

        if ($update) {
            return response()->json(array('status' => true, 'msg' => " Qty update Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for update price
     */
    public function update_price(Request $request)
    {
        $findProduct = Products::findOrFail($request->id);
        $findProduct->sell_price = $request->price;

        $update = $findProduct->update();

        if ($update) {
            return response()->json(array('status' => true, 'msg' => " Price update Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    /**
     * @return view food purchase detail view
     */
    public function food_purchase_show_detail(Request $request)
    {
        $branches = Branches::get();
        $suppliers = Supplier::where(['status' => 1])->get();
        $payment_type = PaymentType::where(['status' => 1])->get();
        return view('admin.food_purchase.detail', compact('branches', 'suppliers', 'payment_type'));
    }

    public function foodPurchaseShowItems(Request $request)
    {

        if (count($request->items) > 0) {
            $html = '<table class="table table-bordered text-center">
                <tr>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Total</th>
                </tr>';

            $data = Products::where('status', 1)->whereIn('id', $request->items)->get();

            foreach ($data as $getData) {
                $food = StockInventry::where(['product_id' => $getData->id, 'branch_id' => $request->branchId])->sum('stock');
                if (!empty($food)) {
                    $stock = $food;
                } else {
                    $stock = 0;
                }
                $html .= '<tr>
                    <td>' . $getData->product_name . '</td>
                    <td>' . $stock . '</td>
                    <td><input type="text" class="form-control text-center qtychange qty' . $getData->id . '" data-id="' . $getData->id . '" name="qty[]" placeholder="Qty" required></td>
                    <td><input type="text" class="form-control text-center pricechange price' . $getData->id . '" data-id="' . $getData->id . '" name="price[]" placeholder="Price in USD" required></td>
                    <td class="d-none"><input type="text" name="subTotal[]" class="form-control text-center subTotalPrice' . $getData->id . '"></td>
                    <td>$ <span class="total' . $getData->id . '">0.00</span></td>
                </tr>';
            }

            $html .= '<tr>
                    <th colspan="3"></th>
                    <th>Total Bill</th>
                    <th>$ <span class="totalBill">0.00</span></th>
                </tr>
                <tr>
                    <th colspan="3"></th>
                    <th>Paid</th>
                    <th><input type="text" class="form-control text-center paidAmount" name="totalPrice" placeholder="Price in USD" required></th>
                </tr>
                <tr>
                    <th colspan="3"></th>
                    <th>Due</th>
                    <th class="d-none"><input type="text" class="form-control text-center due" name="duePrice" placeholder="Price in USD"></th>
                    <th>$ <span class="dueAmount">0.00</span></th>
                </tr>
                </table>';
            return response()->json(array('status' => true, 'msg' => 'Fetched', 'data' => $html));
        } else {
            return response()->json(array('status' => false, 'msg' => 'Fetched', 'data' => ""));
        }
    }

    public function storeFoodPurchaseNew(Request $request)
    {

        $food = new ModelsFoodPurchase();
        $food->branch_id = $request->branch;
        $food->supplier_id = $request->supplier;
        $food->invoice = $request->invoice;
        $food->purchase_date = $request->purchase_date;
        $food->description = $request->description;
        $food->payment_type = $request->payment_type;
        $food->total_amnt = array_sum($request->subTotal);
        $food->paid_amnt = $request->totalPrice;
        $food->due_amnt = $request->duePrice;

        $store = $food->save();
        if (!empty($store)) {

            foreach ($request->items as $key => $getItems) {
                $stocks = new StockInventry();
                $stocks->food_purchase_id = $food->id;
                $stocks->branch_id = $request->branch;
                $stocks->product_id = $getItems;
                $stocks->stock = $request->qty[$key];
                $stocks->price = $request->price[$key];
                $stocks->save();
            }
            Session::flash('message', 'Added Successfully');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {

        $data = ModelsFoodPurchase::select('food_purchases.*', 'suppliers.name as supplierName', 'branches.name as branchName', 'branches.phone')->join('suppliers', 'suppliers.id', 'food_purchases.supplier_id')
            ->join('branches', 'branches.id', 'food_purchases.branch_id')
            ->where(['food_purchases.id' => $request->id])->first();

        if (!empty($data)) {
            $ingredient_stocks = StockInventry::select('stock_inventries.*', 'products.product_name')
                ->join('products', 'products.id', 'stock_inventries.product_id')->where('food_purchase_id', $data->id)->get();
        } else {
            $ingredient_stocks = [];
        }

        return view('admin.food_purchase.edit', compact('data', 'ingredient_stocks'));
    }

    public function updateFoodPurchaseNew(Request $request)
    {

        $data = array(
            'invoice' => $request->invoice,
            'purchase_date' => $request->purchase_date,
            'description' => $request->description,
            'payment_type' => $request->payment_type,
            'total_amnt' => array_sum($request->subTotal),
            'paid_amnt' => $request->totalPrice,
            'due_amnt' => $request->duePrice,
        );

        $update = ModelsFoodPurchase::where('id', $request->ind_id)->update($data);

        if (!empty($update)) {

            foreach ($request->stockId as $key => $val) {
                StockInventry::where('id', $val)->update(['stock' => $request->qty[$key], 'price' => $request->price[$key]]);
            }
            Session::flash('message', 'Updated Successfully');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
}
