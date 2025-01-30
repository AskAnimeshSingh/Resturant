<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department as ModelsDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Department extends Controller
{
    
     /**
     * @return view group index
     */
    public function index()
    {
        return view('admin.dept.index');
    }

    /**
     * @method use for show coupon ajax list
     */
    public function commissionAjaxList(Request $request)
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

        $total = ModelsDepartment::orWhere(function($query) use ($search){
            $query->orWhere('name' , 'like' , '%'. $search.'%');
            $query->orWhere('commission' , 'like' , '%'. $search.'%');
        })->count();

        $groups = ModelsDepartment::orWhere(function($query) use ($search){
            $query->orWhere('name' , 'like' , '%'. $search.'%');
            $query->orWhere('commission' , 'like' , '%'. $search.'%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $cate) {

            $status = '<button class="statusVerifiedClick btn '. ($cate->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($cate->status == 1  ? '0' : '1' ).'" data-id="'. $cate->id .'">'.($cate->status == 1 ? "Active" : "De-Active" ).'</button>
                       ';
            $data[] = array(
                $i++,
                $cate->name,
                $cate->commission,
                $status,
                '<a  href="javascript:void(0)" class="editDept btn btn-info btn-sm "  data-id="'.$cate->id.'" data-name="'.$cate->name.'" data-commission="'.$cate->commission.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm dept-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',
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
            'name'          => 'required',
            'commission'    => 'required',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data                   = new ModelsDepartment();
            $input['name']          = $request->name;
            $input['commission']    = $request->commission;
            $save   = $data->fill($input)->save(); 
        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Commission created successfully"]);
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
        $rules = [
            'name'          => 'required',
            'commission'    => 'required',
        ];
        $validator = Validator::make($request->all() ,$rules); 

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data = ModelsDepartment::findOrFail($request->commission_id);
            $data->name         = $request->name;
            $data->commission   = $request->commission;
            $save = $data->update();
        }

        if($save) 
        {
            return response()->json(['status' => true , 'msg' => "Department Update successfully"]);
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

        $update = ModelsDepartment::where($where)->update($data);

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
            $del = ModelsDepartment::where($where)->delete();
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
