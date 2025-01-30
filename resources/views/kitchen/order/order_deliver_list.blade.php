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
                        <h4>Order List</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="detail">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User Name</th>
                                        <th>User Address</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
<script>
    var tables = $('#detail').DataTable({
        "processing": true,
        pageLength: 10,
        "serverSide": true,
        "ajax": {
            url: "{{ route('kitchen.order_delivered_list.ajax') }}",
            dataFilter: function(data) {
                var json = jQuery.parseJSON(data);

                json.recordsTotal = json.recordsTotal;
                json.recordsFiltered = json.recordsFiltered;
                json.data = json.data;
                return JSON.stringify(json);
            }
        },

        'order': [
            [1, 'desc']
        ],
        'columnDefs': [{
                "targets": 0,
                "name": "created_at",
                'searchable': false,
                'orderable': false
            },
            {
                "targets": 1,
                "name": "name",
                'searchable': true,
                'orderable': true
            },
            {
                "targets": 2,
                "name": "name",
                'searchable': true,
                'orderable': true
            },
            {
                "targets": 3,
                "name": "name",
                'searchable': true,
                'orderable': true
            },

            {
                "targets": 4,
                "name": "name",
                'searchable': true,
                'orderable': true
            },
            {
                "targets": 5,
                "name": "name",
                'searchable': true,
                'orderable': true
            },
        ],
    });
</script>
@endsection
@endsection
