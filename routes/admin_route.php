<?php

use App\Http\Controllers\Admin\AddStockcontroller;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\SizeSetting;
use App\Http\Controllers\Admin\TypeSetting;
use App\Http\Controllers\Admin\Blog;
use App\Http\Controllers\Admin\BrancheController;
use App\Http\Controllers\Admin\Category;
use App\Http\Controllers\Admin\ChildCategory;
use App\Http\Controllers\Admin\Coupon;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\Department;
use App\Http\Controllers\Admin\FoodPurchase;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\IndGrpController;
use App\Http\Controllers\Admin\IndItemController;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Offer;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\Product;
use App\Http\Controllers\Admin\Profile;
use App\Http\Controllers\Admin\SubCategory;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SmtpController;
use App\Http\Controllers\Admin\languageController;
use App\Http\Controllers\Admin\PropertiesController;
use App\Http\Controllers\Admin\Staff;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\Table;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\WaiterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CombopackController;
use App\Http\Controllers\Admin\DeliveryFeedbackController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\IngredientPurchaseController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\TermsAndConditionController;
use App\Http\Controllers\CompleteOrderController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\TableDetailController;


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

/**@auth */

Route::get('/', [Login::class, 'index'])->name('admin.login');
Route::get('/forget_password', [Login::class, 'forgetPassword'])->name('admin.forget_password');
Route::get('/reset_password', [Login::class, 'resetPassword'])->name('admin.reset_password');

// admin login process
Route::post('login', [Login::class, 'loginSubmit'])->name('admin.submit_login');


Route::group(['middleware' => 'admin_middle'], function () {

    Route::get('/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');

    // Profile Route
    Route::get('/profile', [Profile::class, 'index'])->name('admin.profile');
    Route::post('/profile/update', [Profile::class, 'profileUpdate'])->name('admin.profile_update');

    // Category Route
    Route::get('/category', [Category::class, 'index'])->name('admin.category');
    Route::post('/category/store', [Category::class, 'store'])->name('admin.category.store');
    Route::post('/category/update', [Category::class, 'update'])->name('admin.category.update');
    Route::post('/category/status', [Category::class, 'status'])->name('admin.category.status');
    Route::post('/category/destroy', [Category::class, 'destroy'])->name('admin.category.destroy');
    Route::get('/category/category_ajax_list', [Category::class, 'categoryAjaxList'])->name('admin.category_ajax_list');

    // Sub Category Route
    Route::get('/sub_category', [SubCategory::class, 'index'])->name('admin.sub_category');
    Route::post('/sub_category/store', [SubCategory::class, 'store'])->name('admin.sub_category.store');
    Route::post('/sub_category/update', [SubCategory::class, 'update'])->name('admin.sub_category.update');
    Route::post('/sub_category/status', [SubCategory::class, 'status'])->name('admin.sub_category.status');
    Route::post('/sub_category/destroy', [SubCategory::class, 'destroy'])->name('admin.sub_category.destroy');
    Route::get('/sub_category/sub_category_ajax_list', [SubCategory::class, 'SubCategoryAjaxList'])->name('admin.sub_category_ajax_list');

    //Child Category Route
    Route::get('/child_category', [ChildCategory::class, 'index'])->name('admin.child_category');
    Route::post('/child_category/store', [ChildCategory::class, 'store'])->name('admin.child_category.store');
    Route::post('/child_category/update', [ChildCategory::class, 'update'])->name('admin.child_category.update');
    Route::post('/child_category/status', [ChildCategory::class, 'status'])->name('admin.child_category.status');
    Route::post('/child_category/destroy', [ChildCategory::class, 'destroy'])->name('admin.child_category.destroy');
    Route::get('/child_category/child_category_ajax_list', [ChildCategory::class, 'childCategoryAjaxList'])->name('admin.child_category_ajax_list');


    // Product Route
    Route::get('/product', [Product::class, 'index'])->name('admin.product.index');
    Route::post('/product/store', [Product::class, 'store'])->name('admin.product.store');
    Route::get('/product/list', [Product::class, 'productList'])->name('admin.product.list');
    Route::get('/product/edit/{id}', [Product::class, 'edit'])->name('admin.product.edit');
    Route::get('/product/add-default-toppings/{id}', [Product::class, 'add_default_toppings'])->name('admin.product.add_default_toppings');
    Route::post('/product/update', [Product::class, 'update'])->name('admin.product.update');
    Route::post('/product/update_default', [Product::class, 'update_default'])->name('admin.product.update.default');
    Route::post('/product/status', [Product::class, 'statusUpdate'])->name('admin.product.status');
    Route::post('/product/destroy', [Product::class, 'productDelete'])->name('admin.product.destroy');
    Route::get('/product/product_ajax_list', [Product::class, 'productAjaxList'])->name('admin.product_ajax_list');


    // Coupons Route
    Route::get('coupons', [Coupon::class, 'index'])->name('admin.coupon.index');
    Route::post('coupons/store', [Coupon::class, 'store'])->name('admin.coupon.store');
    Route::post('/coupons/update', [Coupon::class, 'update'])->name('admin.coupons.update');
    Route::post('/coupons/status', [Coupon::class, 'statusUpdate'])->name('admin.coupons.status');
    Route::post('/coupons/destroy', [Coupon::class, 'destroy'])->name('admin.coupons.destroy');
    Route::get('/coupons/coupon_ajax_list', [Coupon::class, 'couponAjaxList'])->name('admin.coupon.coupon_ajax_list');

    // Offer  Route
    Route::get('offer', [Offer::class, 'index'])->name('admin.offer.index');
    Route::post('offer/store', [Offer::class, 'store'])->name('admin.offer.store');
    Route::post('/offer/update', [Offer::class, 'update'])->name('admin.offer.update');
    Route::post('/offer/status', [Offer::class, 'statusUpdate'])->name('admin.offer.status');
    Route::post('/offer/destroy', [Offer::class, 'destroy'])->name('admin.offer.destroy');
    Route::get('/offer/offer_ajax_list', [Offer::class, 'offerAjaxList'])->name('admin.offer.offer_ajax_list');

    // Blogs Route
    Route::get('blog', [Blog::class, 'index'])->name('admin.blog.index');
    Route::get('blog/create', [Blog::class, 'create'])->name('admin.blog.create');
    Route::post('blog/store', [Blog::class, 'store'])->name('admin.blog.store');
    Route::get('/blog/edit/{id}', [Blog::class, 'edit'])->name('admin.blog.edit');
    Route::post('/blog/update', [Blog::class, 'update'])->name('admin.blog.update');
    Route::post('/blog/status', [Blog::class, 'statusUpdate'])->name('admin.blog.status');
    Route::post('/blog/destroy', [Blog::class, 'destroy'])->name('admin.blog.destroy');
    Route::get('/blog/offer_ajax_list', [Blog::class, 'blogAjaxList'])->name('admin.blog.blog_ajax_list');

    // Size Route
    Route::get('size', [SizeSetting::class, 'index'])->name('admin.size.index');
    Route::get('size/create', [SizeSetting::class, 'create'])->name('admin.size.create');
    Route::post('size/store', [SizeSetting::class, 'store'])->name('admin.size.store');
    Route::get('/size/edit/{id}', [SizeSetting::class, 'edit'])->name('admin.size.edit');
    Route::post('/size/update', [SizeSetting::class, 'update'])->name('admin.size.update');
    Route::post('/size/status', [SizeSetting::class, 'statusUpdate'])->name('admin.size.status');
    Route::post('/size/destroy', [SizeSetting::class, 'destroy'])->name('admin.size.destroy');
    Route::get('/size/size_ajax_list', [SizeSetting::class, 'sizeAjaxList'])->name('admin.size.size_ajax_list');

    // Type Route
    Route::get('type', [TypeSetting::class, 'index'])->name('admin.type.index');
    Route::post('type/store', [TypeSetting::class, 'store'])->name('admin.type.store');
    Route::post('/type/update', [TypeSetting::class, 'update'])->name('admin.type.update');
    Route::post('/type/status', [TypeSetting::class, 'statusUpdate'])->name('admin.type.status');
    Route::post('/type/destroy', [TypeSetting::class, 'destroy'])->name('admin.type.destroy');
    Route::get('/type/type_ajax_list', [TypeSetting::class, 'typeAjaxList'])->name('admin.type.type_ajax_list');


    // Type Route
    Route::get('type', [TypeSetting::class, 'index'])->name('admin.type.index');
    Route::post('type/store', [TypeSetting::class, 'store'])->name('admin.type.store');
    Route::post('/type/update', [TypeSetting::class, 'update'])->name('admin.type.update');
    Route::post('/type/status', [TypeSetting::class, 'statusUpdate'])->name('admin.type.status');
    Route::post('/type/destroy', [TypeSetting::class, 'destroy'])->name('admin.type.destroy');
    Route::get('/type/type_ajax_list', [TypeSetting::class, 'typeAjaxList'])->name('admin.type.type_ajax_list');

    // Extra route
    Route::get('extra', [ExtraController::class, 'index'])->name('admin.extra.index');
    Route::post('extra/store', [ExtraController::class, 'store'])->name('admin.extra.store');
    Route::post('/extra/update', [ExtraController::class, 'update'])->name('admin.extra.update');
    Route::post('/extra/status', [ExtraController::class, 'statusUpdate'])->name('admin.extra.status');
    Route::post('/extra/destroy', [ExtraController::class, 'destroy'])->name('admin.extra.destroy');
    Route::get('/extra/type_ajax_list', [ExtraController::class, 'extraAjaxList'])->name('admin.extra.extra_ajax_list');

    // Logout Route
    Route::post('logout', [Login::class, 'logout'])->name('admin.logout');

    // ComboPack Route
    Route::get('combopackList', [CombopackController::class, 'combolist'])->name('admin.combopack.list');
    Route::get('combo_ajax_list', [CombopackController::class, 'comboAjaxList'])->name('admin.combo_ajax_list');
    Route::post('storecombo', [CombopackController::class, 'storecombo'])->name('admin.combo.store');
    Route::post('update', [CombopackController::class, 'update'])->name('admin.combopack.update');
    Route::post('status', [CombopackController::class, 'status'])->name('admin.combopack.status');
    Route::post('destroy', [CombopackController::class, 'destroy'])->name('admin.combopack.destroy');


    // Group Add
    Route::get('group', [GroupController::class, 'index'])->name('admin.group.index');
    Route::post('group/store', [GroupController::class, 'store'])->name('admin.group.store');
    Route::post('/group/update', [GroupController::class, 'update'])->name('admin.group.update');
    Route::post('/group/status', [GroupController::class, 'statusUpdate'])->name('admin.group.status');
    Route::post('/group/destroy', [GroupController::class, 'destroy'])->name('admin.group.destroy');
    Route::get('/group/group_ajax_list', [GroupController::class, 'groupAjaxList'])->name('admin.group.group_ajax_list');

    // Properties Add
    Route::get('properties', [PropertiesController::class, 'index'])->name('admin.properties.index');
    Route::post('properties/store', [PropertiesController::class, 'store'])->name('admin.properties.store');
    Route::post('/properties/update', [PropertiesController::class, 'update'])->name('admin.properties.update');
    Route::post('/properties/status', [PropertiesController::class, 'statusUpdate'])->name('admin.properties.status');
    Route::post('/properties/destroy', [PropertiesController::class, 'destroy'])->name('admin.properties.destroy');
    Route::get('/properties/properties_ajax_list', [PropertiesController::class, 'propertiesAjaxList'])->name('admin.properties.properties_ajax_list');


    // Properties Add
    Route::get('properties-item/{id}', [PropertiesController::class, 'propertyItems'])->name('admin.properties.item.index');
    Route::post('properties/items/store', [PropertiesController::class, 'propertyItemStore'])->name('admin.properties.items.store');
    Route::post('/properties/item/update', [PropertiesController::class, 'itemUpdate'])->name('admin.properties.item.update');
    Route::post('/properties/item/status', [PropertiesController::class, 'itemStatusUpdate'])->name('admin.properties.item.status');
    Route::post('/properties/item/destroy', [PropertiesController::class, 'itemDestroy'])->name('admin.properties.item.destroy');
    Route::get('/properties/properties_item_ajax_list/{id}', [PropertiesController::class, 'propertiesItemAjaxList'])->name('admin.properties.properties_item_ajax_list');

    // Variation
    Route::get('variation', [VariationController::class, 'index'])->name('admin.variation.index');
    Route::post('variation/store', [VariationController::class, 'store'])->name('admin.variation.store');
    Route::post('/variation/update', [VariationController::class, 'update'])->name('admin.variation.update');
    Route::post('/variation/status', [VariationController::class, 'statusUpdate'])->name('admin.variation.status');
    Route::post('/variation/destroy', [VariationController::class, 'destroy'])->name('admin.variation.destroy');
    Route::get('/variation/variation_ajax_list', [VariationController::class, 'variationsAjaxList'])->name('admin.variation.variation_ajax_list');

    // Branche
    Route::get('branch', [BrancheController::class, 'index'])->name('admin.branch.index');
    Route::post('branch/store', [BrancheController::class, 'store'])->name('admin.branch.store');
    Route::post('/branch/update', [BrancheController::class, 'update'])->name('admin.branch.update');
    Route::post('/branch/status', [BrancheController::class, 'statusUpdate'])->name('admin.branch.status');
    Route::post('/branch/destroy', [BrancheController::class, 'destroy'])->name('admin.branch.destroy');
    Route::get('/branch/branch_ajax_list', [BrancheController::class, 'brancheAjaxList'])->name('admin.branch.branch_ajax_list');

    // Commission
    Route::get('commission', [Department::class, 'index'])->name('admin.commission.index');
    Route::post('commission/store', [Department::class, 'store'])->name('admin.commission.store');
    Route::post('/commission/update', [Department::class, 'update'])->name('admin.commission.update');
    Route::post('/commission/status', [Department::class, 'statusUpdate'])->name('admin.commission.status');
    Route::post('/commission/destroy', [Department::class, 'destroy'])->name('admin.commission.destroy');
    Route::get('/commission/commission_ajax_list', [Department::class, 'commissionAjaxList'])->name('admin.commission.commission_ajax_list');

    // TABLE
    Route::get('table', [Table::class, 'index'])->name('admin.table.index');
    Route::post('table/store', [Table::class, 'store'])->name('admin.table.store');
    Route::post('/table/update', [Table::class, 'update'])->name('admin.table.update');
    Route::post('/table/status', [Table::class, 'statusUpdate'])->name('admin.table.status');
    Route::post('/table/destroy', [Table::class, 'destroy'])->name('admin.table.destroy');
    Route::get('/table/table_ajax_list', [Table::class, 'tableAjaxList'])->name('admin.table.table_ajax_list');

    // Payment
    Route::get('payment', [PaymentController::class, 'index'])->name('admin.payment.index');
    Route::post('payment/store', [PaymentController::class, 'store'])->name('admin.payment.store');
    Route::post('/payment/update', [PaymentController::class, 'update'])->name('admin.payment.update');
    Route::post('/payment/status', [PaymentController::class, 'statusUpdate'])->name('admin.payment.status');
    Route::post('/payment/destroy', [PaymentController::class, 'destroy'])->name('admin.payment.destroy');
    Route::get('/payment/payment_ajax_list', [PaymentController::class, 'paymentAjaxList'])->name('admin.payment.payment_ajax_list');


    // Staff
    Route::get('staff', [Staff::class, 'index'])->name('admin.staff.index');
    Route::post('staff/store', [Staff::class, 'store'])->name('admin.staff.store');
    Route::post('/staff/update', [Staff::class, 'update'])->name('admin.staff.update');
    Route::post('/staff/status', [Staff::class, 'statusUpdate'])->name('admin.staff.status');
    Route::post('/staff/destroy', [Staff::class, 'destroy'])->name('admin.staff.destroy');
    Route::get('/staff/staff_ajax_list', [Staff::class, 'staffAjaxList'])->name('admin.staff.staff_ajax_list');

    //  Staff Permission
    Route::get('permission_allow/{staff_id}', [Staff::class, 'permission_allow'])->name('admin.staff.permission_allow');
    Route::get('staff_manage', [Staff::class, 'staff_manage'])->name('admin.staff.staff_manage');
    Route::post('save_permission', [Staff::class, 'save_permission'])->name('admin.staff.save_permission');

    // Customer
    Route::get('customer', [CustomerController::class, 'index'])->name('admin.customer.index');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('admin.customer.store');
    Route::post('/customer/update', [CustomerController::class, 'update'])->name('admin.customer.update');
    Route::post('/customer/status', [CustomerController::class, 'statusUpdate'])->name('admin.customer.status');
    Route::post('/customer/destroy', [CustomerController::class, 'destroy'])->name('admin.customer.destroy');
    Route::get('/customer/customer_ajax_list', [CustomerController::class, 'customerAjaxList'])->name('admin.customer.customer_ajax_list');

    //Waiter
    Route::get('waiter', [WaiterController::class, 'index'])->name('admin.waiter.index');
    Route::post('waiter/store', [WaiterController::class, 'store'])->name('admin.waiter.store');
    Route::post('/waiter/update', [WaiterController::class, 'update'])->name('admin.waiter.update');
    Route::post('/waiter/status', [WaiterController::class, 'statusUpdate'])->name('admin.waiter.status');
    Route::post('/waiter/destroy', [WaiterController::class, 'destroy'])->name('admin.waiter.destroy');
    Route::get('/waiter/waiter_ajax_list', [WaiterController::class, 'waiterAjaxList'])->name('admin.waiter.waiter_ajax_list');

    // Delivery
    Route::get('delivery', [DeliveryController::class, 'index'])->name('admin.delivery.index');
    Route::post('delivery/store', [DeliveryController::class, 'store'])->name('admin.delivery.store');
    Route::post('/delivery/update', [DeliveryController::class, 'update'])->name('admin.delivery.update');
    Route::post('/delivery/status', [DeliveryController::class, 'statusUpdate'])->name('admin.delivery.status');
    Route::post('/delivery/destroy', [DeliveryController::class, 'destroy'])->name('admin.delivery.destroy');
    Route::get('/delivery/delivery_ajax_list', [DeliveryController::class, 'deliveryAjaxList'])->name('admin.delivery.delivery_ajax_list');

    //  Delivery Feedback
    Route::get('delivery-feedback', [DeliveryFeedbackController::class, 'index'])->name('admin.delivery.feedback.index');
    // Complete Order
    Route::get('complete-order-index', [CompleteOrderController::class, 'completeOrderindex'])->name('admin.complete.order.index');
    Route::get('complete-order-ajax-list', [CompleteOrderController::class, 'completeOrderList'])->name('admin.complete.order.ajax_list');

    // Food Purchase
    Route::get('food_purchase', [FoodPurchase::class, 'index'])->name('admin.food_purchase.index');
    Route::post('food_purchase/store', [FoodPurchase::class, 'store'])->name('admin.food_purchase.store');
    Route::post('/food_purchase/update', [FoodPurchase::class, 'update'])->name('admin.food_purchase.update');
    Route::post('/food_purchase/status', [FoodPurchase::class, 'statusUpdate'])->name('admin.food_purchase.status');
    Route::post('/food_purchase/destroy', [FoodPurchase::class, 'destroy'])->name('admin.food_purchase.destroy');
    Route::get('/food_purchase/food_purchase_ajax_list', [FoodPurchase::class, 'food_purchase_AjaxList'])->name('admin.food_purchase.food_purchase_ajax_list');
    Route::get('food_purchase_list', [FoodPurchase::class, 'food_purchase_list'])->name('admin.food_purchase.food_purchase_list');
    Route::post('show_food', [FoodPurchase::class, 'show_food'])->name('admin.show_food.show_food');
    Route::post('update_qty', [FoodPurchase::class, 'update_qty'])->name('admin.food_purchase.update_qty');
    Route::post('update_price', [FoodPurchase::class, 'update_price'])->name('admin.food_purchase.update_price');

    Route::get('food_purchase_show_detail/{id}', [FoodPurchase::class, 'food_purchase_show_detail'])->name('admin.food_purchase.food_purchase_show_detail');

    Route::post('food_purchase_show_items', [FoodPurchase::class, 'foodPurchaseShowItems'])->name('admin.food_purchase_items_show');
    Route::post('food_purchase_store/store', [FoodPurchase::class, 'storeFoodPurchaseNew'])->name('admin.food_purchase.new.store');
    Route::get('food_purchase/edit/{id}', [FoodPurchase::class, 'edit'])->name('admin.food_purchase_edit');
    Route::post('food_purchase_update', [FoodPurchase::class, 'updateFoodPurchaseNew'])->name('admin.food_purchase_update');

    // Ingredient group
    Route::get('ind_grp', [IndGrpController::class, 'index'])->name('admin.ind_grp.index');
    Route::post('ind_grp/store', [IndGrpController::class, 'store'])->name('admin.ind_grp.store');
    Route::post('/ind_grp/update', [IndGrpController::class, 'update'])->name('admin.ind_grp.update');
    Route::post('/ind_grp/status', [IndGrpController::class, 'statusUpdate'])->name('admin.ind_grp.status');
    Route::post('/ind_grp/destroy', [IndGrpController::class, 'destroy'])->name('admin.ind_grp.destroy');
    Route::get('/ind_grp/ind_grp_ajax_list', [IndGrpController::class, 'ind_grp_AjaxList'])->name('admin.ind_grp.ind_grp_ajax_list');

    // Ingredient Item
    Route::get('ind_item', [IndItemController::class, 'index'])->name('admin.ind_item.index');
    Route::post('ind_item/store', [IndItemController::class, 'store'])->name('admin.ind_item.store');
    Route::post('/ind_item/update', [IndItemController::class, 'update'])->name('admin.ind_item.update');
    Route::post('/ind_item/status', [IndItemController::class, 'statusUpdate'])->name('admin.ind_item.status');
    Route::post('/ind_item/destroy', [IndItemController::class, 'destroy'])->name('admin.ind_item.destroy');
    Route::get('/ind_item/ind_item_ajax_list', [IndItemController::class, 'ind_item_AjaxList'])->name('admin.ind_item.ind_item_ajax_list');

    //  Ingredient Purchase
    Route::get('ingredient_purchase', [IngredientPurchaseController::class, 'index'])->name('admin.ingredient_purchase');
    Route::get('ingredient_purchase/list', [IngredientPurchaseController::class, 'list'])->name('admin.ingredient_purchase.list');
    Route::post('store/ingredient_purchase', [IngredientPurchaseController::class, 'storeIngredientPurchase'])->name('admin.ingredient_purchase.store');
    Route::get('ingredient_purchase/ajax_list', [IngredientPurchaseController::class, 'AjaxListIngredientPurchase'])->name('admin.ingredient_purchase.ajax_list');
    Route::post('ingredient_purchase/update', [IngredientPurchaseController::class, 'UpdateIngredientPurchase'])->name('admin.ingredient_purchase.update');
    Route::post('ingredient_purchase/destory', [IngredientPurchaseController::class, 'DestoryIngredientPurchase'])->name('admin.ingredient_purchase.destory');
    Route::post('ingredient_purchase_show_items', [IngredientPurchaseController::class, 'ingredientPurchaseShowItems'])->name('admin.ingredient_purchase_items_show');
    Route::post('ingredient_purchase_store/store', [IngredientPurchaseController::class, 'storeIngredientPurchaseNew'])->name('admin.ingredient_purchase.new.store');
    Route::get('ingredient_purchase/edit/{id}', [IngredientPurchaseController::class, 'edit'])->name('admin.ingredient_purchase_edit');
    Route::post('ingredient_purchase_update', [IngredientPurchaseController::class, 'updateIngredientPurchaseNew'])->name('admin.ingredient_purchase_update');

    // Supplier
    Route::get('supplier', [SupplierController::class, 'index'])->name('admin.supplier.index');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('admin.supplier.store');
    Route::post('/supplier/update', [SupplierController::class, 'update'])->name('admin.supplier.update');
    Route::post('/supplier/status', [SupplierController::class, 'statusUpdate'])->name('admin.supplier.status');
    Route::post('/supplier/destroy', [SupplierController::class, 'destroy'])->name('admin.supplier.destroy');
    Route::get('/supplier/supplier_ajax_list', [SupplierController::class, 'supplier_AjaxList'])->name('admin.supplier.supplier_ajax_list');

    Route::get('supplier-history', [SupplierController::class, 'supplierHistory'])->name('admin.supplier.history');
    Route::get('supplier-view-details/{id}/{type}', [SupplierController::class, 'supplierViewDetails'])->name('admin.supplier.history.details');

    // Logout Route
    Route::post('logout', [Login::class, 'logout'])->name('admin.logout');

    //currency setting Route
    Route::get('currency', [SettingController::class, 'index'])->name('admin.setting.currency');
    Route::post('/currency/store', [SettingController::class, 'store'])->name('admin.currency.store');
    Route::post('/currency/update', [SettingController::class, 'update'])->name('admin.currency.update');
    Route::post('/currency/status', [SettingController::class, 'status'])->name('admin.currency.status');
    Route::post('/currency/destroy', [SettingController::class, 'destroy'])->name('admin.currency.destroy');
    Route::get('/currency/currency_ajax_list', [SettingController::class, 'currencyAjaxList'])->name('admin.currency_ajax_list');

    //General Setting Route
    Route::get('general-settings', [SettingController::class, 'general_index'])->name('admin.setting.general');
    Route::post('/general/store', [SettingController::class, 'general_store'])->name('admin.setting.store');

    //smtp route
    Route::get('smtp-settings', [SmtpController::class, 'smtp_index'])->name('admin.setting.smtp');
    Route::post('smtp-store', [SmtpController::class, 'smtp_store'])->name('admin.smtp.store');

    //language route
    Route::get('language', [languageController::class, 'index'])->name('admin.setting.language');
    Route::post('/language/store', [languageController::class, 'store'])->name('admin.language.store');
    Route::post('/language/update', [languageController::class, 'update'])->name('admin.language.update');
    // Route::post('/language/status' , [languageController::class , 'status'])->name('admin.language.status');
    Route::post('/language/destroy', [languageController::class, 'destroy'])->name('admin.language.destroy');
    Route::get('/language/language_ajax_list', [languageController::class, 'languageAjaxList'])->name('admin.language_ajax_list');
    Route::get('/delivery-charges/view', [DeliveryController::class, 'viewDeliveryCharges'])->name('admin.view.delivery_charges');
    Route::post('/delivery-charges/update', [DeliveryController::class, 'viewDeliveryChargesUpdate'])->name('admin.view.delivery_charges.update');

    //  privacy policy route
    Route::get('/privacy-policy/form', [PrivacyPolicyController::class, 'formPrivacyPolicy'])->name('admin.form.privacy_policy');
    Route::post('/privacy-policy/store', [PrivacyPolicyController::class, 'storePrivacyPolicy'])->name('admin.store.privacy_policy');
    Route::get('/privacy-policy/view', [PrivacyPolicyController::class, 'viewPrivacyPolicy'])->name('admin.view.privacy_policy');

    // Term and Condition Route
    Route::get('/term-and-condition/form', [TermsAndConditionController::class, 'formTermandCondition'])->name('admin.form.term_and_condition');
    Route::post('/term-and-condition/update', [TermsAndConditionController::class, 'updateTermandCondition'])->name('admin.update.term_and_condition');
    Route::get('/term-and-condition/view', [TermsAndConditionController::class, 'viewTermandCondition'])->name('admin.view.term_and_condition');


    //Order Route --branche Controller
    Route::get('order-detail', [BrancheController::class, 'order_details'])->name('admin.order.detail');
    Route::get('order/detail_ajax_list', [BrancheController::class, 'order_ajax'])->name('admin.order.detail_ajax_list');
    Route::get('order-particular-details/{id}', [BrancheController::class, 'order_particular_details'])->name('admin.order_details');
    Route::get('order/particular_ajax_list', [BrancheController::class, 'particular_order__ajax'])->name('admin.order.particular_ajax_list');

    //  update delivery boy name
    Route::post('order-store_deliveryboy', [BrancheController::class, 'orderStoreDeliveryboy'])->name('admin.order.store_delivery_boy');

    //  update delivery status
    Route::post('order-update-delivery_status', [BrancheController::class, 'updateOrderDeliveryStatus'])->name('admin.order.update_delivery_status');

    //qr route
    Route::get('qr-table', [QrCodeController::class, 'index'])->name('admin.table.qrcode');
    Route::post('/qr/store', [QrCodeController::class, 'store'])->name('admin.qr.store');
    Route::post('/qr/update', [QrCodeController::class, 'update'])->name('admin.qr.update');
    Route::post('/qr/destroy', [QrCodeController::class, 'destroy'])->name('admin.qr.destroy');
    Route::get('/qr/qr_ajax_list', [QrCodeController::class, 'qrAjaxList'])->name('admin.qr_ajax_list');


    // Route for Help
    Route::get('help-index', [HelpController::class, 'index'])->name('admin.help.index');
    Route::post('help-store', [HelpController::class, 'storeHelp'])->name('admin.help.store');

    // Route for Add Stocks
    Route::get('view-stocks', [AddStockcontroller::class, 'viewStock'])->name('admin.view.stock');
    Route::get('ajax-stocks-list', [AddStockcontroller::class, 'viewAjaxStockList'])->name('admin.view.ajax.stock.list');
    Route::get('stock-index', [AddStockcontroller::class, 'indexStock'])->name('admin.index.stock');
    Route::post('add-stock', [AddStockcontroller::class, 'addStock'])->name('admin.add.stock');

    // POS System
    Route::get('pos_system', [PosController::class, 'index'])->name('admin.pos');
    Route::get('get_sub_category', [PosController::class, 'get_sub_category'])->name('admin.get_sub_category');

    Route::get('get_menu', [PosController::class, 'get_menu'])->name('admin.get_menu');
    Route::post('add_to_cart', [PosController::class, 'add_to_cart'])->name('admin.add_to_cart');
    Route::post('extra_add_to_cart', [PosController::class, 'extra_add_to_cart'])->name('admin.extra_add_to_cart');
    Route::get('get_cart_list_ajax', [PosController::class, 'get_cart_list_ajax'])->name('admin.get_cart_list_ajax');
    Route::post('remove_from_cart', [PosController::class, 'remove_from_cart'])->name('admin.remove_from_cart');
    Route::post('check_coupon', [PosController::class, 'check_coupon'])->name('admin.check_coupon');

    Route::post('qty_increase', [PosController::class, 'qty_increase'])->name('admin.qty_increase');
    Route::post('qty_decrease', [PosController::class, 'qty_decrease'])->name('admin.qty_decrease');

    Route::post('place_order', [PosController::class, 'place_order'])->name('admin.place_order');
    Route::get('order_history', [PosController::class, 'order_history'])->name('admin.order_history');
    Route::get('order_history_details/{order_id}', [PosController::class, 'orderHistoryDetail'])->name('admin.order_history_details');

    // Combo Pack
    Route::get('get_combo_pack', [PosController::class, 'get_combo_pack'])->name('admin.get_combo_pack');
    Route::post('combo_pack_detail', [PosController::class, 'combo_pack_detail'])->name('admin.get_combo_pack_detail');
    Route::post('combo_pack_add_to_cart', [PosController::class, 'comboPackAddToCart'])->name('admin.combo_pack_add_to_cart');
});
//TableDetails
Route::get('show-table-data', [TableDetailController::class, 'index'])->name('admin.table.booked_table');
Route::get('show-table', [TableDetailController::class, 'show'])->name('admin.table.get_booked_table_ajax');


Route::get('view-stocks', [AddStockcontroller::class, 'viewStock'])->name('admin.view.stock');
Route::get('ajax-stocks-list', [AddStockcontroller::class, 'viewAjaxStockList'])->name('admin.view.ajax.stock.list');
Route::get('stock-index', [AddStockcontroller::class, 'indexStock'])->name('admin.index.stock');
Route::post('add-stock', [AddStockcontroller::class, 'addStock'])->name('admin.add.stock');
// });
