<?php

use App\Http\Controllers\Admin\Common;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Common route
Route::post('/get_sub_category' , [Common::class , 'getSubCategory'])->name('common.get_sub_category');

Route::post('/get_child_category' , [Common::class , 'getChildCategory'])->name('common.get_child_category');

// Price calculate
Route::post('/cal_price' , [Common::class , 'cal_price'])->name('common.cal_price');
