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
            <h4>Size Setting</h4>
            <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="size">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Size </th>
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

  <!-- Modal with form -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Add Size</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="store_size" method="POST">
            <div class="form-group">
              <label>Size Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Size" name="size">
              </div>
            </div>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit form -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Edit Size</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_size" method="POST">
            <div class="form-group">
              <label>Size Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Size" name="size" id="edit_size">
              </div>
            </div>
            <input type="hidden" id="sizeid" name="sizeid">
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>
</section>
@section('extra_js')
<script>
  // Category Store
  $("body").on("submit", ".store_size", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.size.store') }}",
      type: "POST",
      data: fd,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        $('.loader').show();
      },
      success: function(result) {
        if (result.status) {
          iziToast.success({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
          $(".store_size")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#size').DataTable().ajax.reload(null, false);

        } else {
          iziToast.error({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
        }
      },
      complete: function() {
        $('.loader').hide();
      },
      error: function(jqXHR, exception) {
        $('.loader').hide();
        console.log(jqXHR.responseText);
      }
    });
  })

  // Datatable
  // $.fn.tableload = function (e) {
  var tables = $('#size').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.size.size_ajax_list')}}",
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
        "name": "size",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 2,
        "name": "status",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "action",
        'searchable': true,
        'orderable': true
      },
    ],
  });


  // Edit Category
  $("body").on("click", ".editSize", function(e) {
    var size = $(this).data('size');
    var id = $(this).data('id');
    $("#edit_size").val(size)
    $('#sizeid').val(id);
    $('#editModal').modal('toggle')
  });


  // Category Edit
  $("body").on("submit", ".edit_size", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.size.update') }}",
      type: "POST",
      data: fd,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        $('.loader').show();
      },
      success: function(result) {
        if (result.status) {
          iziToast.success({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
          $(".edit_size")[0].reset();
          $("#editModal").modal("toggle");
          $('#size').DataTable().ajax.reload(null, false);

        } else {
          iziToast.error({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
        }
      },
      complete: function() {
        $('.loader').hide();
      },
      error: function(jqXHR, exception) {
        $('.loader').hide();
        console.log(jqXHR.responseText);
      }
    });
  })

  // Update status for category
  $("body").on("click", ".SizeStatusVerifiedClick", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var status = $(this).data('status');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('status', status);
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to change Size status?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.size.status') }}",
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
                $('#size').DataTable().ajax.reload(null, false);

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


  // Category delete
  $("body").on("click", ".size-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this size ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.size.destroy') }}",
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
                $('#size').DataTable().ajax.reload(null, false);

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