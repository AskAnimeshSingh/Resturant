@extends('admin.layout.layouts')
@section('extra_css')
<style>
</style>

@endsection

@section('content')
<section class="section">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header float-right">
            <h4>Completed Delivery</h4>
            {{-- <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button> --}}
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="completed_delivery">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>User Name</th>
                    <th>User Phone</th>
                    <th>User Address</th>
                    <th>Txn id</th>
                    <th>Invoice id</th>
                    <th>Transaction Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Delivered By</th>

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
  </div>

</section>
@section('extra_js')
<script>
var tables = $('#completed_delivery').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.complete.order.ajax_list')}}",
      dataFilter: function(data) {
        var json = jQuery.parseJSON(data);

        json.recordsTotal = json.recordsTotal;
        json.recordsFiltered = json.recordsFiltered;
        json.data = json.data;
        return JSON.stringify(json); // return JSON string
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
            {
               "targets": 6,
               "name": "action",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 7,
               "name": "name",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 8,
               "name": "name",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 9,
               "name": "action",
               'searchable': true,
               'orderable': true
            },
    ],
  });
</script>
@endsection
@endsection
