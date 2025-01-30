@extends('kitchen.layout.layouts')
@section('extra_css')
    <style>
        .hp-13{
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
        }

        .hp-12{
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-weight: 600;
        }
        .font-light{
            font-weight: 400;
        }
        dt{
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-weight: 600;
        }

        dd{
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-weight: 400;
        }
        .pymnt{
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-weight: 400;
        }
        .thnk{
            font-size: 21px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-weight: 700;
        }


    </style>

@endsection

@section('content')
    <section class="section">
        <div class="section body">
            <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')" value="Print" fdprocessedid="s93gho">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    {{-- <center>
                        <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                            value="Proceed, If thermal printer is ready." fdprocessedid="mis3ae">
                        <a href="https://stackfood-admin.6amtech.com/restaurant-panel/order/details/100068"
                            class="btn btn-danger non-printable">Back</a>
                    </center> --}}
                    <hr class="non-printable" >
                    <div class="row justify-content-center" id="printableArea">
                        <div class="col-5">
                            <div class="row justify-content-center">
                                <img src="https://stackfood-admin.6amtech.com/public/assets/admin/img/restaurant-invoice.png"
                                    class="initial-38-2" alt="">
                            </div>
                            <div class="text-center pt-2 mb-3">
                                <h2 class="hp-13">XYZ FOOD</h2>
                                <h5 class="text-break hp-13">
                                    House: {{ $status->house }},  Floor: {{ $status->apartment }}, Street: {{ $status->street }}, City: {{ $status->city }}
                                </h5>
                                <h5 class="hp-13">
                                    <span>Phone</span> <span>:</span> <span>{{ $status->uphone }}</span>
                                </h5>
                            </div>
                            <span
                                class="initial-38-5">---------------------------------------------------------------------------------</span>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <h5 class="hp-12">Order ID :
                                        <span class="font-light"> {{$order_id}} </span>
                                    </h5>
                                </div>
                                <div class="col-6">
                                    <span class="font-light">
                                        {{ date('Y-m-d H:i:s') }}

                                    </span>
                                </div>
                                <div class="col-12">
                                    <h5 class="hp-12">
                                        Customer Name :
                                        <span class="font-light">
                                            {{ $status->uname }}
                                        </span>
                                    </h5>
                                    @if ($status->delivery_type === 'Take Away')
                                    <h5 class="hp-12">
                                        Delivery Type :
                                        <span class="font-light">
                                            Take Away
                                        </span>
                                    </h5>
                                    <h5 class="hp-12">
                                        Branch :
                                        <span class="font-light">
                                            {{$branchss->address}}
                                        </span>
                                    </h5>
                                    @else
                                    <h5 class="hp-12">
                                        Delivery Type :
                                        <span class="font-light">
                                            Home Delivery
                                        </span>
                                    </h5>
                                    <h5 class="hp-12">
                                        Phone :
                                        <span class="font-light">
                                            +{{ $status->uphone }}
                                        </span>
                                    </h5>
                                    <h5 class="hp-12">
                                        Address :
                                        <span class="font-light">
                                            {{ $status->house }}, {{ $status->apartment }}, {{ $status->street }}, {{ $status->city }}, {{ $status->state }}
                                        </span>
                                    </h5>
                                    @endif

                                </div>
                            </div>
                            <h5 class="text-uppercase"></h5>
                            <span
                                class="initial-38-5">---------------------------------------------------------------------------------</span>
                            <table class="table table-bordered mt-1 mb-1">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Package Type</th>
                                        <th>Base Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                                    @foreach ($data as $key => $dat)
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
                                                                        $combo_products = App\Models\ComboProduct::where('pack_id', $id)->get();
                                                                    @endphp
                                                                    @php
                                                                        foreach ($combo_products as $co) {
                                                                            $prod = App\Models\Products::where('id', $co->product_id)->get();
                                                                            foreach ($prod as $key => $value) {
                                                                                echo '<br>';
                                                                                echo $value->product_name;
                                                                            }
                                                                        }

                                                                    @endphp
                                                                </span>
                                                            </div>


                                </div>

                                </td>
                            @else
                                <td style="padding-left: 30px;">
                                    {{-- <div class=""><span style="font-weight:700"></span> --}}
                                        <span>{{ $dat->product_name }}</span>
                                    {{-- </div> --}}
                                    @if ($dat->toppings != null || $dat->varients != null || $dat->properties != null)
                                        <div class=" mt-2"><span style="font-weight:800">Product
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
                                                $toppings = '<span style="font-weight:700">Toppings :</span><span>';
                                                $properties = App\Models\PropertiesItems::whereIn('id', json_decode($dat->properties))->get();
                                            @endphp
                                            @foreach ($properties as $keyPOP => $pop)
                                                @php $toppings .= $pop->name . ', '; @endphp
                                            @endforeach
                                            {!! $toppings !!}</span><br>
                                        @endif
                                    </div>
                                    {{-- <hr> --}}
                                </td>

                                <td>{{ $dat->package_name }}</td>
                                <td>{{ $dat->base_price }}</td>
                                <td>{{ $dat->pro_qty }}</td>
                                <td>{{ $dat->base_price * $dat->pro_qty }}</td>

                                </tr>
                                                    @endforeach
                                </tbody>
                            </table>
                            <span
                                class="initial-38-5">---------------------------------------------------------------------------------</span>
                            <div class="mb-2 initial-38-9">
                                <div class="px-3">
                                    <dl class="row text-right">
                                        <?php $sub_total = $total; ?>


                                        @if ($dat->toppings != null || $dat->varients != null || $dat->properties != null)
                                        <dt class="col-6 text-left">Addons:
                                        </dt>
                                        <dd class="col-6 text-right">
                                            + $ {{($status->pay_amount + $status->discount_value) - ($total + $status->tax + $status->delivery_charge)}}

                                        </dd>
                                        @endif
                                    <dt class="col-6 text-left">Sub Total:
                                    </dt>
                                    <dd class="col-6 text-right">
                                        + $ {{ $total + (($status->pay_amount + $status->discount_value) - ($total + $status->tax + $status->delivery_charge)) }}

                                    </dd>
                                    <dt class="col-6 text-left">Tax (Included):
                                    </dt>
                                    <dd class="col-6 text-right">
                                        + $ {{ $status->tax }}

                                    </dd>
                                    <dt class="col-6 text-left">Discount Price:
                                    </dt>
                                    <dd class="col-6 text-right">
                                        - $ {{ $status->discount_value }}
                                    </dd>
                                    <dt class="col-6 text-left">Delivery Charge:
                                    </dt>
                                    <dd class="col-6 text-right">
                                        @if ($status->delivery_type === 'Home Delivery')
                                        + $ {{ $status->delivery_charge }}
                                        @endif
                                    </dd>
                                    <hr>
                                    <dt class="col-6 text-left">Total:</dt>
                                    <dd class="col-6 text-right">
                                        $ {{ $status->pay_amount }}
                                    </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-between border-top pt-3">
                                <span class="pymnt d-flex"><span>Payment Method</span> <span>:</span> <span> &nbsp; {{ $status->payment_mode }}</span></span>
                            </div>
                            <span
                                class="initial-38-7">-------------------------------------------------------------------</span>
                            <h5 class="text-center pt-1 justify-content-center">
                                <span class="thnk d-block">"""THANK YOU"""</span>
                            </h5>
                            <span
                                class="initial-38-7">-------------------------------------------------------------------</span>
                            <span class="d-block text-center">© 2023 Restaurant Pos. All rights reserved.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('extra_js')
{{-- <script>
    $('#print-button').click(function() {

     $('#invoice').show();
     window.print();
    });
  </script> --}}
  <script>
    function printDiv(divName) {

        if($('html').attr('dir') === 'rtl') {
            $('html').attr('dir', 'ltr')
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            $('.initial-38-1').attr('dir', 'rtl')
            window.print();
            document.body.innerHTML = originalContents;
            $('html').attr('dir', 'rtl')
            location.reload();
        }else{
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }

    }

        //     function printDiv(tagid) {

        // var hashid = "#"+ tagid;
        //     var tagname =  $(hashid).prop("tagName").toLowerCase() ;
        //     var attributes = "";
        //     var attrs = document.getElementById(tagid).attributes;
        //     $.each(attrs,function(i,elem){
        //         attributes +=  " "+  elem.name+" ='"+elem.value+"' " ;
        //     })
        //     var divToPrint= $(hashid).html() ;
        //     var head = "<html><head>"+ $("head").html() + "</head>" ;
        //     var allcontent = head + "<body  onload='window.print()' >"+ "<" + tagname + attributes + ">" +  divToPrint + "</" + tagname + ">" +  "</body></html>"  ;
        //     var newWin=window.open('','Print-Window');
        //     newWin.document.open();
        //     newWin.document.write(allcontent);
        //     newWin.document.close();

        // }
</script>
@endsection
@endsection
