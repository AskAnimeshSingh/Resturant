<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branches;
use App\Models\IndItem;
use App\Models\IngredientPurchaseNew;
use App\Models\IngredientStocks;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IngredientPurchase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class IngredientPurchaseController extends Controller
{
    public function index()
    {
        $ingredientsItem = IndItem::where(['status' => 1])->get();
        $branches = Branches::where(['status' => 1])->get();
        $supplier = Supplier::where(['status' => 1])->get();
        return view('admin.ingedient_purchase.index', compact('ingredientsItem', 'branches', 'supplier'));
    }

    public function list()
    {
        return view('admin.ingedient_purchase.list');
    }

    public function storeIngredientPurchase(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_price' => 'required',
            'vendor_name' => 'required',
            'purchase_date' => 'required',
            'vendor_address' => 'required',
            'cgst' => 'required',
            'sgst' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        } else {
            $data = new IngredientPurchase();
            $input['product_name'] = $request->product_name;
            $input['product_price'] = $request->product_price;
            $input['vendor_name'] = $request->vendor_name;
            $input['purchase_date'] = $request->purchase_date;
            $input['vendor_address'] = $request->vendor_address;
            $input['cgst'] = $request->cgst;
            $input['sgst'] = $request->sgst;
            $input['quantity'] = $request->quantity;
            $input['unit'] = $request->unit;
            $save = $data->fill($input)->save();
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Added successfully"]);
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
        }
    }

    public function AjaxListIngredientPurchase(Request $request)
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

        $total = IngredientPurchaseNew::select('ingredient_purchase.*', 'suppliers.name')->join('suppliers', 'suppliers.id', 'ingredient_purchase.supplier_id')->orWhere(function ($query) use ($search) {
            $query->orWhere('suppliers.name', 'like', '%' . $search . '%');
        })->count();

        $ingredient = IngredientPurchaseNew::select('ingredient_purchase.*', 'suppliers.name')->join('suppliers', 'suppliers.id', 'ingredient_purchase.supplier_id')->orWhere(function ($query) use ($search) {
            $query->orWhere('suppliers.name', 'like', '%' . $search . '%');
        })->offset($ofset)->limit($limit)->orderBy($nameOrder, $orderType)->orderBy('id', 'DESC')->get();

        $i = 1 + $ofset;
        $data = [];

        foreach ($ingredient as $val) {
            $data[] = array(
                $i++,
                $val->name,
                $val->invoice,
                date('F d, Y', strtotime($val->purchase_date)),
                '$ ' . $val->total_amount,
                '$ ' . $val->due_amount,
                '<a  href="' . route('admin.ingredient_purchase_edit', $val->id) . '" class="btn btn-info btn-sm "> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm delete_ingredient" data-id="' . $val->id . '"><i class="fa fa-trash"></i></a>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function UpdateIngredientPurchase(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'edit_product_name' => 'required',
            'edit_product_price' => 'required',
            'edit_vendor_name' => 'required',
            'edit_purchase_date' => 'required',
            'edit_vendor_address' => 'required',
            'edit_cgst' => 'required',
            'edit_sgst' => 'required',
            'edit_quantity' => 'required',
            'edit_unit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        } else {
            $data = IngredientPurchase::findOrFail($request->id);
            $input['product_name'] = $request->edit_product_name;
            $input['product_price'] = $request->edit_product_price;
            $input['vendor_name'] = $request->edit_vendor_name;
            $input['purchase_date'] = $request->edit_purchase_date;
            $input['vendor_address'] = $request->edit_vendor_address;
            $input['cgst'] = $request->edit_cgst;
            $input['sgst'] = $request->edit_sgst;
            $input['quantity'] = $request->edit_quantity;
            $input['unit'] = $request->edit_unit;
            $save = $data->fill($input)->update();
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Updated successfully"]);
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
        }
    }

    public function DestoryIngredientPurchase(Request $request)
    {
        try {
            $where = array('id' => $request->id);
            $del = IngredientPurchaseNew::where($where)->delete();
            if ($del) {
                IngredientStocks::where('ingredient_id',$request->id)->delete();
                return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }

    public function ingredientPurchaseShowItems(Request $request)
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

            $data = IndItem::where('status', 1)->whereIn('id', $request->items)->get();

            foreach ($data as $getData) {
                $ingredient = IngredientStocks::where(['ingredient_id' => $getData->id, 'branch_id' => $request->branchId])->sum('stock');
                if (!empty($ingredient)) {
                    $stock = $ingredient;
                } else {
                    $stock = 0;
                }
                $html .= '<tr>
                    <td>' . $getData->name . '</td>
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

    public function storeIngredientPurchaseNew(Request $request)
    {

        $ingredient = new IngredientPurchaseNew();
        $ingredient->branch_id = $request->branch;
        $ingredient->supplier_id = $request->supplier;
        $ingredient->invoice = $request->invoice;
        $ingredient->purchase_date = $request->purchase_date;
        $ingredient->description = $request->description;
        $ingredient->payment_type = $request->payment_type;
        $ingredient->total_amount = array_sum($request->subTotal);
        $ingredient->paid_amount = $request->totalPrice;
        $ingredient->due_amount = $request->duePrice;
        $store = $ingredient->save();
        if (!empty($store)) {

            foreach ($request->items as $key => $getItems) {
                $stocks = new IngredientStocks();
                $stocks->ingredients_purchase_id = $ingredient->id;
                $stocks->branch_id = $request->branch;
                $stocks->ingredient_id = $getItems;
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

        $data = IngredientPurchaseNew::select('ingredient_purchase.*', 'suppliers.name as supplierName', 'branches.name as branchName', 'branches.phone')->join('suppliers', 'suppliers.id', 'ingredient_purchase.supplier_id')
            ->join('branches', 'branches.id', 'ingredient_purchase.branch_id')
            ->where(['ingredient_purchase.id' => $request->id])->first();

        if (!empty($data)) {
            $ingredient_stocks = IngredientStocks::select('ingredient_stocks.*', 'ind_items.name')
                ->join('ind_items', 'ind_items.id', 'ingredient_stocks.ingredient_id')->where('ingredients_purchase_id', $data->id)->get();
        } else {
            $ingredient_stocks = [];
        }

        return view('admin.ingedient_purchase.edit', compact('data', 'ingredient_stocks'));
    }

    public function updateIngredientPurchaseNew(Request $request)
    {

        $data = array(
            'invoice' => $request->invoice,
            'purchase_date' => $request->purchase_date,
            'description' => $request->description,
            'payment_type' => $request->payment_type,
            'total_amount' => array_sum($request->subTotal),
            'paid_amount' => $request->totalPrice,
            'due_amount' => $request->duePrice,
        );

        $update = IngredientPurchaseNew::where('id', $request->ind_id)->update($data);

        if (!empty($update)) {

            foreach ($request->stockId as $key => $val) {
                IngredientStocks::where('id', $val)->update(['stock' => $request->qty[$key], 'price' => $request->price[$key]]);
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
