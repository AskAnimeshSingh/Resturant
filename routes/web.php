<?php

use App\Http\Controllers\Website\Blog;
use App\Http\Controllers\Website\Dashboard;
use App\Http\Controllers\Website\HelpController;
use App\Http\Controllers\Website\Login;
use App\Http\Controllers\Website\Menu;
use App\Http\Controllers\Website\Pos;
use App\Http\Controllers\Website\Service;
use App\Http\Controllers\Website\User;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\qrCode;
use BaconQrCode\Encoder\QrCode as EncoderQrCode;

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

// Route::get('/', function () {
//     return view('website.dashboard');
// });

// Route Start for website
Route::get('/', [Dashboard::class, 'index'])->name('website.dashboard');
Route::get('/menu', [Menu::class, 'index'])->name('website.menu');
Route::get('/contact', [Service::class, 'index'])->name('website.contact');
Route::get('/blog', [Blog::class, 'index'])->name('website.blog');
Route::get('/privacy', [Dashboard::class, 'privacy'])->name('website.privacy');
Route::get('/term', [Dashboard::class, 'term'])->name('website.term');
Route::get('/login', [Login::class, 'index'])->name('website.login');
Route::get('/register', [Login::class, 'register'])->name('website.register');
Route::post('/register-process', [Login::class, 'registerProcess'])->name('website.register.process');
Route::get('/opt/{id}', [Login::class, 'opt_view'])->name('website.otp');

// Route for Help
Route::get('/help', [HelpController::class, 'viewHelp'])->name('website.help.view');



// Submit Phone
Route::post('submit_number', [User::class, 'submit'])->name('website.submit_number');
Route::post('otp_verify', [User::class, 'otp_verify'])->name('website.otp_verify');
Route::post('home_address', [User::class, 'homeAddress'])->name('website.home_address');
Route::get('add-user-address', [User::class, 'addUserAddress'])->name('website.add.user.address');
Route::post('add-user-address', [User::class, 'userAddressAdd2'])->name('website.user.address.add');

// Website
Route::group(['middleware' => 'user', 'auth'], function () {


    // Login person access this route
    Route::get('get_sub_category', [Pos::class, 'get_sub_category'])->name('website.get_sub_category');
    Route::get('pos-detail', [Pos::class, 'index'])->name('website.pos_detail');

    Route::get('get_menu', [Pos::class, 'get_menu'])->name('website.get_menu');
    Route::post('add_to_cart', [Pos::class, 'add_to_cart'])->name('website.add_to_cart');
    Route::post('extra_add_to_cart', [Pos::class, 'extra_add_to_cart'])->name('website.extra_add_to_cart');
    Route::post('update_cart', [Pos::class, 'update_cart'])->name('website.update_cart');
    Route::get('get_cart_list_ajax', [Pos::class, 'get_cart_list_ajax'])->name('website.get_cart_list_ajax');
    Route::post('remove_from_cart', [Pos::class, 'remove_from_cart'])->name('website.remove_from_cart');
    Route::post('check_coupon', [Pos::class, 'check_coupon'])->name('website.check_coupon');

    Route::post('qty_increase', [Pos::class, 'qty_increase'])->name('website.qty_increase');
    Route::post('qty_decrease', [Pos::class, 'qty_decrease'])->name('website.qty_decrease');

    Route::post('place_order', [Pos::class, 'place_order'])->name('website.place_order');
    Route::get('order_history', [Pos::class, 'order_history'])->name('website.order_history');
    Route::get('order_history_details/{order_id}', [Pos::class, 'orderHistoryDetail'])->name('website.order_history_details');

    // Cancel Order

    Route::post('cancel_order', [Pos::class, 'candelOrder'])->name('website.cancel_order');

    // Combo Pack
    Route::get('get_combo_pack', [Pos::class, 'get_combo_pack'])->name('website.get_combo_pack');
    Route::post('combo_pack_detail', [Pos::class, 'combo_pack_detail'])->name('website.get_combo_pack_detail');
    Route::post('combo_pack_add_to_cart', [Pos::class, 'comboPackAddToCart'])->name('website.combo_pack_add_to_cart');

    // Route Address
    Route::post('website.user_address_add', [User::class, 'userAddressAdd'])->name('website.user_address_add');
    Route::get('get_user_address', [User::class, 'getUserAddress'])->name('website.get_user_address');
    Route::post('remove_address', [User::class, 'removeAddress'])->name('website.remove_address');
    Route::post('update_address', [User::class, 'update_address'])->name('website.update_address');

    //Route Logout
    Route::post('logout', [User::class, 'logout'])->name('website.logout');


    //Route ProfileSubmit
    Route::post('user_profile_submit_new', [User::class, 'profileSubmit'])->name('website.user_profile_submit_new');

    Route::get('order-details/{id}', [Pos::class, 'Order_details'])->name('website.order_details');

    Route::POST('get-extra', [Pos::class, 'extra_topping'])->name('website.extra_topping');
    Route::POST('get-variants', [Pos::class, 'extra_variants'])->name('website.extra_variants');
    Route::POST('get-variants-update', [Pos::class, 'extra_variants_update'])->name('website.extra_variants_update');


});

Route::post('home_address', [User::class, 'homeAddress'])->name('website.home_address');
Route::post('pickup_address', [User::class, 'pickupAddress'])->name('website.pickup_address_new');

//Route Book Table
Route::post('/book_table', [Dashboard::class, 'store'])->name('website.book_table');

//Route ProfileSubmit
Route::post('user_profile_submit_new', [User::class, 'profileSubmit'])->name('website.user_profile_submit_new');


//extra product
// Route::post('extra-prod',[Pos::class,'extra_prod'])->name('website.extra_product');
//extra topping

// Include Admin Routes
Route::prefix('admin')->group(base_path('routes/admin_route.php'));

// Kitchen Routes
Route::prefix('kitchen')->group(base_path('routes/kitchen_route.php'));

Route::prefix('deliveryboy')->group(base_path('routes/delivery_boy.php'));

// Include Common Route
Route::prefix('common')->group(base_path('routes/common_route.php'));

Route::get('qr-code-g', function () {
    $qr = QrCode::size(200)->generate('Welcome to Makitweb');
    print_r($qr);
});


