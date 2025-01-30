@extends('admin.layout.layouts')
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
                            <h4>Order Description</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-striped" id="detail">
                                    <thead>
                                        <tr>
                                             <th>Product Name</th>
                                             <th>Package Type</th>
                                             <th>Base Price</th>
                                             <th>Size</th>
                                             <th>Quantity</th>
                                             <th>Extra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $data as $dat)
                                        <tr>
                                            @if($dat->type == "combo")  
                                            <td>{{$dat->package_name}}</td>
                                            @else
                                            <td>{{$dat->product_name}}</td>
                                            @endif

                                            @if($dat->type == "combo")  
                                            <td>{{$dat->type}}</td>
                                            @else
                                            <td>{{$dat->product_type}}</td>
                                            @endif
                                            <td>{{$dat->base_price}}</td>  
                                            <td>{{$dat->size}}</td> 
                                            <td>{{$dat->pro_qty}}</td>  
                                            <td>{{$dat->extra}}</td>   
                                            
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







