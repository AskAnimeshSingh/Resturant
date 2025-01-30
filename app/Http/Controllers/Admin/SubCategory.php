<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory as ModelsSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SubCategory extends Controller
{
    /**
     * @return view sub category index
     */
    public function index()
    {
        $category = Category::where(['status' => 1])->get();
        return view('admin.sub_category.index', compact('category'));
    }

    /**
     * @param Request $request
     * @method use for store sub category
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:categories,id',
            'sub_category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            if ($request->file('image') != "") {
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/sub_category'), $favicon);
                $favicon = "/public/assets/admin/assets/img/sub_category/" . $favicon;
            } else {
                $favicon = '/public/assets/admin/assets/img/default_cate.jpeg';
            }

            $data = new ModelsSubCategory();
            $input['name'] = $request->sub_category;
            $input['cate_id'] = $request->category;
            $input['image'] = $favicon;

            $save = $data->fill($input)->save();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => 'Sub Category save successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occour Try again later"]);
            exit;
        }
    }

    /**
     * @method use for show sub category list ajax
     */
    public function SubCategoryAjaxList(Request $request)
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

        $total = ModelsSubCategory::select("sub_categories.*", "categories.cate_name")
            ->join("categories", "sub_categories.cate_id", "=", "categories.id")
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('cate_name', 'like', '%' . $search . '%');
                $query->orWhere('name', 'like', '%' . $search . '%');
            })
            ->count();

        $sub_category = ModelsSubCategory::select("sub_categories.*", "categories.cate_name")
            ->join("categories", "sub_categories.cate_id", "=", "categories.id")
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('cate_name', 'like', '%' . $search . '%');
                $query->orWhere('name', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($sub_category as $cate) {

            $status = '<button class="statusVerifiedClick btn ' . ($cate->status == 1 ? "btn-success btn-sm" : "btn-danger btn-sm") . '  " data-status="' . ($cate->status == 1 ? '0' : '1') . '" data-id="' . $cate->id . '">' . ($cate->status == 1 ? "Active" : "De-Active") . '</button>
                       ';
            $data[] = array(
                $i++,
                $cate->name,
                $cate->cate_name,
                '<img class="img-fluid" src="' . url($cate->image ? $cate->image : 'public/assets/admin/assets/img/default_cate.jpeg') . '" style="width:50%;">',
                $status,
                '<a  href="#" class="editCategory btn btn-info btn-sm " data-name="' . $cate->name . '" data-cate_id="' . $cate->cate_id . '" data-img="' . $cate->image . '" data-id="' . $cate->id . '"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm category-delete" data-id="' . $cate->id . '"><i class="fa fa-trash"></i></a>',

            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * @param Request $request
     * @method use for update sub category
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:categories,id',
            'sub_category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            $data = ModelsSubCategory::findOrFail($request->cateid);
            if ($request->file('image') != "") {
                File::delete(public_path('../' . $request->oldimage));

                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/sub_category'), $favicon);
                $favicon = "/public/assets/admin/assets/img/sub_category/" . $favicon;
                $data->image = $favicon;

            }

            $data->cate_id = $request->category;
            $data->name = $request->sub_category;

            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "Sub Category Update successfully"]);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for status update
     */
    public function status(Request $request)
    {
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = ModelsSubCategory::where($where)->update($data);

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
            $cate = ModelsSubCategory::find($request->id);
            $del = ModelsSubCategory::where($where)->delete();
            File::delete(public_path('../' . $cate->img));

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
