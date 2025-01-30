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
            <h4>Add Stock</h4>
            <a href="{{route('admin.index.stock')}}" class="btn btn-primary text-decoration-none"><i class="fa fa-plus"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped nowrap" id="product_list">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Unit</th>
                    <th>Stock</th>
                    <th>Stock Received From</th>
                    <th>Expiry Date</th>
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

  // $.fn.tableload = function (e) {
  var tables = $('#product_list').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.view.ajax.stock.list')}}",
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
        "name": "id",
        'searchable': true,
        'orderable': true
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
        "name": "name",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 7,
        "name": "name",
        'searchable': true,
        'orderable': true
      },

    ],
  });






</script>
@endsection
@endsection
