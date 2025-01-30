<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Offer extends Controller
{
    /**
     * @return view coupon 
     */
    public function index()
    {
        $products = Products::where(['status' => 1])->get();
        return view('admin.offer.index' , compact('products'));
    }

    /**
     * @method use for show coupon ajax list
     */
    public function offerAjaxList(Request $request)
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

        $total = Offers::select("offers.*" , "products.product_name")
        ->join("products" , "offers.product_id" , "=" , "products.id")
        ->orWhere(function($query) use ($search){
            $query->orWhere('offers.name' , 'like' , '%'. $search.'%');
            $query->orWhere('product_name' , 'like' , '%'. $search.'%');
        })->count();

        $coupons = Offers::select("offers.*" , "products.product_name")
            ->join("products" , "offers.product_id" , "=" , "products.id")
            ->orWhere(function($query) use ($search){
                $query->orWhere('offers.name' , 'like' , '%'. $search.'%');
                $query->orWhere('product_name' , 'like' , '%'. $search.'%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($coupons as $cate) {

            $status = '<button class="statusVerifiedClick btn '. ($cate->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($cate->status == 1  ? '0' : '1' ).'" data-id="'. $cate->id .'">'.($cate->status == 1 ? "Active" : "De-Active" ).'</button>
                       ';
            $data[] = array(
                $i++,
                $cate->name,
                $cate->product_name,
                $cate->discount.'%',
                date('d-m-Y' , strtotime($cate->start_date)),
                date('d-m-Y' , strtotime($cate->end_date)),
                $status,
                '<a  href="javascript:void(0)" class="editOffer btn btn-info btn-sm " data-id="'.$cate->id.'" data-name="'.$cate->name.'"  data-discount="'.$cate->discount.'" data-start_date="'.$cate->start_date.'" data-end_date="'.$cate->end_date.'" data-product_id="'.$cate->product_id.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm coupon-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',

                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name'          => 'required|unique:offers,name',
            'product_name'  => 'required|exists:products,id',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'discount'      => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data                   = new Offers();
            $input['name']          = $request->name;
            $input['product_id']    = $request->product_name;
            $input['start_date']    = $request->start_date;
            $input['end_date']      = $request->end_date;
            $input['discount']      = $request->discount;
            $save = $data->fill($input)->save();
        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Offer add successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Errors Occur's try again later!!"]);
            exit;
        }

    }

    /**
     * @param Request $request
     * @method use for update coupon
     */
    public function update(Request $request)
    {
        $offers = Offers::findOrFail($request->cateid);
        $rules = [];
        if($request->coupon_name != $offers->coupon_name) 
        {
            $rules = [
                'name' => 'required|unique:offers,name',
            ];
        }
        $rules = [ 
            'start_date'    => 'required',
            'end_date'      => 'required',
            'discount'      => 'required',
            'product_name'  => 'required|exists:products,id',
        ];

        $validator = Validator::make($request->all() , $rules);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $offers->name          = $request->name;
            $offers->product_id    = $request->product_name;
            $offers->start_date    = $request->start_date;
            $offers->end_date      = $request->end_date;
            $offers->discount      = $request->discount;

            $update = $offers->update();
        }
        if($update)
        {
            return response()->json(['status' => true , 'msg' => "Offer update successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Errors Occur's try again later!!"]);
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

        $update = Offers::where($where)->update($data);

        if($update)
        {
            return response()->json(array('status' => true,'msg' => "Successfully Updated !"));
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
     * @method use for delete sub Category
     */
    public function destroy(Request $request)
    {
        try{
            $where = array('id' => $request->id);
            $cate = Offers::find($request->id);
            $del = Offers::where($where)->delete();
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

