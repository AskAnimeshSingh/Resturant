<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AddStock;
use Illuminate\Support\Facades\Validator;

class AddStockcontroller extends Controller
{
    public function viewStock()
    {
        return view('admin.add_stock.view-stock');
    }

    public function viewAjaxStockList(Request $request)
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

        $total = AddStock::select("add_stocks.*")

            ->orWhere(function($query) use ($search) {
                $query->orWhere('name' , 'like' , '%'. $search.'%');

            })
            ->count();

        $products = AddStock::select("add_stocks.*")

            ->orWhere(function($query) use ($search) {
                $query->orWhere('name' , 'like' , '%'. $search.'%');

            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
            // print_r($products);exit;

        $i = 1 + $ofset;
        $data = [];
        foreach ($products as $cate) {


            $data[] = array(
                $i++,
                '<img class="round justify-content-center" src="'.url($cate->image ?  $cate->image : 'public/assets/admin/assets/img/default_cate.jpeg').'" style="height:40px;"><br><b>'.$cate->name.'<b>',
                $cate->name,
                $cate->price,
                $cate->unit,
                $cate->stock,
                $cate->stock_received_from,
                $cate->expiry_date
                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    public function addStock(Request $request)
    {

        $validator = Validator::make($request->all() , [
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'stock' => 'required',
            'stock_received_from' => 'required',
            'expiry_date' => 'required',
            'product_image'     => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048'

        ]);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            if ($request->file('product_image') != "") {
                $favicon = uniqid(time()) . '.' . $request->product_image->extension();
                $request->product_image->move(public_path('assets/admin/assets/img/stock_image'), $favicon);
                $favicon = "/public/assets/admin/assets/img/stock_image/" . $favicon;
            } else {
                $favicon = '/public/assets/admin/assets/img/default_cate.jpeg';
            }

            $data = new AddStock();
            $data->name = $request->name;
            $data->price = $request->price;
            $data->unit = $request->unit;
            $data->stock = $request->stock;
            $data->stock_received_from = $request->stock_received_from;
            $data->expiry_date = $request->expiry_date;
            $data->image = $favicon;
            $save = $data->save();

        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Stock Saved successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occour try again later"]);
            exit;
        }
    }


    public function indexStock()
    {
        return view('admin.add_stock.add-stock');
    }
}
