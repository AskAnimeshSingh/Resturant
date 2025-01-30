<?php

use App\Http\Controllers\deliveryboy\DashboardController;
use App\Http\Controllers\deliveryboy\DeliveryBoyLoginController;
use App\Http\Controllers\deliveryboy\OrderListController;
use App\Http\Controllers\deliveryboy\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| deliveryboy Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/' , [DeliveryBoyLoginController::class , 'index'])->name('deliveryboy.login');

// Deliveryboy login process
Route::post('login' , [DeliveryBoyLoginController::class , 'loginSubmit'])->name('deliveryboy.submit_login');

Route::group(['middleware' => 'delivery_boy'] , function () {

    // Logout Route
    Route::post('logout' , [DeliveryBoyLoginController::class , 'logout'])->name('deliveryboy.logout');

    Route::get('/dashboard',[DashboardController::class, 'dashboard'])->name('deliveryboy.dashboard');

    // Profile Route
    Route::get('/profile' , [ProfileController::class , 'index'])->name('deliveryboy.profile');
    Route::post('/profile/update' , [ProfileController::class , 'profileUpdate'])->name('deliveryboy.profile_update');

    Route::get('change-password',[ProfileController::class, 'changePassword'])->name('deliveryboy.changepassword');
    Route::post('update-password',[ProfileController::class, 'updatePassword'])->name('deliveryboy.updatepassword');

    // Route for All Order List
    Route::get('/order-list', [OrderListController::class, 'orderList'])->name('deliveryboy.order_list');
    Route::get('/order-list-ajax', [OrderListController::class, 'orderListajax'])->name('deliveryboy.order_list.ajax');

     // Route for Pending Order List
     Route::get('/order-list-pending', [OrderListController::class, 'orderListPending'])->name('deliveryboy.order_list.pending');
    //  Route::get('/get/order-list-pending', [OrderListController::class, 'getOrderListPending'])->name('deliveryboy.get.order_list.pending');
     Route::get('/order-list-pending-ajax/{id}', [OrderListController::class, 'orderListajaxPending'])->name('deliveryboy.order_list.pending.ajax');

    // Route for Delivered Order List
     Route::get('/order-list-delivered', [OrderListController::class, 'orderListDelivered'])->name('deliveryboy.order_list.delivered');
     Route::get('/order-list-delivered-ajax', [OrderListController::class, 'orderListajaxDelivered'])->name('deliveryboy.order_list.delivered.ajax');

     Route::get('/view-product-details/{id}', [OrderListController::class, 'viewProductDetails'])->name('deliveryboy.view_product.details');
     
    //  Route for Delivery Boy Queue
    Route::get('/view-deliveryboy-queue', [OrderListController::class, 'DeliveryBoyQueue'])->name('deliveryboy.queue');

    Route::post('/order-update-status-approve', [OrderListController::class, 'updateOrderStatusApprove'])->name('deliveryboy.update.order.status.approve');
    Route::post('/order-update-status-payment', [OrderListController::class, 'updateOrderStatusPayment'])->name('deliveryboy.update.order.status.payment');
    // Route::post('/order-update-status-dispatch', [OrderListController::class, 'updateOrderStatusDispatch'])->name('deliveryboy.update.order.status.dispatch');


    // Route::get('/order-details/{id}', [OrderListController::class, 'orderDetails'])->name('deliveryboy.order.details');
    // Route::post('/order-details-update-status', [OrderListController::class, 'orderDetailsUpdate'])->name('deliveryboy.order.details.update.status');


});

