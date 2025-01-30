<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\UserLoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CouponsController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DeliveryLoginController;
use App\Http\Controllers\Api\DeliveryProfileController;
use App\Http\Controllers\Api\DeliveryOrderController;




Route::post('/login', [UserLoginController::class, 'login']);
Route::post('/register', [UserLoginController::class, 'signup']);
Route::post('/otp-validate', [UserLoginController::class, 'otp_verify']);
Route::post('/resend-otp', [UserLoginController::class, 'resendOtp']);
Route::post('/login-email', [UserLoginController::class, 'loginEmail']);
Route::post('/forget-password', [UserLoginController::class, 'forgetPassword']);
Route::post('/check-mail-otp', [UserLoginController::class, 'checkMailOtp']);
Route::post('/update-password', [UserLoginController::class, 'updatePassword']);
Route::post('/user-data', [UserLoginController::class, 'getUserData']);
Route::post('/get-branch', [UserLoginController::class, 'getBranches']);
Route::post('/resend-email-otp', [UserLoginController::class, 'emailResendotp']);

Route::group(['middleware' =>  ['auth:sanctum']], function () {
    Route::post('/update-user', [UserLoginController::class, 'uodateUser']);
    Route::post('/update-phone', [UserLoginController::class, 'updatePhone']);
    Route::post('/update-email', [UserLoginController::class, 'updateEmail']);
    
});


Route::get('/user-address-list', [ProfileController::class, 'get_addresses']);
Route::post('/user-address-add', [ProfileController::class, 'add_address']);
Route::post('/user-address-update', [ProfileController::class, 'update_address']);
Route::get('/user-address-delete', [ProfileController::class, 'delete_address']);
Route::post('/user-profile-add', [ProfileController::class, 'userProfileUpdate']);
Route::get('/user-profile-details', [ProfileController::class, 'userProfileDetails']);

Route::get('/category', [ProductController::class, 'get_categories']);
Route::get('/subcategory', [ProductController::class, 'get_subcategories']);
Route::get('/get-menu', [ProductController::class, 'get_menu']);
Route::get('/product-details', [ProductController::class, 'product_details']);
Route::get('/get-latest-menu', [ProductController::class, 'latest_menu']);
Route::get('/get-popular-menu', [ProductController::class, 'polular_menu']);
Route::get('/search-menu', [ProductController::class, 'search_menu']);


Route::get('/combo-list', [ProductController::class, 'combo_list']);
Route::get('/combo-product-details', [ProductController::class, 'combo_product_details']);
Route::post('/add-to-cart-combo', [CartController::class, 'add_to_cart_combo']);

Route::post('/add-to-cart-without-varient', [CartController::class, 'add_to_cart_without_varient']);
Route::post('/add-to-cart-with-varient', [CartController::class, 'add_to_cart_with_varient']);
Route::post('/add-coupon', [CartController::class, 'add_coupon']);
Route::get('/cart-list', [CartController::class, 'cart_list']);
Route::get('/cart-remove', [CartController::class, 'cart_remove']);
Route::get('/increase-cart', [CartController::class, 'increase_cart']);
Route::get('/decrease-cart', [CartController::class, 'decrease_cart']);

Route::get('/branch-list', [BranchController::class, 'getBranches']);

Route::get('/coupons-list', [CouponsController::class, 'getCoupons']);

Route::post('/place-order', [CheckoutController::class, 'place_order']);

Route::get('/order-history', [OrderController::class, 'order_history']);
Route::get('/order-details', [OrderController::class, 'order_details']);



Route::post('/delivery-login', [DeliveryLoginController::class, 'delivery_login']);
Route::get('/delivery-profile', [DeliveryProfileController::class, 'delivery_profile']);
Route::post('/delivery-profile-update', [DeliveryProfileController::class, 'delivery_profile_upadte']);
Route::post('/delivery-change-password', [DeliveryProfileController::class, 'delivery_change_password']);

Route::get('/delivery-order-all', [DeliveryOrderController::class, 'delivery_order_all']);
Route::get('/delivery-order-details', [DeliveryOrderController::class, 'delivery_order_details']);

Route::get('/order-counter', [OrderController::class, 'order_counter']);
Route::get('/todays-order', [OrderController::class, 'todays_order']);
Route::get('/test', [OrderController::class, 'test']);


