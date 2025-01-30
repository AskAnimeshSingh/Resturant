<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildCategory;
use App\Models\Products;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Common extends Controller
{
    /**
     * @param $category
     * @method use for get sub Category help of Category
     */
    public function getSubCategory(Request $request)
    {
        $data = SubCategory::where(['cate_id' => $request->cateid])->get();
        
        return response()->json(['data' => $data]);
    }

    /**
     * @param $sub_category
     * @method use for get child category help of sub_category
     */
    public function getChildCategory(Request $request)
    {
        $data = ChildCategory::where(['sub_cate_id' => $request->cateid])->get();
        
        return response()->json(['data' => $data]);
    }

    /**
     * @param Request $request
     */
    public function cal_price(Request $request)
    {
        $ids = explode(",", $request->id);
        $price = Products::whereIn('id' , $ids)->sum(DB::raw('price'));
        return response()->json(['price' => $price]);
    }
}
