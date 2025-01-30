<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use App\Models\General;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.settings.currencies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all() , [

            'currency'  => 'required',
            'code'  => 'required',
            'symbol'  => 'required',
            'rate'  => 'required',
            'allignment'  => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {

            $data = new Setting();
            $input['name'] = $request->currency;
            $input['currency'] = $request->code;
            $input['symbol'] = $request->symbol;
            $input['alignment'] = $request->allignment;
            $input['rate'] = $request->rate;
            // $input['status'] = $request->allignment;


            $save = $data->fill($input)->save();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "currency save successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all() , [
            'currency'  => 'required',
            'code'  => 'required',
            'symbol'  => 'required',
            'allignment'  => 'required',
            'rate'  => 'required',


        ]);

        if($validator->fails())
        {
            return response()->json(['status' => false , 'msg' => $validator->errors()->first()]);
            exit;
        }
        else
        {

            $data = Setting::findOrFail($request->setid);
            $data->name = $request->currency;
            $data->currency = $request->code;
            $data->symbol = $request->symbol;
            $data->alignment = $request->allignment;
            $data->rate = $request->rate;

            $save = $data->update();
        }

        if($save)
        {
            return response()->json(['status' => true , 'msg' => "currency updated successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error's Occurs !! Try again later"]);
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        try{
            $where = array('id' => $request->id);
            $set = Setting::find($request->id);
            $del = Setting::where($where)->delete();

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

    public function status(Request $request)
    {
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = Setting::where($where)->update($data);

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

    public function currencyAjaxList(Request $request)
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

        $total = Setting::orWhere('currency' , 'like' , '%'. $search.'%')->count();
        $setgory = Setting::orWhere('currency' , 'like' , '%'. $search.'%')
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder , $orderType)->get();
        $i = 1 + $ofset;
        $data = [];
        foreach ($setgory as $set) {

            $status = '<button class="statusVerifiedClick btn '. ($set->status == 1 ? "btn-success" : "btn-danger").'  " data-status="'.($set->status == 1  ? '0' : '1' ).'" data-id="'. $set->id .'">'.($set->status == 1 ? "Active" : "De-Active" ).'</button>
                       ';
            $data[] = array(
                $i++,
                $set->name,
                $set->currency,
                $set->symbol,
                $set->rate,
                $set->alignment,
                $status,
                '<a  href="#" class="editcurrency btn btn-info btn-sm " data-name="'.$set->name.'" data-currency="'.$set->currency.'" data-symbol="'.$set->symbol.'" data-rate="'.$set->rate.'" data-alignment="'.$set->alignment.'" data-id="'. $set->id .'" data-code="'.$set->code.'"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm currency-delete" data-id="'.$set->id .'"><i class="fa fa-trash"></i></a>',

                 );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] =  $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    //GENERAL SETTINGS

    public function general_index()
    {
      return view('admin.settings.generalsetting');
    }

    public function general_store(Request $request)
    {

        $validator = Validator::make($request->all() , [
            'name'          => 'required',
            'address'   => 'required',
            'phone'         => 'required',
            'back_logo_colo'     => 'required',
            'back_foot_colo'     => 'required',
            'text_colo'         => 'required',
            'image'         => 'required',
            'favicon'         => 'required',
            'tax'         => 'required',
            'discount'         => 'required',
            'bill_header'         => 'required',
            'bill_footer'         => 'required',
            'web_footer'         => 'required',
            'print_detail'         => 'required',
            'sound'         => 'required',
            'selection'         => 'required',
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

            if($request->file('image') != "") {
                File::delete(public_path('../'.$request->oldimage));
                $favicon2 = uniqid(time()) . '.' . $request->image->extension();
                $request->image->move(public_path('assets/admin/assets/img/setting'), $favicon2);
                $favicon2 = "/public/assets/admin/assets/img/setting/" . $favicon2;

            } else {
                $favicon2 = '/public/assets/admin/assets/img/default_cate.jpeg';
            }

            $data                   = new General();
            $input['name']          = $request->name;
            $input['address']   = $request->address;
            $input['phone']         = $request->phone;
            $input['back_logo_col']  = $request->back_logo_colo;
            $input['back_foot_col'] = $request->back_foot_colo;
            $input['currency_col'] = $request->text_colo;
            $input['logo'] = $favicon;
            $input['favicon'] = $favicon2;
            $input['tax'] = $request->tax+'-'+$request->taxval;
            $input['discount'] = $request->discount;
            $input['bill_head'] = $request->bill_header;
            $input['bill_foot'] = $request->bill_footer;
            $input['web_foot'] = $request->web_footer;
            $input['order_detail'] = $request->print_detail;
            $input['beep_sound'] = $request->sound;
            $input['show_table'] = $request->selection;
            $save   = $data->fill($input)->save();

        }
        if($save)
        {
            return response()->json(['status' => true , 'msg' => "General created successfully"]);
            exit;
        }
        else
        {
            return response()->json(['status' => false , 'msg' => "Error Occur try again later"]);
            exit;
        }
    }


}
