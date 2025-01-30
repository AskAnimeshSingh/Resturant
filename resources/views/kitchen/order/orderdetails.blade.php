@extends('kitchen.layout.layouts')
@section('extra_css')
    <style>
        h6 {
            font-size: 13px;
            color: black;
        }

        dt {
            font-size: 16px;
            color: rgb(63, 62, 62);
        }

        #table2 {
            border-collapse: collapse;
        }

        .avatar-container {
            position: relative;
            display: inline-block;
            border-radius: 50%;
            overflow: hidden;
            height: 35px;
            width: 35px;
            padding: 0;
            border: none;
            background: #efefef;
            cursor: pointer;
        }

        .avatar-container .avatar {
            display: block;
            margin: 15px;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            overflow: hidden;
            z-index: 100;
        }

        .avatar-container .info {
            display: none;
            font-weight: bold;
            font-size: 2rem;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 187, 255, 0.2);
            color: white;
            z-index: 1000;
        }

        .avatar-container .info.js-active {
            display: table;
        }

        .avatar-container .info .info-inner {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        .p--50 {
            background-image: linear-gradient(-90deg, #fe4e2b 50%, transparent 50%, transparent), linear-gradient(270deg, #fe4e2b 50%, #efefef 50%, #efefef);
            -webkit-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }

        .p-100 {
            background-image: linear-gradient(90deg, #fe4e2b 50%, transparent 50%, transparent), linear-gradient(270deg, #fe4e2b 50%, #efefef 50%, #efefef);
        }

        .p-50 {
            background-image: linear-gradient(-90deg, #fe4e2b 50%, transparent 50%, transparent), linear-gradient(270deg, #0BF 50%, #efefef 50%, #efefef);
        }

        .p-25 {
            background-image: linear-gradient(90deg, #efefef 50%, transparent 50%, transparent), linear-gradient(180deg, #fe4e2b 50%, #efefef 50%, #efefef);
        }

        /* Stopwatch container */
        .stopwatch {
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Time elements */
        .time {
            font-size: 48px;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            padding: 0 10px;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section body">
            <div class="row">
                <div class="col-12">
                    <div class="content container-fluid item-box-page">
                        <div class="page-header">
                            <h1 class="page-header-title text-capitalize">

                                <span style="font-size: 21px; color:rgb(41, 40, 40);">
                                    Order Details
                                </span>

                            </h1>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-8">
                                <div class="card mb-3 mb-lg-5">

                                    <div class="card-header">
                                        <div class="col align-self-start">
                                            <h1 class="page-header-title mt-2">
                                                <span style="font-size: 21px; color:rgb(41, 40, 40);">
                                                    Order #{{ $order_id }}
                                                </span>
                                                <a class="btn btn--primary m-2 print--btn d-sm-none ml-auto" href="#">
                                                    <i class="mr-1"></i>
                                                </a>
                                            </h1>
                                            <span class="mt-2 d-block">

                                                <i class="fa fa-calendar"></i>&nbsp;
                                                {{ date('d-M-y h:i', strtotime($status->created_at)) }}
                                            </span>
                                            @if ($status->status == 'COOKING')
                                                @php
                                                    $cookStart = $status->cookingstart;
                                                    $current_date = strtotime(date('Y-m-d h:s:i'));
                                                    // $diff = $current_date - $cookStart;
                                                    // echo date('h', $diff);
                                                    // $minutes = date('m', $diff);
                                                    // $seconds = date('s', $diff);
                                                @endphp

                                                <div id="stopWatch"
                                                    style="text-align: center;margin: 1% 0% 4% -55%;font-size: 31px;font-weight: 700;color: green;">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col align-self-center">
                                            @if ($status->status == 'COOKED')
                                                <label for="delivery_id" style="font-weight: bold; color:black;">Select
                                                    Delivery Guy</label>
                                                <select id="deliveryGuy_id" class="form-control" name="delivery_id"
                                                    style="border: 1px solid black; border-radius: 10px;" required>
                                                    <option value="">Select Delivery Guy</option>
                                                    @foreach ($delivery as $del)
                                                        <option value="{{ $del->id }}">{{ $del->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        <div class="col align-self-end">
                                            <div class="text-right">
                                                <a class="tn btn-sm btn-success w-30 "
                                                    href="{{ url('kitchen/order-detail-invoice/' . $status->id) }}">
                                                    <i class=""></i> Print Invoice
                                                </a>

                                            </div>
                                            <div class="text-right mt-3 text-capitalize">
                                                <h6>
                                                    <span>Status :</span>
                                                    <span class="badge badge-soft-info ml-2 ml-sm-3">
                                                        {{ $status->status }}
                                                    </span>
                                                </h6>
                                                <h6>
                                                    <span>
                                                        Payment Method :</span>
                                                    <strong>
                                                        {{ $status->payment_mode }}</strong>
                                                </h6>
                                                <h6>
                                                    <span>Order Type :</span>
                                                    <strong class="text--title">{{ $status->delivery_type }}</strong>
                                                </h6>
                                                <h6>
                                                    <span>Payment Status :</span>
                                                    <strong class="text-success">
                                                        Pending
                                                    </strong>
                                                </h6>


                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="table2"
                                                class="table table-bordered table-thead-bordered table-nowrap card-table no-footer mb-0">
                                                <thead
                                                    style="background-color:#0123ff;  border:none; text-transform: uppercase; font-weight:700;">
                                                    <tr>
                                                        <th style="padding-left: 30px; color: white;">Product Name</th>
                                                        <th style="color: white;">Package Type</th>
                                                        {{--                                                        <th style="color: white;">Base Price</th> --}}
                                                        <th style="color: white;">Quantity</th>
                                                        <th style="color: white;">Assign Chef</th>
                                                        {{--                                                        <th style="color: white;">Total</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $total = 0; ?>
                                                    @foreach ($data as $dat)
                                                        @php
                                                            $id = $dat->combo_pack_id;
                                                        @endphp
                                                        <tr>
                                                            <?php $total += $dat->base_price * $dat->pro_qty; ?>
                                                            <?php $vat = $status->pay_amount - $total; ?>
                                                            @if ($dat->type == 'combo')
                                                                <td style="padding-left: 30px;">
                                                                    {{-- <div class="mb-2">(<span
                                                                            style="font-weight:700">Package Name:</span>
                                                                        <span>{{ $dat->package_name }}</span>)
                                                                    </div> --}}
                                                                    <div class="">

                                                                        <span>
                                                                            @php
                                                                                $combo_products = App\Models\ComboProduct::where(
                                                                                    'pack_id',
                                                                                    $id,
                                                                                )->get();
                                                                            @endphp
                                                                            @php
                                                                                foreach ($combo_products as $co) {
                                                                                    $prod = App\Models\Products::where(
                                                                                        'id',
                                                                                        $co->product_id,
                                                                                    )->get();
                                                                                    foreach ($prod as $key => $value) {
                                                                                        echo '<br>';
                                                                                        echo $value->product_name;
                                                                                    }
                                                                                }

                                                                            @endphp
                                                                        </span>
                                                                    </div>

                                                                </td>
                                                            @else
                                                                <td style="padding-left: 30px;">
                                                                    {{-- <div class=""><span style="font-weight:700"></span> --}}
                                                                    <span>{{ $dat->product_name }}</span>
                                                                    {{-- </div> --}}
                                                                    @if ($dat->toppings != null || $dat->varients != null || $dat->properties != null)
                                                                        <div class=" mt-2"><span
                                                                                style="font-weight:800">Product
                                                                                Details</span></div>
                                                                    @endif
                                                            @endif


                                                            <div class="">
                                                                @if (!empty($dat->toppings) && count(json_decode($dat->toppings)) > 0)
                                                                    <?php $crust = ''; ?>
                                                                    @foreach (json_decode($dat->toppings) as $keyTop => $top)
                                                                        <?php $topping = App\Models\IndItem::where(['id' => $top])->first(); ?>
                                                                        <span style="font-weight:700">Crust
                                                                            :</span><span>{{ $topping->name }}</span><br>

                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    {{ $crust = '' }}
                                                                @endif
                                                            </div>

                                                            <div class="">
                                                                @if (!empty($dat->varients))
                                                                    <?php $varientDetails = App\Models\Variation::where(['id' => $dat->varients])->first(); ?>
                                                                    <span style="font-weight:700">Size :
                                                                    </span><span>{{ $varientDetails->name }}</span>
                                                                @else
                                                                    {{ $varient = '' }}
                                                                @endif
                                                            </div>

                                                            <div class="mb-2">
                                                                @if (!empty($dat->properties) && count(json_decode($dat->properties)) > 0)
                                                                    @php
                                                                        $toppings =
                                                                            '<span style="font-weight:700">Toppings :</span><span>';
                                                                        //                                                        $properties = App\Models\PropertiesItems::whereIn('id', json_decode($dat->properties))->get();
                                                                        $propertiesSides = App\Models\PropertiesSidesInCart::whereIn(
                                                                            'property_id',
                                                                            json_decode($dat->properties),
                                                                        )
                                                                            ->where([
                                                                                'usercart_id' => $dat->cart_id,
                                                                                'product_id' => $dat->product_id,
                                                                            ])
                                                                            ->get();
                                                                        $pWhhole = '';
                                                                        $pLeft = '';
                                                                        $pRight = '';
                                                                        $pQuater = '';
                                                                        foreach ($propertiesSides as $pp) {
                                                                            if ($pp->sides == 'whole') {
                                                                                $pWhhole .=
                                                                                    App\Models\PropertiesItems::where(
                                                                                        'id',
                                                                                        $pp->property_id,
                                                                                    )->first()->name . ', ';
                                                                            }
                                                                            if ($pp->sides == 'left') {
                                                                                $pLeft .=
                                                                                    App\Models\PropertiesItems::where(
                                                                                        'id',
                                                                                        $pp->property_id,
                                                                                    )->first()->name . ', ';
                                                                            }
                                                                            if ($pp->sides == 'right') {
                                                                                $pRight .=
                                                                                    App\Models\PropertiesItems::where(
                                                                                        'id',
                                                                                        $pp->property_id,
                                                                                    )->first()->name . ', ';
                                                                            }
                                                                            if ($pp->sides == 'quarter') {
                                                                                $pQuater .=
                                                                                    App\Models\PropertiesItems::where(
                                                                                        'id',
                                                                                        $pp->property_id,
                                                                                    )->first()->name . ', ';
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    {{--                                                    @foreach ($properties as $keyPOP => $pop) --}}
                                                                    {{--                                                        @php $toppings .= $pop->name . ', '; @endphp --}}
                                                                    {{--                                                    @endforeach --}}
                                                                    <span style="font-weight:700">Toppings:
                                                                        @if (!empty($pWhhole))
                                                                            <div style="font-weight: 500">
                                                                                {!! $pWhhole !!} </div>
                                                                            <div
                                                                                style="display: flex;justify-content: center;">
                                                                                <div class="avatar-container p-100">
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                        @endif
                                                                        @if (!empty($pLeft))
                                                                            <div style="font-weight: 500">
                                                                                {{ $pLeft }} </div>
                                                                            <div
                                                                                style="display: flex;justify-content: center;">
                                                                                <div class="avatar-container p--50">
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                        @endif
                                                                        @if (!empty($pRight))
                                                                            <div style="font-weight: 500">
                                                                                {{ $pRight }} </div>
                                                                            <div
                                                                                style="display: flex;justify-content: center;">
                                                                                <div class="avatar-container p-50">
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                        @endif
                                                                        @if (!empty($pQuater))
                                                                            <div style="font-weight: 500">
                                                                                {{ $pQuater }} </div>
                                                                            <div
                                                                                style="display: flex;justify-content: center;">
                                                                                <div class="avatar-container p-25">
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                        @endif
                                                                    </span><br>
                                                                @endif
                                                            </div>
                                                            {{-- <hr> --}}
                                                            </td>
                                                            <td>{{ $dat->package_name }}</td>
                                                            <td>{{ $dat->pro_qty }}</td>
                                                            <td>
                                                                <select
                                                                    @if (!empty($dat->chef_id)) style="color: green" @endif
                                                                    class="form-control assign_chef" name="chef_id"
                                                                    data-item-id="{{ $dat->id }}"
                                                                    data-order-id="{{ $order_id }}">
                                                                    <option value="" selected style="display: none">
                                                                        Select Chef</option>
                                                                    @foreach ($chefs as $cf)
                                                                        <option value="{{ $cf->id }}"
                                                                            @if ($dat->chef_id == $cf->id) selected @endif>
                                                                            {{ $cf->first_name }} {{ $cf->last_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="container" style="cursor: pointer;">
                                                @if ($status->status == 'PENDING' || $status->status == 'COOKING')
                                                    <button class="statusrdispatch btn btn-sm btn-primary w-100 mb-3 mt-3"
                                                        data-status="READY" data-id={{ $status->id }}>Ready For
                                                        Handover</button>
                                                @elseif ($status->status == 'READY')
                                                    <badge class="badge badge-sm badge-info w-100 mb-3" id="DispatchOrder"
                                                        data-status="DISPATCHED" data-id={{ $status->id }}>
                                                        Cooking Complete, Ready For HandOver</badge>
                                                @elseif ($status->status == 'COMPLETED')
                                                    <button class="btn btn-sm btn-success w-100 mb-3">Takeaway Completed
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-4 order-print-area-right">

                                <div class="card mb-2">

                                    {{-- <div class="card-header border-0 py-0">
                                        <h4 class="card-header-title border-bottom py-3 m-0  w-100 text-center">Order Setup
                                        </h4>
                                    </div>


                                    <div class="card-body">
                                        @if ($status->status == 'COOKING')
                                            @php
                                                $cookStart = $status->cookingstart;                                          
                                            @endphp

                                            <div id="stopWatch" style="text-align: center;margin: 1% 0% 4% 0%;font-size: 31px;font-weight: 700;color: green;"></div>

                                        @endif


                                        @if ($status->delivery_type == 'Take Away')
                                            <div class="order-btn-wraper">
                                            
                                                @if ($status->status == 'PENDING' || $status->status == 'COOKING')

                                                    <table id="table2"
                                                        class="table table-bordered table-thead-bordered table-nowrap card-table no-footer mb-0">
                                                        <thead
                                                            style="background-color:#0123ff;  border:none; text-transform: uppercase; font-weight:700;">
                                                        <tr>
                                                            <th style="padding-left: 30px; color: white;">Product Name</th>
                                                            <th style="color: white;">Assign Chef</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $total = 0; ?>
                                                        @foreach ($data as $dat)
                                                            @php
                                                                $id = $dat->combo_pack_id;
                                                            @endphp
                                                            <tr>
                                                                    <?php $total += $dat->base_price * $dat->pro_qty; ?>
                                                                    <?php $vat = $status->pay_amount - $total; ?>
                                                                @if ($dat->type == 'combo')
                                                                    <td style="padding-left: 30px;">
                                                                        <div class="">

                                                                            <span>
                                                                                <b>{{ $dat->package_name }}</b>
                                                                                <br>
                                                                                <b>Quantity:</b> {{ $dat->pro_qty }}
                                                                                @php
                                                                                    $combo_products = App\Models\ComboProduct::where('pack_id', $id)->get();
                                                                                    foreach ($combo_products as $co) {
                                                                                        $prod = App\Models\Products::where('id', $co->product_id)->get();
                                                                                        foreach ($prod as $key => $value) {
                                                                                            echo '<br>';
                                                                                            echo $value->product_name.', ';
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td style="padding-left: 30px;">
                                                                        <span>{{ $dat->product_name }}</span>
                                                                        <br>
                                                                        <b>Quantity:</b> {{ $dat->pro_qty }}
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    <select @if (!empty($dat->chef_id)) style="color: green" @endif  class="form-control assign_chef" name="chef_id" data-item-id="{{$dat->id}}">
                                                                        <option value="" selected style="display: none">Select Chef</option>
                                                                        @foreach ($chefs as $cf)
                                                                            <option value="{{$cf->id}}" @if ($dat->chef_id == $cf->id) selected @endif>{{$cf->first_name}} {{$cf->last_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                    <button class="statusrdispatch btn btn-sm btn-primary w-100 mb-3 mt-3"
                                                            data-status="READY" data-id={{ $status->id }}>Ready For
                                                        Handover</button>
                                                @elseif ($status->status == 'READY')
                                                    <badge class="badge badge-sm badge-info w-100 mb-3">Cooking Complete, Ready For HandOver</badge>
                                                @elseif ($status->status == 'COMPLETED')
                                                    <button class="btn btn-sm btn-success w-100 mb-3">Takeaway Completed
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <div class="order-btn-wraper">
                                            
                                                @if ($status->status == 'PENDING' || $status->status == 'COOKING')

                                                    <table id="table2"
                                                        class="table table-bordered table-thead-bordered table-nowrap card-table no-footer mb-0">
                                                        <thead
                                                            style="background-color:#0123ff;  border:none; text-transform: uppercase; font-weight:700;">
                                                        <tr>
                                                            <th style="padding-left: 30px; color: white;">Product Name</th>
                                                            <th style="color: white;">Assign Chef</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $total = 0; ?>
                                                        @foreach ($data as $dat)
                                                            @php
                                                                $id = $dat->combo_pack_id;
                                                            @endphp
                                                            <tr>
                                                                    <?php $total += $dat->base_price * $dat->pro_qty; ?>
                                                                    <?php $vat = $status->pay_amount - $total; ?>
                                                                @if ($dat->type == 'combo')
                                                                    <td style="padding-left: 30px;">
                                                                        <div class="">

                                                                            <span>
                                                                                <b>{{ $dat->package_name }}</b>
                                                                                <br>
                                                                                <b>Quantity:</b> {{ $dat->pro_qty }}
                                                                                @php
                                                                                    $combo_products = App\Models\ComboProduct::where('pack_id', $id)->get();
                                                                                    foreach ($combo_products as $co) {
                                                                                        $prod = App\Models\Products::where('id', $co->product_id)->get();
                                                                                        foreach ($prod as $key => $value) {
                                                                                            echo '<br>';
                                                                                            echo $value->product_name.', ';
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td style="padding-left: 30px;">
                                                                        <span>{{ $dat->product_name }}</span>
                                                                        <br>
                                                                        <b>Quantity:</b> {{ $dat->pro_qty }}
                                                                    </td>
                                                                @endif
                                                                    <td>
                                                                        <select @if (!empty($dat->chef_id)) style="color: green" @endif  class="form-control assign_chef" name="chef_id" data-item-id="{{$dat->id}}">
                                                                            <option value="" selected style="display: none">Select Chef</option>
                                                                            @foreach ($chefs as $cf)
                                                                                <option value="{{$cf->id}}" @if ($dat->chef_id == $cf->id) selected @endif>{{$cf->first_name}} {{$cf->last_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                    <button class="statusrdispatch btn btn-sm btn-primary w-100 mb-3 mt-3"
                                                        data-status="READY" data-id={{ $status->id }}>Ready For
                                                        Handover</button>
                                                @elseif ($status->status == 'READY')
                                                    <badge class="badge badge-sm badge-info w-100 mb-3">Cooking Complete, Ready For HandOver</badge>
                                                @elseif ($status->status == 'DISPATCHED')
                                                    <button class="btn btn-sm btn-info w-100 mb-3">Food on the way</button>
                                                @elseif ($status->status == 'COMPLETED')
                                                    <button class="btn btn-sm btn-success w-100 mb-3">Delivered</button>
                                                @endif
                                            </div>
                                        @endif
                                    </div> --}}
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <span class="card-header-icon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <span style="font-size: 15px;">
                                                Customer Information
                                            </span>
                                        </h5>
                                        <div class="media align-items-center deco-none customer--information-single"
                                            href="javascript:">
                                            <div class="avatar avatar-circle">
                                                <img class="avatar-img  initial-81"
                                                    onerror="this.src='https://stackfood-admin.6amtech.com/public/assets/admin/img/resturant-panel/customer.png'"
                                                    src="https://stackfood-admin.6amtech.com/public/assets/admin/img/resturant-panel/customer.png"
                                                    alt="Image Description">
                                            </div>
                                            <div class="ml-3">
                                                <span class="fz--14px text-title font-semibold text-hover-primary d-block">
                                                    {{ $status->uname }}
                                                </span>
                                                <span class="d-block">
                                                    <strong class="text--title font-semibold">
                                                        <?php $ct = App\Models\WebOrder::where('user_id', $status->user_id)->count(); ?>
                                                        {{ $ct }}
                                                    </strong>
                                                    Orders
                                                </span>
                                                <span class="d-block">
                                                    <a class="text--title font-semibold" href="tel:+8801879762951">
                                                        <strong>
                                                            {{ $status->uphone }}
                                                        </strong>
                                                    </a>
                                                </span>
                                                <span class="d-block">
                                                    <strong class="text--title font-semibold">
                                                    </strong>
                                                    {{ $status->uemail }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($status->status == 'READY')
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <span class="card-header-icon">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <span style="font-size: 15px;">
                                                    Assign Delivery Guy
                                                </span>
                                            </h5>
                                            <div class="media align-items-center deco-none customer--information-single"
                                                href="javascript:">
                                                <form class="store_deliveryboy w-100 select2" method="POST">
                                                    @csrf
                                                    <div id="AssignedDeliveryGuyDetails" style="display: block;">
                                                        <div
                                                            class="deliveryboyimage d-flex justify-content-center align-items-center">
                                                            <img id="deliveryGuyImage"
                                                                src=" {{ asset($AssignedDelivery->image) }}"
                                                                alt="Delivery Guy Image"
                                                                style="width:120px; height :60px; border : 3px solid black; border-radius : 20px;">
                                                        </div>
                                                        <strong>Name :</strong>
                                                        <p>{{ $AssignedDelivery->name }} </p>
                                                        <strong>Email : </strong>
                                                        <p>{{ $AssignedDelivery->email }}</p>
                                                        <strong>Phone : </strong>
                                                        <p>{{ $AssignedDelivery->phone }}</p>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">
                                                <span class="card-header-icon">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <span style="font-size: 15px">
                                                    Delivery Information
                                                </span>
                                            </h5>
                                        </div>
                                        @if ($status->delivery_type === 'Take Away')
                                            <div class="mt-3">


                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Delivery Type :</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>Take Away</strong>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Branch :</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $branchss->address }}</strong>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Name &nbsp;&nbsp;&nbsp;:</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $status->uname }}</strong>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Contact :</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $status->uphone }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-3">

                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Delivery Type :</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>Home Delivery</strong>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Name &nbsp;&nbsp;&nbsp;:</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $status->uname }}</strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Contact :</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $status->uphone }}</strong>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>House &nbsp;&nbsp;:</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $status->house }}</strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Floor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $status->apartment }}</strong>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span>Street &nbsp;&nbsp;&nbsp;:</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <strong>{{ $status->street }}</strong>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif

                                    </div>
                                </div>
                                @if ($status->status != 'PENDING' && $status->status != 'COOKING')
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="table2"
                                                class="table table-bordered table-thead-bordered table-nowrap card-table no-footer mb-0">
                                                <thead
                                                    style="background-color:#0123ff;  border:none; text-transform: uppercase; font-weight:700;">
                                                    <tr>
                                                        <th style="padding-left: 30px; color: white;">Product Name</th>
                                                        <th style="color: white;">Assign Chef</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $total = 0; ?>
                                                    @foreach ($data as $dat)
                                                        @php
                                                            $id = $dat->combo_pack_id;
                                                        @endphp
                                                        <tr>
                                                            <?php $total += $dat->base_price * $dat->pro_qty; ?>
                                                            <?php $vat = $status->pay_amount - $total; ?>
                                                            @if ($dat->type == 'combo')
                                                                <td style="padding-left: 30px;">
                                                                    <div class="">

                                                                        <span>
                                                                            <b>{{ $dat->package_name }}</b>
                                                                            <br>
                                                                            <b>Quantity:</b> {{ $dat->pro_qty }}
                                                                            @php
                                                                                $combo_products = App\Models\ComboProduct::where(
                                                                                    'pack_id',
                                                                                    $id,
                                                                                )->get();
                                                                                foreach ($combo_products as $co) {
                                                                                    $prod = App\Models\Products::where(
                                                                                        'id',
                                                                                        $co->product_id,
                                                                                    )->get();
                                                                                    foreach ($prod as $key => $value) {
                                                                                        echo '<br>';
                                                                                        echo $value->product_name .
                                                                                            ', ';
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td style="padding-left: 30px;">
                                                                    <span>{{ $dat->product_name }}</span>
                                                                    <br>
                                                                    <b>Quantity:</b> {{ $dat->pro_qty }}
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <select
                                                                    @if (!empty($dat->chef_id)) style="color: green" @endif
                                                                    class="form-control" readonly="" disabled>
                                                                    <option value="" selected style="display: none">
                                                                        Select Chef</option>
                                                                    @foreach ($chefs as $cf)
                                                                        <option value="{{ $cf->id }}"
                                                                            @if ($dat->chef_id == $cf->id) selected @endif>
                                                                            {{ $cf->first_name }} {{ $cf->last_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal with form -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Delivery Boys List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col align-self-center">
                        <label for="deliveryGuy_id" style="font-weight: bold; color:black;">Select Delivery Guy</label>
                        <select id="deliveryGuy_id" class="form-control" name="delivery_id"
                            style="border: 1px solid black; border-radius: 10px;" required>
                            <option value="">Select Delivery Guy</option>
                            @foreach ($delivery as $del)
                                <option value="{{ $del->id }}">{{ $del->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <span class="card-header-icon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <span style="font-size: 15px;">
                                    Assign Delivery Guy
                                </span>
                            </h5>
                            <div class="media align-items-center deco-none customer--information-single">
                                <form action="{{ route('kitchen.order.store_delivery_boy') }}"
                                    class="store_deliveryboy w-100" method="POST">
                                    @csrf
                                    <div id="deliveryGuyDetails" style="display: none;">
                                        <div class="deliveryboyimage d-flex justify-content-center align-items-center">
                                            <img id="deliveryGuyImage" src="" alt="Delivery Guy Image"
                                                style="width: 100px; height: 100px;">
                                        </div>
                                        <p id="deliveryGuyName"></p>
                                        <p id="deliveryGuyEmail"></p>
                                        <p id="deliveryGuyPhone"></p>
                                        <p id="deliveryGuyStatus"></p>
                                    </div>
                                    <input type="hidden" id="deliveryGuyId" name="delivery_id" value="">
                                    <input type="hidden" id="delivery_order_id" name="delivery_order_id"
                                        value="{{ $order_id }}">
                                    <input type="hidden" name="status" value="READY">
                                    <input type="hidden" name="id" value="{{ $status->id }}">
                                    <div id="delivery_store_button_container">
                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect w-100"
                                            id="delivery_store_button">Assign</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@section('extra_js')
    <script src="https://www.jqueryscript.net/demo/simple-rap-stopwatch/jsRapStopwatch.js?v5"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

        });
    </script>
    <script>
        @if ($status->status == 'COOKING')
            $(function() {
                myStopWatch = $('#stopWatch').jsRapStopwatch({
                    enabled: false
                })[0];
                let d = '{{ $cookStart }}';
                myStopWatch.opt.timeStart.setTime(Date.parse(d));
            });
        @endif




        $("body").on("change", ".assign_chef", function(e) {
            e.preventDefault()
            var web_order_product_id = $(this).attr('data-item-id')
            var web_order_id = $(this).attr('data-order-id')
            var chef_id = $(this).find(":selected").val();
            let fd = new FormData()
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('web_order_product_id', web_order_product_id);
            fd.append('web_order_id', web_order_id);
            fd.append('chef_id', chef_id);
            $.ajax({
                url: "{{ route('kitchen.assign.chef') }}",
                type: "POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {

                },
                success: function(result) {
                    console.log(result);
                    if (result.status) {
                        iziToast.success({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

                    } else {
                        iziToast.error({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                    }
                },
                complete: function() {
                    $('.loader').hide();
                },
                error: function(jqXHR, exception) {
                    $('.loader').hide();
                    console.log(jqXHR.responseText);
                }
            });

        })

        $("#DispatchOrder").click(".statusaapprove,.statuscancel", function(e) {

            e.preventDefault();
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            let fd = new FormData()
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('status', status);
            fd.append('id', id);

            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to change status?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('kitchen.update.order.status.approve') }}",
                                type: 'POST',
                                data: fd,
                                dataType: "JSON",
                                contentType: false,
                                processData: false,
                            })
                            .done(function(result) {
                                if (result.status) {
                                    iziToast.success({
                                        title: '',
                                        message: result.msg,
                                        position: 'topRight'
                                    });
                                    window.location.reload();
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);


                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: result.msg,
                                        position: 'topRight'
                                    });
                                }
                            })
                            .fail(function(jqXHR, exception) {
                                console.log(jqXHR.responseText);
                            })


                    },
                    no: function() {},
                }
            })
        })

        $("body").on("click", ".statuscooking,.statusrdispatch", function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            let fd = new FormData()
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('status', status);
            fd.append('id', id);

            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to change status?',
                buttons: {
                    yes: function() {
                        $('#editModal').modal('show');
                    },
                    no: function() {},
                }
            })
        })

        $("#deliveryGuy_id").change(function() {
            var id = $(this).val();
            var assetBaseUrl = '{{ asset('') }}';
            $.get('{{ route('kitchen.order.get_delivery_boy.detail', ':id') }}'.replace(':id', id), function(
                deliveryboy) {
                if (deliveryboy.data) {
                    var data = deliveryboy.data;
                    // Populate the delivery guy details
                    $("#deliveryGuyImage").attr("src", assetBaseUrl + data.image).css({
                        'width': '120px',
                        'height': '60px',
                        'border': '3px solid black',
                        'border-radius': '20px'
                    });
                    $("#deliveryGuyName").text("Name: " + data.name);
                    $("#deliveryGuyEmail").text("Email: " + data.email);
                    $("#deliveryGuyPhone").text("Phone: " + data.phone);
                    $("#deliveryGuyId").val(id);
                    // Show the details section

                    $("#deliveryGuyDetails").show();
                }
            }).fail(function() {
                console.log("detail doesn't found");
            });

            $.get('{{ route('kitchen.order.check_delivery_count', ':id') }}'.replace(':id', id), function(
                response) {
                if (response.success) {
                    $("#deliveryGuyStatus").html(
                        '<span class="badge text-white bg-success badge-md w-50">Pending Deliveries :- ' +
                        response.count + '</span>'
                    );
                } else {
                    console.log("Error fetching delivery guy status");
                }
            }).fail(function() {
                console.log("AJAX request failed");
            });

        });

        function updateDeliveryGuyOptions() {
            $.get('{{ route('kitchen.order.count_orders_by_delivery_guys') }}', function(response) {
                if (response.success) {
                    // Clear current options
                    $('#deliveryGuy_id').empty();

                    // Add default option
                    $('#deliveryGuy_id').append('<option value="">Select Delivery Guy</option>');

                    // Add options for each delivery guy
                    response.deliveryGuys.forEach(function(deliveryGuy) {
                        $('#deliveryGuy_id').append(
                            `<option value="${deliveryGuy.id}" data-delivery-id="${deliveryGuy.id}">${deliveryGuy.name} (Orders: ${deliveryGuy.orders_count})</option>`
                        );
                    });
                }
            }).fail(function() {
                console.log("Failed to fetch delivery guy data");
            });
        }


        // Call the function on document ready
        updateDeliveryGuyOptions();

        $("body").on('submit','#delivery_store_button',  function(e) {
            e.preventDefault();
            let fd = new FormData(this);
            fd.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('kitchen.order.store_delivery_boy') }}",
                type: "POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.status) {
                        iziToast.success({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                        setTimeout(function() {
                            window.location.reload(); // Reload the page after 2 seconds
                        }, 2000);
                    } else {
                        iziToast.error({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: '',
                        message: "Error occurred: " + textStatus,
                        position: 'topRight'
                    });
                    console.error("AJAX Error: " + errorThrown);
                }
            });
        });


        $("body").on("click", ".takeaway", function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            let fd = new FormData()
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('status', status);
            fd.append('id', id);

            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to change status?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('kitchen.update.order.status.takeaway') }}",
                                type: 'POST',
                                data: fd,
                                dataType: "JSON",
                                contentType: false,
                                processData: false,
                            })
                            .done(function(result) {
                                if (result.status) {
                                    iziToast.success({
                                        title: '',
                                        message: result.msg,
                                        position: 'topRight'
                                    });


                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);

                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: result.msg,
                                        position: 'topRight'
                                    });
                                }
                            })
                            .fail(function(jqXHR, exception) {
                                console.log(jqXHR.responseText);
                            })


                    },
                    no: function() {},
                }
            })
        })
    </script>
@endsection
@endsection
