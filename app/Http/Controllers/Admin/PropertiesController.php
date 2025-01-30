<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Propertie;
use App\Models\PropertiesItems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PropertiesController extends Controller
{
    /**
     * @return view group index
     */
    public function index()
    {
        return view('admin.properties.index');
    }

    /**
     * @method use for show coupon ajax list
     */
    public function propertiesAjaxList(Request $request)
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

        $total = Propertie::orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
        })->count();

        $groups = Propertie::orWhere(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $val) {

            $status = '<button class="statusVerifiedClick btn btn-sm ' . ($val->status == 1 ? "btn-success" : "btn-danger") . '  " data-status="' . ($val->status == 1 ? '0' : '1') . '" data-id="' . $val->id . '">' . ($val->status == 1 ? "Active" : "De-Active") . '</button>
                       ';
            $data[] = array(
                $i++,
                $val->name,
                $val->position,
                $status,
                '<a href="' . route('admin.properties.item.index', $val->id) . '" class="btn btn-danger btn-sm" data-id="' . $val->id . '"><i class="fa fa-plus"></i> Add Items</a>
                <a href="javascript:void(0)" class="editPro btn btn-info btn-sm "  data-id="' . $val->id . '" data-name="' . $val->name . '"  data-posid  ="'. $val->position .'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm properties-delete" data-id="' . $val->id . '"><i class="fa fa-trash"></i></a>',
                    $val->position,
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
            'position' => 'required|unique:properties,position',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        } else {
            $data = new Propertie();
            $data->name = $request->name;
            $data->position = $request->position;
            $data->save();
        }
        if ($data) {
            return response()->json(['status' => true, 'msg' => "Properties created successfully"]);
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
            'position' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = Propertie::findOrFail($request->properties_id);

            if ($data->position < $request->position) {
                DB::table('properties')
                    ->where('id', '!=', $request->properties_id)
                    ->where('position', '>=', $data->position)
                    ->where('position', '<=', $request->position)
                    ->update(['position' => DB::raw('position - 1')]);
            }
            elseif($data->position > $request->position){
                DB::table('properties')
                    ->where('id', '!=', $request->properties_id)
                    ->where('position', '<=', $data->position)
                    ->where('position', '>=', $request->position)
                    ->update(['position' => DB::raw('position + 1')]);
            }


            $data->name = $request->name;
            $data->position = $request->position;
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Properties Update successfully"]);
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

        $update = Propertie::where($where)->update($data);

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
            $del = Propertie::where($where)->delete();
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

    /**
     * @return view group index
     */
    public function propertyItems($id)
    {
        return view('admin.properties-items.index', compact('id'));
    }

    public function propertiesItemAjaxList($id)
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

        $total = PropertiesItems::where('properties_id', $id)->where(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
        })->count();

        $groups = PropertiesItems::where('properties_id', $id)
            ->where(function ($query) use ($search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $val) {

            $status = '<button class="statusVerifiedClick btn btn-sm ' . ($val->status == 1 ? "btn-success" : "btn-danger") . '  " data-status="' . ($val->status == 1 ? '0' : '1') . '" data-id="' . $val->id . '">' . ($val->status == 1 ? "Active" : "De-Active") . '</button>
                       ';
            $data[] = array(
                $i++,
                $val->name,
                $val->price,
                $status,
                '<a href="javascript:void(0)" class="editPro btn btn-info btn-sm "  data-id="' . $val->id . '" data-name="' . $val->name . '" data-price="' . $val->price . '"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm properties-delete" data-id="' . $val->id . '"><i class="fa fa-trash"></i></a>',
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
    public function propertyItemStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        } else {
            $data = new PropertiesItems();
            $data->name = $request->name;
            $data->price = $request->price;
            $data->properties_id = $request->id;
            $data->save();
        }
        if ($data) {
            return response()->json(['status' => true, 'msg' => "Properties item created successfully"]);
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
        }
    }

    /**
     * @param Request $request
     * @method use for delete sub Category
     */
    public function itemDestroy(Request $request)
    {
        try {
            $where = array('id' => $request->id);
            $del = PropertiesItems::where($where)->delete();
            if ($del) {
                return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }

    /**
     * @param $coupon_id
     * @method use for Request $request
     */
    public function itemStatusUpdate(Request $request)
    {
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = PropertiesItems::where($where)->update($data);

        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
        }
    }

    /**
     * @param Request $request
     * @method use for update blog
     */
    public function itemUpdate(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = PropertiesItems::findOrFail($request->properties_id);
            $data->name = $request->name;
            $data->price = $request->price;
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Properties Item Update successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }
}
