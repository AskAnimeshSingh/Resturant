{{-- @extends('deliveryboy.layout.layouts') --}}
@extends('kitchen.layout.layouts')
@section('extra_css')
    <style>
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header float-right">
                            <h4>Product Details</h4>

                        </div>
                        <div class="card-body">
                           <div class="mb-3">
                            <span>Payment Mode: <span style="color:black; font-weight:600;">{{$dtype->payment_mode}}</span></span>

                           </div>
                           <div class="mb-3"><span>Payment Status: <span style="color:black; font-weight:600;">{{$dtype->payment_status}}</span></span></div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="detail">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $dat)
                                            @php
                                                $id = $dat->combo_pack_id;
                                            @endphp
                                            <tr>
                                                @if ($dat->type == 'combo')
                                                    <td style="padding-left: 30px;">
                                                        {{-- <div class="mb-2">(<span style="font-weight:700">Package Name:</span>
                                                        <span>{{ $dat->package_name }}</span>)</div> --}}
                                                        <div>
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
                                                    </td>
                                                @else
                                                    <td style="padding-left: 30px;">
                                                        <span>{{ $dat->product_name }}</span>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </section>




    @section('extra_js')

    @endsection
@endsection
