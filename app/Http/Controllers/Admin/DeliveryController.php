<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Delivery;
use App\Models\DeliveryCharges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
     /**
     * @return view group index
     */
    public function index()
    {
        $branches = Branches::get();
        return view('admin.delivery.index', compact('branches'));
    }

    /**
     * @method use for show coupon ajax list
     */
    public function deliveryAjaxList(Request $request)
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

        $total = Delivery::select("deliveries.*" , 'branches.name as branch_name')
        ->join('branches' , 'deliveries.branch_id' , '=' , 'branches.id')
        ->orWhere(function($query) use ($search){
            $query->orWhere('deliveries.name' , 'like' , '%'. $search.'%');
            $query->orWhere('branches.name' , 'like' , '%'. $search.'%');
        })->count();

        $groups = Delivery::select("deliveries.*" , 'branches.name as branch_name')
        ->join('branches' , 'deliveries.branch_id' , '=' , 'branches.id')
        ->orWhere(function($query) use ($search){
            $query->orWhere('deliveries.name' , 'like' , '%'. $search.'%');
            $query->orWhere('branches.name' , 'like' , '%'. $search.'%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $cate) {
            $status = '<button class="statusVerifiedClick btn '. ($cate->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($cate->status == 1  ? '0' : '1' ).'" data-id="'. $cate->id .'">'.($cate->status == 1 ? "Active" : "De-Active" ).'</button>';
            $data[] = array(
                $i++,
                '<img class="rounded" src="'.url($cate->image ?  $cate->image : 'public/assets/admin/assets/img/default_cate.jpeg').'" style="height:50px;">',
                $cate->name,
                $cate->phone,
                $cate->branch_name,
                $status,
                '<a  href="javascript:void(0)" class="editUser btn btn-info btn-sm "  data-id="'.$cate->id.'" data-name="'.$cate->name.'" data-phone="'.$cate->phone.'" data-branch="'.$cate->branch_id.'" data-type="'.$cate->type.'" data-email="'.$cate->email.'" data-img="'.$cate->image.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm user-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',
                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for store new blogs
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name'              => 'required',
            'email'             => 'required|email',
            'phone'             => 'required',
            'password'          => 'min:4',
            'password_confirmation' => 'required_with:password|same:password|min:4'
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
                $request->image->move(public_path('assets/admin/assets/img/delivery'), $favicon);
                $favicon = "/public/assets/admin/assets/img/delivery/" . $favicon;
            } else {
                $favicon = '/public/assets/admin/assets/img/default_cate.jpeg';
            }

            $data                   = new Delivery();
            $input['name']          = $request->name;
            $input['email']         = $request->email;
            $input['phone']         = $request->phone;
            $input['password']      = Hash::make($request->password);
            $input['image']         = $favicon;
            $input['branch_id']     = $request->branch;
            $save   = $data->fill($input)->save();
        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Delivery user created successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occour try again later"]);
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for update blog
     */
    public function update(Request $request)
    {
        if($request->password != "") {
            $rules = [
                'password'          => 'min:4',
                'password_confirmation' => 'required_with:password|same:password|min:4'
            ];
        }
        $rules = [
            'name'              => 'required',
            'email'             => 'required|email',
            'phone'             => 'required',
        ];
        $validator = Validator::make($request->all() ,$rules);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            if ($request->file('image') != "") {
                File::delete(public_path('../'.$request->img));
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/delivery'), $favicon);
                $favicon = "/public/assets/admin/assets/img/delivery/" . $favicon;
            }

            $data = Delivery::findOrFail($request->edit_user_id);
            $data->name          = $request->name;
            $data->email         = $request->email;
            $data->phone         = $request->phone;
            $data->password      = Hash::make($request->password);
            $data->branch_id     = $request->branch;
            if ($request->file('image') != "") {
                $data->image     = $favicon;
            }
            $save = $data->update();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Delivery user Update successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
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
            $del = Delivery::where($where)->delete();
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

    public function viewDeliveryCharges(){
        $deliveryCharges = DeliveryCharges::first();
        return view('admin.delivery.delivery_charges', compact('deliveryCharges'));
    }

    public function viewDeliveryChargesUpdate(Request $request){
        $where = array('id' => $request->id);
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }
        $data = array(
            'charges' => $request->charges,
            'status' => $status,
        );

        $update = DeliveryCharges::where($where)->update($data);

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
}
