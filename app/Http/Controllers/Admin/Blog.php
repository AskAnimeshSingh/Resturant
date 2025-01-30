<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductAddOn;

class Blog extends Controller
{
    /**
     * @return view blog
     */
    public function index()
    {
        return view('admin.blog.index');
    }

    /**
     * @method use for show coupon ajax list
     */
    public function blogAjaxList(Request $request)
    {
        if(isset($_GET['search']['value'])){
            $search = $_GET['search']['value'];
        }
        else{
            $search = '';
        }
        if(isset($_GET['length'])){
            $limit = $_GET['length'];
        }
        else{
            $limit = 10;
        }

        if(isset($_GET['start'])){
            $ofset = $_GET['start'];
        }
        else{
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

        $total = Blogs::select("blogs.*" , "admins.fname" , "admins.lname")
        ->join("admins" , "blogs.created_by_id" , "=" , "admins.id")
        ->orWhere(function($query) use ($search){
            $query->orWhere('lname' , 'like' , '%'. $search.'%');
            $query->orWhere('fname' , 'like' , '%'. $search.'%');
        })->count();

        $blogs = Blogs::select("blogs.*" , "admins.fname" , "admins.lname")
        ->join("admins" , "blogs.created_by_id" , "=" , "admins.id")
        ->orWhere(function($query) use ($search){
            $query->orWhere('lname' , 'like' , '%'. $search.'%');
            $query->orWhere('fname' , 'like' , '%'. $search.'%');
        })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];

        foreach ($blogs as $cate) {

            $status = '<button class="statusVerifiedClick btn '. ($cate->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($cate->status == 1  ? '0' : '1' ).'" data-id="'. $cate->id .'">'.($cate->status == 1 ? "Active" : "De-Active" ).'</button>
                       ';
            $data[] = array(
                $i++,
                $cate->name,
                '<img class="rounded" src="'.url($cate->image ?  $cate->image : 'public/assets/admin/assets/img/default_cate.jpeg').'" style="height:30px;">',
                '<details><p>'.$cate->description.'</p></details>',
                $cate->fname . ' ' . $cate->lname ,
                date('d-m-Y' , strtotime($cate->created_date)),
                $status,
                '<a  href="'.url('admin/blog/edit/'.$cate->id).'" class="editOffer btn btn-info btn-sm "> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm blog-delete" data-id="'.$cate->id .'"><i class="fa fa-trash"></i></a>',
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
        $validator = Validator::make($request->all() , [
            'name'          => 'required',
            'description'   => 'required',
            'image'         => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            if ($request->file('image') != "") {
                File::delete(public_path('../'.$request->oldimage));
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/blog'), $favicon);
                $favicon = "/public/assets/admin/assets/img/blog/" . $favicon;

            } else {
                $favicon = '/public/assets/admin/assets/img/default_cate.jpeg';
            }

            $data                   = new Blogs();
            $input['name']          = $request->name;
            $input['description']   = $request->description;
            $input['image']         = $favicon;
            $input['created_date']  = date('Y-m-d');
            $input['created_by_id'] = Auth::guard('admin')->user()->id;

            $save   = $data->fill($input)->save();
        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Blog created successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occour try again later"]);
            exit;
        }
    }

    /**
     * @return view Edit form
     */
    public function edit($id)
    {
        $blogs = Blogs::findOrFail($id);
        return view('admin.blog.edit' , compact('blogs'));
    }

    /**
     * @param Request $request
     * @method use for update blog
     */
    public function update(Request $request)
    {
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
        ];
        $validator = Validator::make($request->all() ,$rules);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {
            $data = Blogs::findOrFail($request->cateid);
            if ($request->file('image') != "") {
                File::delete(public_path('../'.$request->oldimage));
                $favicon = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/blog'), $favicon);
                $favicon = "/public/assets/admin/assets/img/blog/" . $favicon;
                $data->image  = $favicon;

            }

            $data->name         = $request->name;
            $data->description  = $request->description;

            $save = $data->update();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "Blogs Update successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
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

        $update = Blogs::where($where)->update($data);

        if($update)
        {
            return response()->json(array('status' => true,'msg' => "Successfully Updated !"));
            exit;
        }
        else
        {
            return response()->json(array('status' => false,'msg' => "Error Occured, please try again"));
            exit;
        }
    }

    /**
     * @param Request $request
     * @method use for delete sub Category
     */
    public function destroy(Request $request)
    {
        try{
            $where = array('id' => $request->id);
            $cate = Blogs::find($request->id);
            $del = Blogs::where($where)->delete();
        if ($del) {
            return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
        }
        catch (\Illuminate\Database\QueryException $e ) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }

}
