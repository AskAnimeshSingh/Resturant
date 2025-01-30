<?php

namespace App\Helpers;

use App\Http\Controllers\Admin\Product;
use App\Models\IngredientStocks;
use App\Models\Privilege;
use App\Models\Products;
use App\Models\StockInventry;
use App\Models\WebOrderProduct;

class MyHelper
{

    /**----------------------------------------------------------------------------------------------------------------------
     * @package $userid
     *
     * @Method use to get the user privilages details by passing the user id from privilages table / created by @loveleshSingh 27/08/2019
     */

    public static function getUserPrivilages($userid = null, $module = null, $submodule = null)
    {

        if ($userid === 1) {
            $results = [
                '0' => [
                    'access' => 'Write',
                    'add' => 'on',
                    'edit' => 'on',
                    'delete' => 'on'
                ]
            ];
            $data = [
                'submodule' => '',
                'result' => $results
            ];

            return $data;
        }

        if ($module != null && $userid != null && $submodule === null) {
            $result = Privilege::where(['staff_id' => $userid, 'module' => $module, 'status' => 1])->get();
            if ($result && $result->count() > 0) {
                return $module;
            }
        } elseif ($module != null && $userid != null && $submodule != null) {
            $result1 = Privilege::where(['staff_id' => $userid, 'module' => $module, 'submodule' => $submodule, 'status' => 1])->get();
            if ($result1 && $result1->count() > 0) {
                $data = [
                    'submodule' => $submodule,
                    'result' => $result1
                ];
                return json_decode(json_encode($data), true);
            }
        }
    }


    /**----------------------------------------------------------------------------------------------------------------------
     * @package $userid
     *
     * @Method use to get the user privilages details by passing the user id from privilages table / created by @loveleshSingh 27/08/2019
     */

    public static function checkUserPrivilages($userid = null, $module = null, $submodule = null)
    {

        if ($userid == 1) {
            return 1;
        } else {
            if ($userid != null && $userid === null && $submodule === null) {

                $results = Privilege::where(['staff_id' => $userid, 'status' => 1])->get();
            } elseif ($module != null && $userid != null && $submodule === null) {

                $result = Privilege::where(['staff_id' => $userid, 'module' => $module, 'status' => 1])->get();
                if ($result->count() > 0) {
                    return true;
                }
            } elseif ($module != null && $userid != null && $submodule != null) {
                $result1 = Privilege::where(['staff_id' => $userid, 'module' => $module, 'submodule' => $submodule, 'status' => 1])->get();

                if ($result1->count() > 0) {
                    return true;
                }
            }
        }
    }

    public static function getIngredientStock($ingredientId, $branchId)
    {

        $ingredient = IngredientStocks::where(['ingredient_id' => $ingredientId, 'branch_id' => $branchId])->sum('stock');
        if (!empty($ingredient)) {
            $stock = $ingredient;
        } else {
            $stock = 0;
        }
        return $stock;
    }

    public static function getFoodStock($foodId, $branchId)
    {

        $ingredient = StockInventry::where(['product_id' => $foodId, 'branch_id' => $branchId])->sum('stock');
        if (!empty($ingredient)) {
            $stock = $ingredient;
        } else {
            $stock = 0;
        }
        return $stock;
    }

    // public static function getProductByOrderId($order_id){
    //     $products_data = [];
    //     $product_id = WebOrderProduct::where('order_id',$order_id)->pluck('product_id')->toArray();



    //     $product_name = Products::whereIn('id',$product_id)->pluck('product_name')->toArray();
    //     dd($product_name);


    //      return $products_data;

    // }
}
