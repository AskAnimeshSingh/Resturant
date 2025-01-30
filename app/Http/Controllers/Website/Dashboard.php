<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\TableStore;
use App\Models\HomeDeliveryAddress;
use App\Models\PickupAddress;
use App\Models\BookingTable;
use Illuminate\Http\Request;
use App\Models\TableDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
  /**
   * @return view dashboard
   */

  public function index()
  {
    if (Auth::check()) {
      $homeAddress = HomeDeliveryAddress::where(['user_id' => Auth::user()->id])->first();
      $pickup      = PickupAddress::where(['user_id' => Auth::user()->id])->first();
    } else {
      $homeAddress = '';
      $pickup      = '';
    }

    $storeLocation = Admin::orderBy('id', 'desc')->first();
    $tablename     = BookingTable::get();
    return view('website.dashboard', compact('homeAddress', 'pickup', 'storeLocation', 'tablename'));
  }

  public function store(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'booking_table' => 'required',
      'start_dt' => 'required',
      'end_dt' => 'required',
      'start_time' => 'required',
      'end_time' => 'required',
      'area' => 'required',
      'cabin_num' => 'required',
      'first_name' => 'required',
      'last_name' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
      exit;
    } else {

      $data = new TableDetail();
      $input['book_table_id'] = $request->booking_table;
      $input['start_date'] = $request->start_dt;
      $input['end_date'] = $request->end_dt;
      $input['start_time'] = $request->start_time;
      $input['end_time'] = $request->end_time;
      $input['area'] = $request->area;
      $input['table_num'] = $request->cabin_num;
      $input['first_name'] = $request->first_name;
      $input['last_name'] = $request->last_name;

      $save = $data->fill($input)->save();
    }
    if ($save) {
      return response()->json(['status' => true, 'msg' => "Table Booked successfully"]);
      exit;
    } else {
      return response()->json(['status' => false, 'msg' => "Error's Occurs !! Try again later"]);
      exit;
    }
  }

  /**
   * @method use for show privacy 
   */
  public function privacy()
  {
    $privacy = DB::table('privacy_policies')->orderBy('id' , 'desc')->first();
    return view('website.privacy' , compact('privacy'));
  }

  /**
   * @method use for show term 
   */
  public function term()
  {
    $terms = DB::table('terms_and_conditions')->orderBy('id' , 'desc')->first();
    return view('website.term' , compact('terms'));
  }
}
