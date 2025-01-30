<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Table as ModelsTable;
use App\Models\TableStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Table extends Controller
{
    
     /**
     * @return view group index
     */
    public function index()
    {
        $branches   = Branches::where(['status' => 1])->get();
        return view('admin.table.index' , compact('branches'));
    }

    /**
     * @method use for show coupon ajax list
     */
    public function tableAjaxList(Request $request)
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

        $total = TableStore::select("tables.*" , 'branches.name as branch_name')
        ->join('branches' , 'tables.branch_id' , '=' , 'branches.id')
        ->orWhere(function($query) use ($search){
            $query->orWhere('tables.name' , 'like' , '%'. $search.'%');
            $query->orWhere('branches.name' , 'like' , '%'. $search.'%');
        })->count();

        $groups = TableStore::select("tables.*" , 'branches.name as branch_name')
        ->join('branches' , 'tables.branch_id' , '=' , 'branches.id')
        ->orWhere(function($query) use ($search){
            $query->orWhere('tables.name' , 'like' , '%'. $search.'%');
            $query->orWhere('branches.name' , 'like' , '%'. $search.'%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $cate) {
            $data[] = array(
                $i++,
                $cate->name,
                $cate->guest_capacity,
                $cate->branch_name,
                $cate->status,
                '<a  href="javascript:void(0)" class="editTable btn btn-info btn-sm "  data-id="'.$cate->id.'" data-name="'.$cate->name.'" data-capacity="'.$cate->guest_capacity.'" data-branch_id="'.$cate->branch_id.'" data-status="'.$cate->status.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm table-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',
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
            'branch'        => 'required',
            'capacity'      => 'required|numeric',
            'status'        => 'required',
        ]);
        if($validator->fails()) 
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data                   = new TableStore();
            $input['name']          = $request->name;
            $input['branch_id']     = $request->branch;
            $input['guest_capacity']= $request->capacity;
            $input['status']        = $request->status;
            $save   = $data->fill($input)->save(); 
        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Table created successfully"]);
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
            'branch'        => 'required',
            'capacity'      => 'required|numeric',
            'status'        => 'required',
        ];
        $validator = Validator::make($request->all() ,$rules); 

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data = TableStore::findOrFail($request->table_id);
            $data->name             = $request->name;
            $data->branch_id        = $request->branch;
            $data->guest_capacity   = $request->capacity;
            $data->status           = $request->status;
            $save = $data->update();
        }

        if($save) 
        {
            return response()->json(['status' => true , 'msg' => "Table Update successfully"]);
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

        $update = TableStore::where($where)->update($data);

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
            $del = TableStore::where($where)->delete();
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
