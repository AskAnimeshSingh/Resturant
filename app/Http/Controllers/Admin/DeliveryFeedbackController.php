<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRating;
use Illuminate\Http\Request;

class DeliveryFeedbackController extends Controller
{
    public function index()
    {
        $ratings = UserRating::select('user_ratings.*','products.product_name','users.name')
        ->join('products','products.id','=','user_ratings.product_id')
        ->join('users','users.id','=','user_ratings.user_id')
        ->get();
        return view('admin.delivery_feedback.index', compact('ratings'));
    }

    // public function indexList(Request $request)
    // {
    //     if(isset($_GET['search']['value'])){
    //         $search = $_GET['search']['value'];
    //     }
    //     else{
    //         $search = '';
    //     }
    //     if(isset($_GET['length'])){
    //         $limit = $_GET['length'];
    //     }
    //     else{
    //         $limit = 10;
    //     }

    //     if(isset($_GET['start'])){
    //         $ofset = $_GET['start'];
    //     }
    //     else{
    //         $ofset = 0;
    //     }

    //     $orderType = $_GET['order'][0]['dir'];
    //     $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

    //     $total = UserRating::select("user_ratings.*")
    //     ->orWhere(function($query) use ($search){
    //         $query->orWhere('user_ratings.user_id' , 'like' , '%'. $search.'%');
    //         $query->orWhere('user_ratings.product_id' , 'like' , '%'. $search.'%');
    //     })->count();

    //     $ratings = UserRating::select("user_ratings.*")
    //     ->orWhere(function($query) use ($search){
    //         $query->orWhere('user_ratings.user_id' , 'like' , '%'. $search.'%');
    //         $query->orWhere('user_ratings.product_id' , 'like' , '%'. $search.'%');
    //     })
    //         ->offset($ofset)->limit($limit)
    //         ->orderBy($nameOrder , $orderType)->get();
    //     $i = 1 + $ofset;
    //     $data = [];

    //     foreach ($ratings as $cate) {
    //         $data[] = array(
    //             $i++,
    //             $cate->user_id,
    //             $cate->product_id,
    //             $cate->rating,
    //             $cate->rating_message,
    //              );
    //     }
    //     $records['recordsTotal'] = $total;
    //     $records['recordsFiltered'] =  $total;
    //     $records['data'] = $data;
    //     echo json_encode($records);
    // }
}
