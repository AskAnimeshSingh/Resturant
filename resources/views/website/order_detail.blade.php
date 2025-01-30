


@extends('website.layout.layout')
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
                            <h4>Order Detail List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-striped" id="detail">
                                    <thead>
                                        <tr>
                                             <th>Product Name</th>
                                             <th>Base Price</th>
                                             <th>Size</th>
                                             <th>Quantity</th>
                                             <th>Type</th>
                                             <th>Product Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $data as $dat)
                                        <tr>
                                            <td>{{ $dat->product_name  }}</td>
                                            <td>{{ $dat->price }}</td>
                                            <td></td>
                                            <td>{{ $dat->order_qty}}</td>
                                            <td>{{ $dat->type }}</td>
                                            <td></td>
                                        </tr>
                                            
                                        @endforeach
                                    </tbody>
                              </table>
                              {{ $data->links() }}
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












