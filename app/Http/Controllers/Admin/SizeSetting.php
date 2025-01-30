<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SizeSetting extends Controller
{
    /**
     * @return view index
     */
    public function index()
    {
        return view('admin.size_setting.index');
    }

    /**
     * @method use for show coupon ajax list
     */
    public function sizeAjaxList(Request $request)
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

        $total = Size::select("sizes.*")
        ->orWhere(function($query) use ($search){
            $query->orWhere('size' , 'like' , '%'. $search.'%');
        })->count();

        $sizes = Size::select("sizes.*")
        ->orWhere(function($query) use ($search){
            $query->orWhere('size' , 'like' , '%'. $search.'%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($sizes as $cate) {

            $status = '<button class="SizeStatusVerifiedClick btn '. ($cate->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($cate->status == 1  ? '0' : '1' ).'" data-id="'. $cate->id .'">'.($cate->status == 1 ? "Active" : "De-Active" ).'</button>
                       ';
            $data[] = array(
                $i++,
                $cate->size,
                $status,
                '<a href="javascript:void(0)" class="editSize btn btn-info btn-sm" data-id="'.$cate->id.'" , data-size="'.$cate->size.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm size-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',
                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @return view blog create form
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * @param Request $request
     * @method use for store new blogs
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'size'          => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data   = new Size();
            $input['size']  = $request->size;
            $save = $data->fill($input)->save();
        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Size created successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occour try again later"]);
            exit;
        }
    }

    /**
     * @return view Edit form
     */
    public function edit($id)
    {
        $blogs = Size::findOrFail($id);
        return view('admin.blog.edit' , compact('blogs'));
    }

    /**
     * @param Request $request
     * @method use for update blog
     */
    public function update(Request $request)
    {
        $rules = [
            'size'          => 'required',
        ];
        $validator = Validator::make($request->all() ,$rules);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data       = Size::findOrFail($request->sizeid);
            $data->size = $request->size;
            $save = $data->update();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Size Updated successfully"]);
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

        $update = Size::where($where)->update($data);

        if($update)
        {
            return response()->json(array('status' => true,'msg' => "Successfully Updated!"));
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
            $del = Size::where($where)->delete();
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
