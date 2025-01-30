<?php

namespace App\Http\Controllers;

use App\Models\TableDetail;
use Illuminate\Http\Request;
use App\Models\BookingTable;

use Illuminate\Support\Facades\Auth;


class TableDetailController extends Controller
{
   
    public function index()
    {
        //
        $detail= TableDetail::get();
        return view('admin.QrTable.bookedDetail',compact('detail'));
    }

    
    
   
   
    public function show(Request $request)
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
        
        
        $total = TableDetail::orWhere(function($query) use ($search){
            $query->orWhere('book_table_id' , 'like' , '%'. $search.'%');
           
        })->count();

        $details = TableDetail::orWhere(function($query) use ($search){
            $query->orWhere('book_table_id' , 'like' , '%'. $search.'%');
            
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)
            ->get();
        $i = 1 + $ofset;
        $data = [];
$tablename = BookingTable::get();
$product = BookingTable::findOrFail($request->id);

        foreach ($details as $detail) {

            // $status = '<button class="statusVerifiedClick btn '. ($cate->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($cate->status == 1  ? '0' : '1' ).'" data-id="'. $cate->id .'">'.($cate->status == 1 ? "Active" : "De-Active" ).'</button>
            //            ';
            $data[] = array(
                
                // $detail->$product->name ,
                $detail->book_table_id ,
                $detail->start_date,
                $detail->end_date,
                $detail->end_time,
                $detail->start_time,
                $detail->area,
                $detail->table_num,
                $detail->first_name,
                $detail->last_name,
                  
                    // '<a href="'.url("admin/order-particular-details",$cate->id).'" class="btn btn-warning btn-sm"> Order Details </a>'
                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    
}
