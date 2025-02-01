@extends('kitchen.layout.layouts')
@section('extra_css')
@endsection

@section('content')
    <section class="section">
        <div class="row " style="display: flex;justify-content: space-evenly;align-items: center;">

            <div class="" style="width: 19%">
                <a href="{{ route('kitchen.order_list') }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Total Orders</h5>
                                            <h2 class="mb-3 font-18">{{$status->where('status', '!=','CANCELLED')->count()}}</h2>
                                            {{-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img  mr-5 mt-2">
                                            <img src="{{ asset('assets/kitchen/assets/img/dashboard/order.png')}}" alt="" width="40px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="" style="width: 19%">
               <a href="{{ route('kitchen.order_pending_list') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">New Orders</h5>
                                        <h2 class="mb-3 font-18">{{$status->where('status', 'PENDING')->count()}}</h2>
                                        {{-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                    <div class="banner-img  mr-5 mt-2">
                                        <img src="{{ asset('assets/kitchen/assets/img/dashboard/delivery-service.png')}}" alt="" width="40px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               </a>
            </div>
            <div class="" style="width: 19%">
               <a href="{{ route('kitchen.order_cooking_list') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15"> Cooking</h5>
                                        <h2 class="mb-3 font-18">{{$status->where('status', 'COOKING')->count()}}</h2>
                                        {{-- <p class="mb-0"><span class="col-orange">09%</span> Decrease</p> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                    <div class="banner-img  mr-5 mt-2">
                                        <img src="{{ asset('assets/kitchen/assets/img/dashboard/cooking.png')}}" alt="" width="40px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               </a>
            </div>

            <div class="" style="width: 19%">
                <a href="{{ route('kitchen.order_cooked_list') }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Orders Ready</h5>
                                            <h2 class="mb-3 font-18">{{$status->where('status', 'READY')->count()}}</h2>
                                            {{-- <p class="mb-0"><span class="col-green">42%</span> Increase</p> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img  mr-5 mt-2">
                                            <img src="{{ asset('assets/kitchen/assets/img/dashboard/checked.png')}}" alt="" width="40px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

{{--            <div class="" style="width: 19%;">--}}
{{--                <a href="{{ route('kitchen.order_cooked_list') }}" class="text-decoration-none">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-statistic-4">--}}
{{--                            <div class="align-items-center justify-content-between">--}}
{{--                                <div class="row ">--}}
{{--                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">--}}
{{--                                        <div class="card-content">--}}
{{--                                            <h5 class="font-15">Food on the Way</h5>--}}
{{--                                            <h2 class="mb-3 font-18">{{$status->where('status', 'DISPATCHED')->count()}}</h2>--}}
{{--                                            --}}{{-- <p class="mb-0"><span class="col-green">42%</span> Increase</p> --}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">--}}
{{--                                        <div class="banner-img  mr-5 mt-2">--}}
{{--                                            <img src="{{ asset('assets/kitchen/assets/img/dashboard/delivery.png')}}" alt="" width="40px">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}

            <div class="" style="width: 19%">
               <a href="#" class="text-decoration-none">
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Cancelled Order</h5>
                                        <h2 class="mb-3 font-18">{{$status->where('status', 'CANCELLED')->count()}}</h2>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                    <div class="banner-img mr-5 mt-2">
                                        <img src="{{ asset('assets/kitchen/assets/img/dashboard/cancelled.png')}}" alt="" width="40px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               </a>
            </div>
            
        </div>
      
        <div class="col-md-12 mt-4">
            <h4>Pending Orders</h4><br>
            @include('kitchen.PendingOrder.cardpendingorder', ['groups' => $groups, 'chefs' => $chefs, 'dboys' => $dboys])
        </div>
    </section>
    <!-- Include Pending Orders Section -->
   
    @endsection
    {{-- <div class="settingSidebar">
        <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
        </a>
        <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
                <div class="setting-panel-header">Setting Panel
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Select Layout</h6>
                    <div class="selectgroup layout-color w-50">
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="1"
                                class="selectgroup-input-radio select-layout" checked>
                            <span class="selectgroup-button">Light</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="2"
                                class="selectgroup-input-radio select-layout">
                            <span class="selectgroup-button">Dark</span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Sidebar Color</h6>
                    <div class="selectgroup selectgroup-pills sidebar-color">
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                            <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar"
                                checked>
                            <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Color Theme</h6>
                    <div class="theme-setting-options">
                        <ul class="choose-theme list-unstyled mb-0">
                            <li title="white" class="active">
                                <div class="white"></div>
                            </li>
                            <li title="cyan">
                                <div class="cyan"></div>
                            </li>
                            <li title="black">
                                <div class="black"></div>
                            </li>
                            <li title="purple">
                                <div class="purple"></div>
                            </li>
                            <li title="orange">
                                <div class="orange"></div>
                            </li>
                            <li title="green">
                                <div class="green"></div>
                            </li>
                            <li title="red">
                                <div class="red"></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                        <label class="m-b-0">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                id="mini_sidebar_setting">
                            <span class="custom-switch-indicator"></span>
                            <span class="control-label p-l-10">Mini Sidebar</span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                        <label class="m-b-0">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                id="sticky_header_setting">
                            <span class="custom-switch-indicator"></span>
                            <span class="control-label p-l-10">Sticky Header</span>
                        </label>
                    </div>
                </div>
                <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                    <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                        <i class="fas fa-undo"></i> Restore Default
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
@section('extra_js')
    <script></script>
@endsection



