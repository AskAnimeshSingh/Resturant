<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupons;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Coupon extends Controller
{
    /**
     * @return view coupon 
     */
    public function index()
    {
        $products = Products::where(['status' => 1])->get();
        return view('admin.coupons.index' , compact('products'));
    }

    /**
     * @method use for show coupon ajax list
     */
    public function couponAjaxList(Request $request)
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

        $total = Coupons::orWhere(function($query) use ($search){
            $query->orWhere('coupon_name' , 'like' , '%'. $search.'%');
        })->count();

        $coupons = Coupons::orWhere(function($query) use ($search){
            $query->orWhere('coupon_name' , 'like' , '%'. $search.'%');
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
                $cate->coupon_name,
                $cate->discount.'%',
                date('d-m-Y' , strtotime($cate->start_date)),
                date('d-m-Y' , strtotime($cate->end_date)),
                $status,
                '<a  href="javascript:void(0)" class="editCoupon btn btn-info btn-sm " data-id="'.$cate->id.'" data-coupon="'.$cate->coupon_name.'"  data-discount="'.$cate->discount.'" data-start_date="'.$cate->start_date.'" data-end_date="'.$cate->end_date.'"> <i class="fa fa-edit"></i></a> |
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
            'coupon_name'   => 'required|unique:coupons,coupon_name',
            // 'product_name'  => 'required',
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
            $data                   = new Coupons();
            $input['coupon_name']   = $request->coupon_name;
            // $input['product_id']    = $request->product_name;
            $input['start_date']    = $request->start_date;
            $input['end_date']      = $request->end_date;
            $input['discount']      = $request->discount;
            $save = $data->fill($input)->save();
        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "coupon add successfully"]);
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
        $coupons = Coupons::findOrFail($request->cateid);
        $rules = [];
        if($request->coupon_name != $coupons->coupon_name) 
        {
            $rules = [
                'coupon_name' => 'required|unique:coupons,coupon_name',
            ];
        }
        $rules = [ 
            'start_date'    => 'required',
            'end_date'      => 'required',
            'discount'      => 'required',
        ];

        $validator = Validator::make($request->all() , $rules);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $coupons->coupon_name   = $request->coupon_name;
            $coupons->start_date    = $request->start_date;
            $coupons->end_date      = $request->end_date;
            $coupons->discount      = $request->discount;

            $update = $coupons->update();
        }
        if($update)
        {
            return response()->json(['status' => true , 'msg' => "coupon update successfully"]);
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

        $update = Coupons::where($where)->update($data);

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
            $cate = Coupons::find($request->id);
            $del = Coupons::where($where)->delete();
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
