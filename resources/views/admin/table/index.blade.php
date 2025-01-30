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
            <h4>Tables List</h4>
            <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="department">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Capacity</th>
                    <th>Branch</th>
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
          <h5 class="modal-title" id="formModal">Add Department</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="store_table" method="POST">
            <div class="form-group">
              <label>Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Table" name="name" required>
              </div>
            </div>
            <div class="form-group">
                <label>Select a Branch:</label>
                <div class="input-group">
                  <select type="text" class="form-control" name="branch" required>
                    <option value="">Select a Branch</option>
                    @foreach ($branches as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label>Guess Capacity:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Guess Capacity" name="capacity">
                </div>
            </div>
            <div class="form-group">
                <label>Select a status:</label>
                <div class="input-group">
                    <select type="text" class="form-control" name="status" required>
                        <option value="">Select a statuts</option>
                        <option value="open">Open</option>
                        <option value="check_in">Check IN</option>
                        <option value="steated">Seated</option>
                        <option value="check_out">Check Out</option>
                        <option value="dirty">Dirty</option>
                    </select>
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
          <h5 class="modal-title" id="formModal">Edit Table</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_table" method="POST">
            <div class="form-group">
              <label>Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Table" name="name" required id="edit_name">
              </div>
            </div>
            <div class="form-group">
                <label>Select a Branch:</label>
                <div class="input-group">
                  <select type="text" class="form-control" name="branch" required id="edit_branch">
                    <option value="">Select a Branch</option>
                    @foreach ($branches as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label>Guess Capacity:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Guess Capacity" name="capacity" id="edit_capacity">
                </div>
            </div>
            <div class="form-group">
                <label>Select a status:</label>
                <div class="input-group">
                    <select type="text" class="form-control" name="status" required id="edit_status">
                        <option value="">Select a statuts</option>
                        <option value="open">Open</option>
                        <option value="check_in">Check IN</option>
                        <option value="steated">Seated</option>
                        <option value="check_out">Check Out</option>
                        <option value="dirty">Dirty</option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="edit_id" name="table_id">
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>
</section>
@section('extra_js')
<script>

  // Category Store
  $("body").on("submit", ".store_table", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.table.store') }}",
      type: "POST",
      data: fd,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        $('#login-button').prop('disabled', true);
        $('.loader').show();
      },
      success: function(result) {
        if (result.status) {
          iziToast.success({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
          $(".store_table")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#department').DataTable().ajax.reload(null, false);

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
  var tables = $('#department').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.table.table_ajax_list')}}",
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
        "name": "guest_capacity",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "branch_id",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "status",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 4,
        "name": "action",
        'searchable': true,
        'orderable': true
      },
    ],
  });


  // Edit Category
  $("body").on("click", ".editTable", function(e) {
    var name        = $(this).data('name');
    var capacity    = $(this).data('capacity');
    var branch_id   = $(this).data('branch_id');
    var status      = $(this).data('status');
    var id          = $(this).data('id');

    $("#edit_name").val(name);
    $("#edit_capacity").val(capacity);
    $("#edit_branch").val(branch_id);
    $("#edit_status").val(status);
    $("#edit_name").val(name);
    $("#edit_id").val(id);

    $('#editModal').modal('toggle')

  });


  // Category Edit
  $("body").on("submit", ".edit_table", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.table.update') }}",
      type: "POST",
      data: fd,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        $('#login-button').prop('disabled', true);
        $('.loader').show();
      },
      success: function(result) {
        if (result.status) {
          iziToast.success({
            title: '',
            message: result.msg,
            position: 'topRight'
          });
          $(".edit_table")[0].reset();
          $("#editModal").modal("toggle");
          $('#department').DataTable().ajax.reload(null, false);

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
      content: 'Sure you want to change deparment status?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.commission.status') }}",
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
                $('#department').DataTable().ajax.reload(null, false);

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
  $("body").on("click", ".table-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this Table ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.table.destroy') }}",
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
                $('#department').DataTable().ajax.reload(null, false);

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