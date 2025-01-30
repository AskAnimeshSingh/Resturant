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
            <h4>Blog List</h4>
            <a href="{{route('admin.blog.create')}}" class="btn btn-primary float-left"><i class="fa fa-plus"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped nowrap" id="blog">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Date</th>
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
  </div>

  
</section>
@section('extra_js')
<script>

  // Datatable
  $.fn.tableload = function (e) {
  var tables = $('#blog').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.blog.blog_ajax_list')}}",
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
        "name": "image",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "description",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 4,
        "name": "fname",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 5,
        "name": "created_date",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 6,
        "name": "status",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 7,
        "name": "action",
        'searchable': false,
        'orderable': false
      },
    ],
  });
}
$.fn.tableload();


  // Update status for Status
  $("body").on("click", ".statusVerifiedClick", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var status = $(this).data('status');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('status', status);
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to change blog status?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.blog.status') }}",
              type: 'POST',
              data: fd,
              dataType: "JSON",
              contentType: false,
              processData: false,
            })
            .done(function(result) {
              if (result.status) {
                iziToast.success({
                  title: '',
                  message: result.msg,
                  position: 'topRight'
                });
                $('#blog').DataTable().ajax.reload(null, false);

              } else {
                iziToast.error({
                  title: '',
                  message: result.msg,
                  position: 'topRight'
                });
              }
            })
            .fail(function(jqXHR, exception) {
              console.log(jqXHR.responseText);
            })


        },
        no: function() {},
      }
    })
  })


  // Coupon delete
  $("body").on("click", ".blog-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this blog ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.blog.destroy') }}",
              type: 'POST',
              data: fd,
              dataType: "JSON",
              contentType: false,
              processData: false,
            })
            .done(function(result) {
              if (result.status) {
                iziToast.success({
                  title: '',
                  message: result.msg,
                  position: 'topRight'
                });
                $('#blog').DataTable().ajax.reload(null, false);

              } else {
                iziToast.error({
                  title: '',
                  message: result.msg,
                  position: 'topRight'
                });
              }
            })
            .fail(function(jqXHR, exception) {
              console.log(jqXHR.responseText);
            })
        },
        no: function() {},
      }
    })
  })
</script>
@endsection
@endsection