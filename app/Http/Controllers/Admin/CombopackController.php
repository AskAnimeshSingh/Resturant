<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Combopack;
use App\Models\ComboProduct;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class CombopackController extends Controller
{
    //
    public function combolist()
    {
        $items = Products::where(['status' => 1])->get();
        return view('admin.combopack.combolist' , compact('items'));
    }


    public function comboAjaxList(Request $request)
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

        $total = Combopack::orWhere('package_name' , 'like' , '%'. $search.'%')->count();
        $category = Combopack::orWhere('package_name' , 'like' , '%'. $search.'%')

            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($category as $cate) {
            $pluckId = ComboProduct::where(['pack_id' => $cate->id])->pluck('id');
            $getItem = ComboProduct::select("combo_products.*" , "products.product_name")
            ->join('products' , 'combo_products.product_id' , '=' , 'products.id')
            ->where(['pack_id' => $cate->id])->get();
            
            $item = '';
            if($getItem){
                foreach($getItem as $val)
                {
                    $item .= '<button class="btn btn-primary">'.$val->product_name.'</button>';
                }
            }
            
            $status = '<button class="statusVerifiedClick btn '. ($cate->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($cate->status == 1  ? '0' : '1' ).'" data-id="'. $cate->id .'">'.($cate->status == 1 ? "Active" : "De-Active" ).'</button>
                       ';
            $data[] = array(
                $i++,
                '<img class="round justify-content-center" src="'.url($cate->image ?  $cate->image : 'public/assets/admin/assets/img/default_cate.jpeg').'" style="height:30px;"><br><b>'.$cate->package_name.'</b>',
                $item,
                $cate->start_date,
                $cate->end_date,
                $cate->price,
                $status,
                '<a  href="#" class="editCategory btn btn-info btn-sm " data-package_name="'.$cate->package_name.'" data-item="'.$pluckId.'" data-start_date="'.$cate->start_date.'" data-end_date="'.$cate->end_date.'"   data-price="'.$cate->price.'" data-tax="'.$cate->tax.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm category-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',

                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function storecombo(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'Packname'          => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'price'             => 'required',
            'tax'               => 'required',
            'item'              => "required",

        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            if ($request->file('image') != "") {
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/combo'), $favicon);
                $favicon = "/public/assets/admin/assets/img/combo/" . $favicon;
            } else {
                $favicon = '/public/assets/admin/assets/img/default_cate.jpeg';
            }
            $data = new Combopack();
            $input['package_name']          = $request->Packname;
            $input['offer_product_name']    = $request->offered_product;
            $input['start_date']            = $request->start_date;
            $input['end_date']              = $request->end_date;
            $input['price']                 = $request->price;
            $input['tax']                   = $request->tax;
            $input['image']                 = $favicon;
            $save = $data->fill($input)->save();

                foreach($request->item as $i){
                    $packProduct            = new ComboProduct();
                    $input1['pack_id']      = $data->id;
                    $input1['product_id']    = $i;
                    $saveProduct = $packProduct->fill($input1)->save();
                }
              

           
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Combopack save successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all() , [
            'packname'          => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'price'             => 'required',
            'tax'               => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data = Combopack::findOrFail($request->comboid);
            $data->package_name         = $request->packname;
            $data->start_date           = $request->start_date;
            $data->end_date             = $request->end_date;
            $data->price                = $request->price;
            $data->tax                  = $request->tax;
            $save                       = $data->update();
            if(!empty($request->item)) {
                // Delete previous
                ComboProduct::where(['pack_id' => $request->comboid])->delete();
                 foreach($request->item as $i){
                    $packProduct            = new ComboProduct();
                    $input1['pack_id']      = $data->id;
                    $input1['product_id']    = $request->comboid;
                    $saveProduct = $packProduct->fill($input1)->save();
                }
            }
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Combopack update successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }


    public function status(Request $request)
    {
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = Combopack::where($where)->update($data);

        if($update)
        {
            return response()->json(array('status' => true,'msg' => "Successfully Updated Status !"));
            exit;
        }
        else
        {
            return response()->json(array('status' => false,'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for destroy category
     */
    public function destroy(Request $request)
    {
        try{
                $where = array('id' => $request->id);
                $cate = Combopack::find($request->id);
                $del = Combopack::where($where)->delete();

            if ($del) {
                return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
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



}
