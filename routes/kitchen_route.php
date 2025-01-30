<?php

use App\Http\Controllers\Kitchen\ChefController;
use App\Http\Controllers\Kitchen\DashboardController;
use App\Http\Controllers\Kitchen\DeliveryController;
use App\Http\Controllers\Kitchen\LoginController;
use App\Http\Controllers\Kitchen\OrderListController;
use App\Http\Controllers\Kitchen\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kitchen Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index']);

Route::group(['middleware' => 'kitchen_middle'] , function () {
    // Logout Route
    Route::post('logout' , [LoginController::class , 'logout'])->name('kitchen.logout');

    // Profile Route
    Route::get('/profile' , [ProfileController::class , 'index'])->name('kitchen.profile');
    Route::post('/profile/update' , [ProfileController::class , 'profileUpdate'])->name('kitchen.profile_update');
    Route::get('change-password',[ProfileController::class, 'changePassword'])->name('kitchen.changepassword');
    Route::post('update-password',[ProfileController::class, 'updatePassword'])->name('kitchen.updatepassword');

    // Route for Order List
    Route::get('/order-list', [OrderListController::class, 'orderList'])->name('kitchen.order_list');
    Route::get('/order-list-ajax', [OrderListController::class, 'orderListajax'])->name('kitchen.order_list.ajax');

    // Route for Order List Pending
    Route::get('/order-pending-list', [OrderListController::class, 'orderPendingList'])->name('kitchen.order_pending_list');
    Route::get('/order-pending-list-ajax', [OrderListController::class, 'orderPendingListAjax'])->name('kitchen.order_pending_list.ajax');

    // Route for Order List Cooking
    Route::get('/order-cooking-list', [OrderListController::class, 'orderCookingList'])->name('kitchen.order_cooking_list');
    Route::get('/order-cooking-list-ajax', [OrderListController::class, 'orderCookingListAjax'])->name('kitchen.order_cooking_list.ajax');

    // Route for Order List Dispatched
    Route::get('/order-cooked-list', [OrderListController::class, 'orderCookedList'])->name('kitchen.order_cooked_list');
    Route::get('/order-cooked-list-ajax', [OrderListController::class, 'orderCookedListAjax'])->name('kitchen.order_cooked_list.ajax');

     // Route for Order Delivered List
     Route::get('/order-delivered-list', [OrderListController::class, 'orderDeliveredList'])->name('kitchen.order_delivered_list');
     Route::get('/order-delivered-list-ajax', [OrderListController::class, 'orDerdeliveredListAjax'])->name('kitchen.order_delivered_list.ajax');

    //  Route for Order Details Print Invoice
    Route::get('/order-detail-invoice/{id}', [OrderListController::class, 'orderDetailsInvoice'])->name('kitchen.order_detail_invoice');


    Route::post('/order-update-status-approve', [OrderListController::class, 'updateOrderStatusApprove'])->name('kitchen.update.order.status.approve');
    Route::post('/order-update-status-dispatch', [OrderListController::class, 'updateOrderStatusDispatch'])->name('kitchen.update.order.status.dispatch');


    Route::post('/order-update-status-takeaway', [OrderListController::class, 'updateOrderStatusTakeaway'])->name('kitchen.update.order.status.takeaway');

   // Getting Delivery Guy detail
    Route::get('/delivery-guy/detail/{id}', [OrderListController::class, 'getDeliveryGuyDetail'])->name('kitchen.order.get_delivery_boy.detail');
    Route::get('/delivery-guy/get-deliveryGuy',[OrderListController::class, 'countOrdersByDeliveryGuys'])->name('kitchen.order.count_orders_by_delivery_guys');
    Route::get('/check_delivery_count/{id}',[OrderListController::class, 'checkDeliveryCount'])->name('kitchen.order.check_delivery_count');

    //  update delivery boy name
    Route::post('order-store_deliveryboy', [OrderListController::class, 'orderStoreDeliveryboy'])->name('kitchen.order.store_delivery_boy');



    Route::get('/order-details/{id}', [OrderListController::class, 'orderDetails'])->name('kitchen.order.details');
    // Route::get('/order-details-ajax', [OrderListController::class, 'orderDetailsajax'])->name('kitchen.order.details.ajax');
    Route::post('/order-details-update-status', [OrderListController::class, 'orderDetailsUpdate'])->name('kitchen.order.details.update.status');

    Route::get('/dashboard' , [DashboardController::class , 'index'])->name('kitchen.dashboard');

    Route::get('/chef', [ChefController::class, 'index'])->name('kitchen.chef');
    Route::post('/add-chef', [ChefController::class, 'addChef'])->name('kitchen.add.chef');
    Route::get('/chef-list', [ChefController::class, 'chefList'])->name('kitchen.list.chef');
    Route::get('/chef-ajax-list', [ChefController::class, 'chefListAjax'])->name('kitchen.list_ajax.chef');
    Route::get('/edit-chef/{id}', [ChefController::class, 'editChef'])->name('kitchen.edit.chef');
    Route::post('/update-chef', [ChefController::class, 'updateChef'])->name('kitchen.update.chef');
    Route::post('/update-chef', [ChefController::class, 'updateChef'])->name('kitchen.update.chef');
    Route::post('/delete-chef', [ChefController::class, 'deleteChef'])->name('kitchen.delete.chef');
    Route::post('/status-chef', [ChefController::class, 'statusChef'])->name('kitchen.status.chef');

    Route::post('/assign-chef', [OrderListController::class, 'assignChef'])->name('kitchen.assign.chef');


    // Delivery Route

    Route::get('delivery-guy/order-list', [DeliveryController::class, 'orderList'])->name('kitchen.deliveryboy.order_list');
    // Route::get('/order-list-ajax', [OrderListController::class, 'orderListajax'])->name('kitchen.deliveryboy.order_list.ajax');

    // // Route for Pending Order List
    Route::get('delivery-guy/order-list-pending', [DeliveryController::class, 'orderListPending'])->name('kitchen.deliveryboy.order_list.pending');
    // //  Route::get('/get/order-list-pending', [OrderListController::class, 'getOrderListPending'])->name('deliveryboy.get.order_list.pending');
     Route::get('delivery-guy/order-list-pending-ajax/{id}', [DeliveryController::class, 'orderListajaxPending'])->name('kitchen.deliveryboy.order_list.pending.ajax');

    // // Route for Delivered Order List
     Route::get('delivery-guy/order-list-delivered', [DeliveryController::class, 'orderListDelivered'])->name('kitchen.deliveryboy.order_list.delivered');
     Route::get('delivery-guy/order-list-delivered-ajax/{id}', [DeliveryController::class, 'orderListajaxDelivered'])->name('kitchen.deliveryboy.order_list.delivered.ajax');

     Route::get('delivery-guy/view-product-details/{id}', [DeliveryController::class, 'viewProductDetails'])->name('kitchen.deliveryboy.view_product.details');

    // //  Route for Delivery Boy Queue
    // Route::get('/view-deliveryboy-queue', [OrderListController::class, 'DeliveryBoyQueue'])->name('kitchen.deliveryboy.queue');

    Route::post('delivery-guy/order-update-status-approve', [DeliveryController::class, 'updateOrderStatusApprove'])->name('kitchen.deliveryboy.update.order.status.approve');
    Route::post('delivery-guy/order-update-status-payment', [DeliveryController::class, 'updateOrderStatusPayment'])->name('kitchen.deliveryboy.update.order.status.payment');
});

