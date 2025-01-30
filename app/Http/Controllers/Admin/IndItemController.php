<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\IndGrp;
use App\Models\IndItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndItemController extends Controller
{
    /**
     * @return view group index
     */
    public function index()
    {
        $groups = IndGrp::where(['status' => 1])->get();
        return view('admin.ingredient_item.index', compact('groups'));
    }

    /**
     * @method use for show coupon ajax list
     */
    public function ind_item_AjaxList(Request $request)
    {
        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

        $total = IndItem::select("ind_items.*", 'ind_grps.name as grp_name')
            ->join('ind_grps', 'ind_items.ind_grp_id', '=', 'ind_grps.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('ind_items.name', 'like', '%' . $search . '%');
            })->count();

        $groups = IndItem::select("ind_items.*", 'ind_grps.name as grp_name')
            ->join('ind_grps', 'ind_items.ind_grp_id', '=', 'ind_grps.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('ind_items.name', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $cate) {
            $status = '<button class="statusVerifiedClick btn ' . ($cate->status == 1 ? "btn-success btn-sm" : "btn-danger btn-sm") . '  " data-status="' . ($cate->status == 1 ? '0' : '1') . '" data-id="' . $cate->id . '">' . ($cate->status == 1 ? "Active" : "De-Active") . '</button>';
            $data[] = array(
                $i++,
                $cate->name,
                $cate->grp_name,
                $status,
                '<a  href="javascript:void(0)" class="editIndGrp btn btn-info btn-sm "  data-id="' . $cate->id . '" data-name="' . $cate->name . '" data-unit="' . $cate->unit . '" data-group="' . $cate->ind_grp_id . '"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm ind-grp-delete" data-id="' . $cate->id . '"><i class="fa fa-trash"></i></a>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for store new blogs
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'group' => 'required',
            'unit' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = new IndItem();
            $input['name'] = $request->name;
            $input['unit'] = $request->unit;
            $input['ind_grp_id'] = $request->group;
            $save = $data->fill($input)->save();
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Ingredient item created successfully"]);
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
        }
    }

    /**
     * @param Request $request
     * @method use for update blog
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'group' => 'required',
            'unit' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = IndItem::findOrFail($request->edit_ind_item);
            $data->name = $request->name;
            $data->ind_grp_id = $request->group;
            $data->unit = $request->unit;
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Update ingredient item update successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occurs !! Try again later"]);
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

        $update = IndItem::where($where)->update($data);

        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for delete sub Category
     */
    public function destroy(Request $request)
    {
        try {
            $where = array('id' => $request->id);
            $del = IndItem::where($where)->delete();
            if ($del) {
                return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
                exit;
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
                exit;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }
}
