<?php

namespace App\Http\Controllers\Kitchen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chef;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChefController extends Controller
{
    public function index()
    {
        return view('kitchen.chef.index');
    }

    public function addChef(Request $request)
    {
        // dd($request->all());
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'required',
            "email" => "required|email|max:128|unique:chefs",
            "phone" => "required|max:11|min:9|unique:chefs",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        }
        // $data = $request->validated();
        $chef = new Chef();
        $chef->first_name = $request->first_name;
        $chef->last_name = $request->last_name;


        if ($request->file('image') != "") {
            $favicon = uniqid(time()) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/chef/img/'), $favicon);
            $favicon = "/public/uploads/chef/img/" . $favicon;
        }
        // dd($favicon);
        $chef->image  = $favicon;
        $chef->email = $request->email;
        $chef->status = $request->status;
        $chef->phone = $request->phone;
        $chef->save();
        // return redirect()->back()->with('status','chef Added Successfully');

        if ($chef) {

            return response()->json(array('status' => true, 'msg' => "Successfully Added", 'location' => route('kitchen.chef')));
        } else {
            return response()->json(array('status' => false, 'msg' => "Something went wrong, please try again"));
        }
    }

    public function chefList()
    {
        return view('kitchen.chef.chef_list');
    }

    public function chefListAjax(Request $request)
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

        $total = Chef::orWhere('first_name', 'like', '%' . $search . '%')->count();
        $chef = Chef::orWhere('first_name', 'like', '%' . $search . '%')
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($chef as $chf) {
            $url = route('kitchen.edit.chef', ['id' => $chf->id]);
            $status = '<button class="statusVerifiedClick btn ' . ($chf->status == '0' ? "btn-success btn-sm" : "btn-danger btn-sm") . '  " data-status="' . ($chf->status == '0'  ? '1' : '0') . '" data-id="' . $chf->id . '">' . ($chf->status == '0' ? "Active" : "Inactive") . '</button>
                     ';
            $data[] = array(
                $i++,
                $chf->first_name,
                $chf->last_name,
                '<img class="img-fluid" src="' . url($chf->image) . '" width="70px;">',
                $chf->email,
                $chf->phone,
                $status,
                '
              <a  href=' . $url . ' class="editchef btn btn-info btn-sm "  data-id="' . $chf->id . '"> Edit</a> |  <a href="#" class="btn btn-danger btn-sm delete_chef" data-id="' . $chf->id . '">Delete</a>',

            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function editChef($id)
    {
        $chef = Chef::find($id);

        return view('kitchen.chef.edit_chef', compact('chef'));
    }

    public function updateChef(Request $request)
    {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'nullable',
            "email" => 'required|email|max:128|unique:chefs,email,' . $request->id,
            "phone" => 'required|max:11|min:9|unique:chefs,phone,' . $request->id,
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('status' => false, 'msg' => $validator->errors()->first()));
            exit;
        }
        // $data = $request->validated();
        $chef = Chef::find($request->id);
        $chef->first_name = $request->first_name;
        $chef->last_name = $request->last_name;


        if ($request->file('image') != "") {
            $favicon = uniqid(time()) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/chef/img/'), $favicon);
            $favicon = "/public/uploads/chef/img/" . $favicon;
            $chef->image  = $favicon;
        }
        // dd($favicon);

        $chef->email = $request->email;
        $chef->status = $request->status;
        $chef->phone = $request->phone;
        $chef->update();
        // return redirect()->back()->with('status','chef Added Successfully');

        if ($chef) {

            return response()->json(array('status' => true, 'msg' => "Successfully Updated", 'location' => route('kitchen.list.chef')));
        } else {
            return response()->json(array('status' => false, 'msg' => "Something went wrong, please try again"));
        }
    }

    public function deleteChef(Request $request)
    {
        $chef = Chef::find($request->id);
        if($chef)
        {
            $chef->delete();
            return response()->json(array('status' => true, 'msg' => "Successfully Deleted"));
            exit;
        }
        else
        {
            return response()->json(array('status' => false, 'msg' => "Something went wrong, please try again"));
        }
    }

    public function statusChef(Request $request)
    {
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = Chef::where($where)->update($data);

        if($update)
        {
            return response()->json(array('status' => true,'msg' => "Status Updated Successfully!"));
            exit;
        }
        else
        {
            return response()->json(array('status' => false,'msg' => "Error Occured, please try again"));
            exit;
        }
    }
}
