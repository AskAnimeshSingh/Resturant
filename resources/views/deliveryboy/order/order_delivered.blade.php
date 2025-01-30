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
                            <h4>Today's Delivered List</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col col-lg-6">
                                    <div class="deliveryGuy">
                                        <label for="SelectDeliveryGuy" style="color:grey; font-weight:bolder;">Delivery
                                            Guy</label>
                                        <select name="SelectDeliveryGuy" style="border: 1px solid grey;"
                                            class="form-control" id="deliveryGuyId">
                                            <option value="">Select Delivery Guy</option>
                                            @foreach ($deliveryGuys as $val)
                                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="orderDetailsContainer" class="card">
                        <div class="card-body">
                            <div class="row" id="orderDetailsContent">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="detail">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>User Name</th>
                                                <th>User Address</th>
                                                <th>User Phone</th>
                                                <th>Status</th>
                                                <th>View Details</th>
                                            </tr>
                                        </thead>
                                        <tbody id="orderDetailsTableBody">
                                            <!-- Data will be inserted here via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('extra_js')
    <script>
        $(document).ready(function() {
            $('#deliveryGuyId').change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '{{ route('kitchen.deliveryboy.order_list.delivered.ajax', ':id') }}'
                            .replace(':id', id),
                        method: 'GET',
                        success: function(response) {
                            $('#orderDetailsTableBody').empty();
                            if (response.data.length > 0) {
                                response.data.forEach(function(order) {
                                    var viewProductUrl =
                                        '{{ route('kitchen.deliveryboy.view_product.details', ':id') }}'
                                        .replace(':id', order[5]);
                                    var orderRow = `
                                    <tr>
                                        <td>${order[0]}</td>
                                        <td>${order[1]}</td>
                                        <td>${order[2]}</td>
                                        <td>${order[3]}</td>
                                        <td>${order[4]}</td>
                                    <td><a href="${viewProductUrl}" class="btn btn-warning btn-sm">View Order Details</a></td>
                                    </tr>
                                `;
                                    $('#orderDetailsTableBody').append(orderRow);
                                });
                            } else {
                                $('#orderDetailsTableBody').append(
                                    '<tr><td colspan="6" class="text-center">No orders found</td></tr>'
                                );
                            }
                        },
                        error: function() {
                            alert('Error fetching data');
                        }
                    });
                }
            });
        });
    </script>
@endsection
@endsection
