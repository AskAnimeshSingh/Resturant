<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeSetting extends Controller
{
    /**
     * @return view index
     */
    public function index()
    {
        return view('admin.type_setting.index');
    }

    /**
     * @method use for show coupon ajax list
     */
    public function typeAjaxList(Request $request)
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

        $total = Type::select("types.*")
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('type', 'like', '%' . $search . '%');
            })->count();

        $sizes = Type::select("types.*")
        ->orWhere(function ($query) use ($search) {
            $query->orWhere('type', 'like', '%' . $search . '%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($sizes as $cate) {

            $status = '<button class="typeStatusVerifiedClick btn ' . ($cate->status == 1 ? "btn-success" : "btn-danger") . '  " data-status="' . ($cate->status == 1  ? '0' : '1') . '" data-id="' . $cate->id . '">' . ($cate->status == 1 ? "Active" : "De-Active") . '</button>
                       ';
            $data[] = array(
                $i++,
                $cate->type,
                $status,
                '<a href="javascript:void(0)" class="editType btn btn-info btn-sm" data-id="' . $cate->id . '" , data-type="' . $cate->type . '"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm type-delete" data-id="' . $cate->id . '"><i class="fa fa-trash"></i></a>',
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
        $validator = Validator::make($request->all(), [
            'type'          => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data   = new Type();
            $input['type']  = $request->type;
            $save = $data->fill($input)->save();
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Type created successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour try again later"]);
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
            'type'          => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data       = Type::findOrFail($request->typeid);
            $data->type = $request->type;
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Type Update successfully"]);
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

        $update = Type::where($where)->update($data);

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
            $del = Type::where($where)->delete();
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
