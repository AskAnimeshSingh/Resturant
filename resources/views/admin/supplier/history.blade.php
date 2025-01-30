@extends('admin.layout.layouts')
@section('extra_css')
    <style>
        .tableCellHeight {
            height: 35px !important;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Supplier History </h4>
                        </div>

                        <div class="card-body">
                            <form action="{{route('admin.supplier.history')}}" method="get">
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <label for="from">From</label>
                                        <input type="date" name="from" class="form-control" value="<?php
                                        if (isset($_GET['from'])) {
                                            echo $_GET['from'];
                                        }
                                        ?>" id="from" required>
                                    </div>
                                    <div class="col-2">
                                        <label for="to">To</label>
                                        <input type="date" name="to" class="form-control" value="<?php
                                        if (isset($_GET['to'])) {
                                            echo $_GET['to'];
                                        }
                                        ?>" id="to" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="to">Supplier</label>
                                        <select name="supplier" class="form-control" required>
                                            <option value="" selected disabled>Select Supplier</option>
                                            @foreach($supplier as $getSupplier)
                                                <option value="{{$getSupplier->id}}" <?php
                                                    if (isset($_GET['supplier'])) {
                                                        if ($_GET['supplier'] == $getSupplier->id) {
                                                            echo "selected";
                                                        }
                                                    }
                                                    ?>>{{$getSupplier->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label>Select Type</label>
                                        <select name="type" class="form-control" required>
                                            <option value="" selected disabled>Select One</option>
                                            <option value="food" <?php
                                                if (isset($_GET['type'])) {
                                                    if ($_GET['type'] === 'food') {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Food
                                            </option>
                                            <option value="ingredient" <?php
                                                if (isset($_GET['type'])) {
                                                    if ($_GET['type'] === 'ingredient') {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>>Ingredient
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label class="text-white">Filter</label>
                                        <input type="submit" value="Filter" class="btn btn-danger btn-block btn-lg">
                                    </div>
                                </div>
                            </form>

                            @if(count($data)>0)
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Supplier</th>
                                            <th>Invoice</th>
                                            <th>Purchased</th>
                                            <th>Total</th>
                                            <th>Due</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $key => $val)
                                            <tr>
                                                <td class="text-center">{{++$key}}</td>
                                                <td>{{$val->name}}</td>
                                                <td>{{$val->invoice}}</td>
                                                <td>{{date('F d, Y', strtotime($val->purchase_date))}}</td>
                                                <td>$ {{$val->totalAmount}}</td>
                                                <td>$ {{$val->dueAmount}}</td>
                                                <td><a href="#" class="btn btn-success btn-sm viewDetails"
                                                       data-id="{{$val->id}}"
                                                       data-invoice="{{$val->invoice}}"
                                                       data-purchase="{{date('F d, Y', strtotime($val->purchase_date))}}"
                                                       data-total="{{$val->totalAmount}}"
                                                       data-paid="{{$val->paidAmount}}"
                                                       data-due="{{$val->dueAmount}}"
                                                       data-supplier="{{$val->name}}"
                                                       data-type="{{$type}}"
                                                    >View</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @if (isset($_GET['supplier']))
                                    <div class="text-center mt-4" style="border: 1px solid gray;padding: 10px">
                                        <strong>NO DATA AVAILABLE</strong>
                                    </div>
                                @else
                                    <div class="text-center mt-4" style="border: 1px solid gray;padding: 10px">
                                        <strong>FILTER DATA FOLLOWING THE ABOVE FIELD</strong>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Purchase Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="tableList"></span>
                </div>
            </div>
        </div>
    </div>

@section('extra_js')
    <script>
        $("body").on("click", ".viewDetails", function (e) {

            let dataId = $(this).data('id');
            let type = $(this).data('type')

            const url = "{{url('admin/supplier-view-details')}}/" + dataId + '/' + type

            let fetchData = {
                method: 'GET',
                headers: new Headers({
                    'Content-Type': 'application/json; charset=UTF-8'
                })
            }
            fetch(url, fetchData)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data.data)
                    if (data.status) {
                        $('#tableList').html(data.data)
                    } else {
                        $('#tableList').html('')
                    }
                })

            $('#editModal').modal('toggle')
        });
    </script>
@endsection
@endsection
