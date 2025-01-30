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
                            <h4>Delivery Boy Queue</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="detail">
                                    <thead>
                                        <tr>
                                            <th>Priority</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deliveryBoys as $deliveryBoy)
                                            <tr>
                                                <td></td>
                                                <td>{{ $deliveryBoy->name }}</td>
                                                <td><img src="{{ asset($deliveryBoy->image) }}" alt=""
                                                        style="width: 5rem; height:3rem"></td>
                                                <td>
                                                    @if ($deliveryBoy->status == 'COMPLETED')
                                                        <span class="badge text-white bg-danger">Not-Available</span>
                                                    @else
                                                        <span class="badge text-white bg-success">Available</span>
                                                    @endif
                                                </td>
                                                <td>{{ $deliveryBoy->last_completed_order ? $deliveryBoy->last_completed_order->format('d-m-Y H:i') : 'N/A' }}</td>
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
