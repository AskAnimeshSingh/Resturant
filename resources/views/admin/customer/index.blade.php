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
            <h4>Customer List </h4>
            <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="customer">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phn No</th>
                    <th>Address </th>
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
          <h5 class="modal-title" id="formModal">Add New Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="store_customer" method="POST">

            <div class="form-group">
                <label>Name:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Name" name="name">
                </div>
            </div>

            <div class="form-group">
                <label>Branch:</label>
                <div class="input-group">
                  <select type="text" class="form-control"  name="branch">
                      <option value="">Select Branch</option>
                      @foreach ($branches as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <div class="input-group">
                  <input type="email" class="form-control" placeholder="E-mail" name="email">
                </div>
            </div>
            <div class="form-group">
                <label>Phone No:</label>
                <div class="input-group">
                  <input type="number" step="any"  class="form-control" placeholder="phone Number" name="phone">
                </div>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Address" name="address">
                </div>
            </div>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Edit form -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" a  ria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Edit Customer </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_customer" method="POST">
            
            <div class="form-group">
                <label>Name:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Name" name="name" id="edit_name">
                </div>
            </div>
  
              <div class="form-group">
                  <label>Branch:</label>
                  <div class="input-group">
                    <select type="text" class="form-control"  name="branch" id="edit_branch">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
  
              <div class="form-group">
                  <label>Email:</label>
                  <div class="input-group">
                    <input type="email" class="form-control" placeholder="E-mail" name="email" id="edit_email">
                  </div>
              </div>
              <div class="form-group">
                  <label>Phone No:</label>
                  <div class="input-group">
                    <input type="number" step="any"  class="form-control" placeholder="phone Number" name="phone" id="edit_phone">
                  </div>
              </div>
              <div class="form-group">
                  <label>address:</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Address" name="address" id="edit_address">
                  </div>
              </div>
            <input type="hidden" id="edit_user_id" name="edit_user_id">
            <button type="submit" name="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>
</section>
@section('extra_js')
<script>
  
  // Category Store
  $("body").on("submit", ".store_customer", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.customer.store') }}",
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
          $(".store_customer")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#customer').DataTable().ajax.reload(null, false);

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
  var tables = $('#customer').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.customer.customer_ajax_list')}}",
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
        "name": "email",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "phone",
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
        "name": "type",
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
        "targets": 3,
        "name": "action'",
        'searchable': false,
        'orderable': false
      },
    ],
  });


  // Edit Category
  $("body").on("click", ".editUser", function(e) {
    var name        = $(this).data('name');
    var phone       = $(this).data('phone');
    var branch      = $(this).data('branch');
    var type        = $(this).data('type');
    var email       = $(this).data('email');
    var id          = $(this).data('id');
    var address= $(this).data('address');
        
    $("#edit_name").val(name);
    $("#edit_phone").val(phone);
    $("#edit_branch").val(branch);
    $("#edit_address").val(address);
    $("#edit_email").val(email);
    $("#edit_user_id").val(id);
    $('#editModal').modal('toggle')
  });


  // Category Edit
  $("body").on("submit", ".edit_customer", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.customer.update') }}",
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
          $(".edit_customer")[0].reset();
          $("#editModal").modal("toggle");
          $('#customer').DataTable().ajax.reload(null, false);

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
      content: 'Sure you want to change customer status?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.customer.status') }}",
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
                $('#customer').DataTable().ajax.reload(null, false);

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
  $("body").on("click", ".user-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this customer type ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.customer.destroy') }}",
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
                $('#customer').DataTable().ajax.reload(null, false);

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