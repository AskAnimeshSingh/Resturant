@extends('deliveryboy.layout.layouts')
@section('extra_css')
@endsection

@section('content')
<section class="section">
    <div class="row ">

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="{{ route('deliveryboy.order_list') }}" class="text-decoration-none">
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

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
           <a href="{{ route('deliveryboy.order_list.pending') }}" class="text-decoration-none">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Pending Orders</h5>
                                    <h2 class="mb-3 font-18">{{ $status->whereIn('status', ['COOKING', 'DISPATCHED'])->count() }}</h2>

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


        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="{{ route('deliveryboy.order_list.delivered') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Completed Order</h5>
                                        <h2 class="mb-3 font-18">{{$status->where('status', 'COMPLETED')->count()}}</h2>
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

    </div>
  </section>

@section('extra_js')
<script>

</script>
@endsection
@endsection
