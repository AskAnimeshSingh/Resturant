<style>
    .dropdown-menu li.active a {
        color: red !important;
    }
</style>
<?php
$dashboard = Request::is('admin/dashboard');
$category = Request::is('admin/category');
$subCategory = Request::is('admin/sub_category');
$addProduct = Request::is('admin/product');
$productList = Request::is('admin/product/list');
if (!empty($products->id)) {
    $productID = $products->id;
} else {
    $productID = 0;
}
$productEdit = Request::is('admin/product/edit/' . $productID);
$propertyList = Request::is('admin/properties');
$variationList = Request::is('admin/variation');
$coupons = Request::is('admin/coupons');
$offers = Request::is('admin/offer');
?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard')}}"> <img alt="image"
                                                          src="{{ url('public/assets/website/images/logo.webp')}}"
                                                          class="header-logo" style="background-color: red"/> <span
                    class="logo-name font-14">Restaurant POS</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 1 , 1))
                <li class="dropdown {{ $dashboard ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
                </li>
            @endif
            {{-- <li><a class="nav-link" href="{{ route('admin.category')}}"><i data-feather="file"></i><span>Category</span></a></li> --}}
            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 2 , 1))
                <li class="dropdown {{ $category || $subCategory ? 'active' : '' }}">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="briefcase"></i><span>Category</span></a>
                    <ul class="dropdown-menu">
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 2 , 1))
                            <li class="{{ $category ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.category')}}">Category</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 2 , 2))
                            <li class="{{ $subCategory ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.sub_category')}}">Sub Category</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 3 , 1))
                <li class="dropdown {{ $addProduct || $productList || $productEdit || $propertyList || $variationList ? 'active' : '' }}">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="briefcase"></i><span>Food</span></a>
                    <ul class="dropdown-menu">
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 3 , 1))
                            <li class="{{ $addProduct ? 'active' : '' }}"><a class="nav-link"
                                                                             href="{{ route('admin.product.index')}}">Add
                                    New Item</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 3 , 2))
                            <li class="{{ $productList || $productEdit ? 'active' : '' }}"><a class="nav-link"
                                                                                              href="{{route('admin.product.list')}}">All
                                    Item</a></li>
                        @endif
                        {{-- <li><a class="nav-link" href="{{route('admin.group.index')}}">Groups</a></li> --}}
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 3 , 3))
                            <li class="{{ $propertyList ? 'active' : '' }}"><a class="nav-link"
                                                                               href="{{route('admin.properties.index')}}">Properties</a>
                            </li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 3 , 4))
                            <li class="{{ $variationList ? 'active' : '' }}"><a class="nav-link"
                                                                                href="{{route('admin.variation.index')}}">Variations</a>
                            </li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 3))
                            <li class="{{ Request::is('admin/ind_grp') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.ind_grp.index')}}">Ingredient Group</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 4))
                            <li class="{{ Request::is('admin/ind_item') ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('admin.ind_item.index')}}">Ingredient Item</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Product</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('admin.product.list')}}">Product list</a></li>
                <li><a class="nav-link" href="{{ route('admin.product.index')}}">Create</a></li>
              </ul>
            </li> --}}
            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 4 , 1))
                <li class="{{ $coupons ? 'active' : '' }}"><a class="nav-link"
                                                              href="{{ route('admin.coupon.index')}}"><i
                            data-feather="percent"></i><span>Discount</span></a>
                </li>
            @endif
            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 5 , 1))
                <li class="{{ $offers ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.offer.index')}}"><i
                            data-feather="percent"></i><span>Offers</span></a>
                </li>
            @endif
            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 6 , 1))
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="book-open"></i><span>Blogs</span></a>
                    <ul class="dropdown-menu">
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 6 , 1))
                            <li><a class="nav-link" href="{{route('admin.blog.index')}}">Blogs list</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 6 , 2))
                            <li><a class="nav-link" href="{{ route('admin.blog.create')}}">Blogs Create</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 1))
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="command"></i><span>Setting</span></a>
                    <ul class="dropdown-menu">
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 1))--}}
{{--                            <li><a class="nav-link" href="{{ route('admin.size.index')}}">Size Setting</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 2))--}}
{{--                            <li><a class="nav-link" href="{{ route('admin.type.index')}}">Type Setting</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 3))--}}
{{--                            <li><a class="nav-link" href="{{ route('admin.extra.index')}}">Extra</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 4))--}}
{{--                            <li><a class="nav-link" href="{{ route('admin.setting.currency')}}">Currencies</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 5))--}}
{{--                            <li><a class="nav-link" href="{{ route('admin.setting.general')}}">General Settings</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 6))--}}
{{--                            <li><a class="nav-link" href="{{ route('admin.setting.smtp')}}">Email\Smtp</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 7))--}}
{{--                            <li><a class="nav-link" href="{{ route('admin.setting.language')}}">Language</a></li>--}}
{{--                        @endif--}}
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 8))
                            <li><a class="nav-link" href="{{ route('admin.view.privacy_policy')}}">Privacy Policy</a>
                            </li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 9))
                            <li><a class="nav-link" href="{{route('admin.view.term_and_condition')}}">Term and
                                    Condition</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 7 , 9))
                            <li><a class="nav-link" href="{{route('admin.view.delivery_charges')}}">Set Dlivery Charges</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 8 , 1))
                <li><a class="nav-link" href="{{ route('admin.combopack.list')}}"><i data-feather="book-open"></i><span>Combo pack</span></a>
                </li>
            @endif

{{--            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 1))--}}
{{--                <li class="dropdown {{ Request::is('admin/supplier') || Request::is('admin/ind_grp') || Request::is('admin/ind_item') || Request::is('admin/ingredient_purchase') || Request::is('admin/ingredient_purchase/list') || str_contains(url()->full(),'ingredient_purchase/edit') || Request::is('admin/food_purchase') || Request::is('admin/food_purchase_list') || str_contains(url()->full(),'food_purchase/edit') || Request::is('admin/supplier-history') ? 'active' : '' }}">--}}
{{--                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Manage Stock</span></a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 1))--}}
{{--                            <li class="{{ Request::is('admin/food_purchase') ? 'active' : '' }}"><a--}}
{{--                                    class="nav-link" href="{{route('admin.food_purchase.index')}}">Food Purchase</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 2))--}}
{{--                            <li class="{{ Request::is('admin/food_purchase_list') || str_contains(url()->full(),'food_purchase/edit') ? 'active' : '' }}">--}}
{{--                                <a class="nav-link" href="{{ route('admin.food_purchase.food_purchase_list')}}">Purchase--}}
{{--                                    History</a></li>--}}
{{--                        @endif--}}

{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 6))--}}
{{--                            <li class="{{ Request::is('admin/ingredient_purchase') ? 'active' : '' }}"><a--}}
{{--                                    class="nav-link" href="{{route('admin.ingredient_purchase')}}">Ingredient--}}
{{--                                    Purchase</a></li>--}}
{{--                            <li class="{{ Request::is('admin/ingredient_purchase/list') || str_contains(url()->full(),'ingredient_purchase/edit') ? 'active' : '' }}">--}}
{{--                                <a class="nav-link" href="{{route('admin.ingredient_purchase.list')}}">Purchase--}}
{{--                                    History</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 7))--}}
{{--                            <li class="{{ Request::is('admin/supplier') ? 'active' : '' }}">--}}
{{--                                <a class="nav-link" href="{{route('admin.supplier.index')}}">Manage Supplier</a></li>--}}
{{--                        @endif--}}
{{--                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 9 , 8))--}}
{{--                            <li class="{{ Request::is('admin/supplier-history') ? 'active' : '' }}"><a class="nav-link"--}}
{{--                                                                                                       href="{{route('admin.supplier.history')}}">Supplier--}}
{{--                                    History</a></li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}

            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 10 , 1))
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>User Management</span></a>
                    <ul class="dropdown-menu">
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 10 , 1))
                            <li><a class="nav-link" href="{{route('admin.staff.index')}}">Admin/Staff</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 10 , 2))
                            <li><a class="nav-link" href="{{route('admin.customer.index')}}">Coustomer</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 10 , 3))
                            <li><a class="nav-link" href="{{route('admin.waiter.index')}}">Waiters</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 10 , 4))
                            <li><a class="nav-link" href="">Role Groups</a></li>
                        @endif
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 10 , 5))
                            <li><a class="nav-link" href="{{route('admin.delivery.index')}}">Delivery User</a></li>
                        @endif
{{--                        <li><a class="nav-link" href="email-read.html">New Delivery User</a></li>--}}
                    </ul>
                </li>
            @endif

            {{-- Delivery Feedback --}}
    {{--            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 11 , 1))--}}
    {{--                <li><a class="nav-link" href="{{route('admin.delivery.feedback.index')}}"><i--}}
    {{--                            data-feather="star"></i><span>Delivery Feedback</span></a></li>--}}
    {{--            @endif--}}
            {{-- Delivery Feedback --}}
            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 12 , 1))
                <li><a class="nav-link" href="{{route('admin.complete.order.index')}}"><i
                            data-feather="shopping-cart"></i><span>Complete Order</span></a></li>
            @endif

            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 13 , 1))
                <li class="dropdown {{ Request::is('admin/branch') ? 'active' : '' }}">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="copy"></i><span>Restaurant</span></a>
                    <ul class="dropdown-menu">
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 13 , 1))
                            <li class="{{ Request::is('admin/branch') ? 'active' : '' }}"><a class="nav-link"
                                                                                             href="{{route('admin.branch.index')}}">Branches</a>
                            </li>
                        @endif
                        {{--              @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 13 , 2))--}}
                        {{--              <li><a class="nav-link" href="{{route('admin.commission.index')}}">Dept Tags</a></li>--}}
                        {{--              @endif--}}
                        {{--              @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 13 , 3))--}}
                        {{--              <li><a class="nav-link" href="{{route('admin.table.index')}}">Tables</a></li>--}}
                        {{--              @endif--}}
                        {{--              @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 13 , 4))--}}
                        {{--              <li><a class="nav-link" href="{{route('admin.payment.index')}}">Payment Types</a></li>--}}
                        {{--              @endif--}}
                    </ul>
                </li>
            @endif

            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 14 , 1))
                <li class="dropdown">

                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Orders</span></a>
                    <ul class="dropdown-menu">
                        @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 14 , 1))
                            <li><a class="nav-link" href="{{route('admin.order.detail')}}">Details</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 15 , 1))
                <li><a class="nav-link" href="{{route('admin.help.index')}}"><i
                            data-feather="copy"></i><span>Help</span></a></li>
            @endif

            {{--      @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 16 , 1))--}}
            {{--      <li class="dropdown">--}}
            {{--        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Table</span></a>--}}
            {{--        <ul class="dropdown-menu">--}}
            {{--          @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 16 , 1))--}}
            {{--          <li><a class="nav-link" href="{{route('admin.table.qrcode')}}">Qr List</a></li>--}}
            {{--          @endif--}}
            {{--          @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 16 , 2))--}}
            {{--          <li><a class="nav-link" href="{{ route('admin.table.booked_table') }}">Booked Tables Detail</a></li>--}}
            {{--          @endif--}}
            {{--        </ul>--}}
            {{--      </li>--}}
            {{--      @endif--}}

            @if(App\Helpers\MyHelper::checkUserPrivilages(Auth::guard('admin')->user()->id , 17 , 1))
                <li><a class="nav-link" href="{{url('pos-detail')}}"><i data-feather="copy"></i><span>POS</span></a>
                </li>
            @endif

        </ul>
    </aside>
</div>
