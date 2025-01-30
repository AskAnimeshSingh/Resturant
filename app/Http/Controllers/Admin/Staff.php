<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branches;
use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Staff extends Controller
{
    /**
     * @return view group index
     */
    public function index()
    {
        $branches = Branches::get();
        return view('admin.staff.index', compact('branches'));
    }

    /**
     * @method use for show coupon ajax list
     */
    public function staffAjaxList(Request $request)
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

        $total = Admin::select("admins.*", 'branches.name')
            ->leftjoin('branches', 'admins.branch_id', '=', 'branches.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('fname', 'like', '%' . $search . '%');
            })->count();

        $groups = Admin::select("admins.*", 'branches.name')
            ->leftjoin('branches', 'admins.branch_id', '=', 'branches.id')
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('fname', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($groups as $cate) {
            $status = '<button class="statusVerifiedClick btn ' . ($cate->status == 1 ? "btn-success" : "btn-danger") . '  " data-status="' . ($cate->status == 1  ? '0' : '1') . '" data-id="' . $cate->id . '">' . ($cate->status == 1 ? "Active" : "De-Active") . '</button>';
            $data[] = array(
                $i++,
                '<img class="rounded" src="' . url($cate->img ?  $cate->img : 'public/assets/admin/assets/img/default_cate.jpeg') . '" style="height:50px;">',
                $cate->fname,
                $cate->phone,
                $cate->name,
                $cate->type,
                $status,
                '<a  href="javascript:void(0)" class="editUser btn btn-info btn-sm "  data-id="' . $cate->id . '" data-name="' . $cate->fname . '" data-phone="' . $cate->phone . '" data-branch="' . $cate->branch_id . '" data-type="' . $cate->type . '" data-email="' . $cate->email . '" data-img="' . $cate->img . '"> <i class="fa fa-edit"></i></a> |
                <a href="' . url('admin/permission_allow/' . $cate->id) . '" class="btn btn-sm  btn-primary"><i class="fa fa-plus"></i></a> | 
                    <a href="#" class="btn btn-danger btn-sm user-delete" data-id="' . $cate->id . '"><i class="fa fa-trash"></i></a>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
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
            'type'              => 'required',
            'name'              => 'required',
            'email'             => 'required|email',
            'phone'             => 'required',
            'password'          => 'min:4',
            'password_confirmation' => 'required_with:password|same:password|min:4'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            if ($request->file('image') != "") {
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/admin'), $favicon);
                $favicon = "/public/assets/admin/assets/img/admin/" . $favicon;
            } else {
                $favicon = '/public/assets/admin/assets/img/default_cate.jpeg';
            }

            $data                   = new Admin();
            $input['fname']         = $request->name;
            $input['lname']         = $request->name;
            $input['email']         = $request->email;
            $input['phone']         = $request->phone;
            $input['password']      = Hash::make($request->password);
            $input['img']           = $favicon;
            $input['type']          = $request->type;
            $input['branch_id']     = $request->branch;
            $save   = $data->fill($input)->save();
        }
        if ($save) {
            return response()->json(['status' => true, 'msg' => "Admin/User created successfully"]);
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
        if ($request->password != "") {
            $rules = [
                'password'          => 'min:4',
                'password_confirmation' => 'required_with:password|same:password|min:4'
            ];
        }
        $rules = [
            'type'              => 'required',
            'name'              => 'required',
            'email'             => 'required|email',
            'phone'             => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            if ($request->file('image') != "") {
                File::delete(public_path('../' . $request->oldimage));
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/admin'), $favicon);
                $favicon = "/public/assets/admin/assets/img/admin/" . $favicon;
            }
            $data = Admin::findOrFail($request->edit_user_id);
            $data->fname         = $request->name;
            $data->lname         = $request->name;
            $data->email         = $request->email;
            $data->phone         = $request->phone;
            $data->password      = Hash::make($request->password);
            $data->type          = $request->type;
            $data->branch_id     = $request->branch;
            $save = $data->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => "User Update successfully"]);
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

        $update = Admin::where($where)->update($data);

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
            $del = Admin::where($where)->delete();
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
     * @method use for staff permission view
     */
    public function permission_allow(Request $request)
    {
        $id = $request->staff_id;
        return view('admin.staff.permission', compact('id'));
    }

    /**
     * method use for m
     */
    public function save_permission(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'moduleNo' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
                exit;
            } else {

                Privilege::where('staff_id', $data['staff_id'])->delete();

                foreach ($data['moduleNo'] as $key => $items) {
                    if (isset($data['submodule' . $items])) {
                        foreach ($data['submodule' . $items] as $key1 => $items2) {
                            foreach ($data['access' . $items . $items2] as $key2 => $items3) {
                                if (isset($items3)) {
                                    //                                    echo $items3;
                                    if (isset($data['add' . $items . $items2])) {
                                        $add = $data['add' . $items . $items2];
                                    } else {
                                        $add = ['0' => ''];
                                    }
                                    if (isset($data['edit' . $items . $items2])) {
                                        $edit = $data['edit' . $items . $items2];
                                    } else {
                                        $edit = ['0' => ''];
                                    }
                                    if (isset($data['delete' . $items . $items2])) {
                                        $delete = $data['delete' . $items . $items2];
                                    } else {
                                        $delete = ['0' => ''];
                                    }


                                    if ($items3 === 'Read' || $items3 === 'Write') {
                                        $addPrivilage = new Privilege();
                                        $addPrivilage->staff_id = $data['staff_id'];
                                        $addPrivilage->module   = $items;
                                        $addPrivilage->submodule = $items2;
                                        $addPrivilage->access   = $items3;
                                        $addPrivilage->add      = $add[0];
                                        $addPrivilage->edit     = $edit[0];
                                        $addPrivilage->delete   = $delete[0];
                                        $addPrivilage->status   = 1;
                                        // $addPrivilage->created_by = Auth::guard('admin')->user()->id;
                                        $result = Privilege::where(['module' => $items, 'submodule' => $items2, 'staff_id' => $data['staff_id']])->get();
                                        if ($result->count() > 0) {
                                            $updateData = [
                                                'access' => $items3,
                                                'add' => $add[0],
                                                'edit' => $edit[0],
                                                'delete' => $delete[0],
                                            ];
                                            $affected = Privilege::where(['module' => $items, 'submodule' => $items2, 'staff_id' => $data['staff_id']])->update($updateData);
                                        } else {
                                            $affected = $addPrivilage->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if (isset($affected)) {
                    // MyHelper::addToLog('Staff Details Added. !!!!!!' , Auth::guard('franchise')->user()->id , 'franchise');
                    return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
                    exit();
                } else {
                    return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
                    exit();
                }
            }
        }
    }
}
