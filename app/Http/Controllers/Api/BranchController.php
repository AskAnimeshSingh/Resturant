<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branches;

class BranchController extends Controller
{
    public function getBranches(){
        $branches = Branches::get();
        if (count($branches) > 0){
            return response()->json([
                'status' => true,
                'message' => 'Branches found!!',
                'data' => $branches
            ], 201);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'No branches found!!',
                'data' => null
            ], 401);
        }
    }
}
