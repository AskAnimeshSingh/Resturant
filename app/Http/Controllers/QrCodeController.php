<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QrCodeController extends Controller
{
    //

    public function index()
    {
      return view('admin.QrTable.qrtable');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name'  => 'required',
            'qr_code'     => 'required',
        ]); 

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
           

            $data = new BookingTable();
            $input['name'] = $request->name;
            $input['qr_code'] = $request->qr_code;
           

            $save = $data->fill($input)->save();
        }

        if($save) 
        {
            return response()->json(['status' => true , 'msg' => "Category save successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit; 
        }
    }

    public function qrAjaxList(Request $request)
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

        $total = BookingTable::orWhere('name' , 'like' , '%'. $search.'%')->count();
        $category = BookingTable::orWhere('name' , 'like' , '%'. $search.'%')
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($category as $cate) {

           
            $data[] = array(
                $i++,
                $cate->name, 
                $cate->qr_code,
                '<a  href="#" class="editCategory btn btn-info btn-sm " data-name="'.$cate->name.'" data-qr_code="'.$cate->qr_code.'" data-id="'.$cate->id.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm category-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',

                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

 
    public function update(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name'  => 'required',
            'qr_code'  => 'required',
        ]); 

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data = BookingTable::findOrFail($request->id);
            $data->name = $request->name;
            $data->qr_code = $request->qr_code;
            $save = $data->update();

        }

        if($save) 
        {
            return response()->json(['status' => true , 'msg' => " update successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit; 
        }
    }

    public function destroy(Request $request)
    {
        try{
                $where = array('id' => $request->id);
                $del =BookingTable::where($where)->delete();
                
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
