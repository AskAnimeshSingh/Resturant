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
                          <h4>Qr Table</h4>
                          <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button> 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-striped" id="category">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                             <th>Table Name</th>
                                             <th>Qr code</th>
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
   <!--modal form -->
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Add Table Name</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="store_cate" method="POST">
            <div class="form-group">
              <label>Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Table Name" name="name">
              </div>
            </div>
            <div class="form-group">
              <label>Table Code</label>
              <div class="input-group">
                <input type="text" class="form-control" name="qr_code" >
                    {{-- {!! QrCode ::generate('Welcome to Makitweb'); !!} --}}

              </div>
            </div>
            
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

{{-- //Edit Modal// --}}
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">EditTable Name</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_cate" method="POST">
            <div class="form-group">
              <label> Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" name="name" id="edit_cate">

              </div>
            </div>
            <div class="form-group">
              <label>Table Code</label>
              <div class="input-group">
                <input type="text" class="form-control" name="qr_code" id="qr_code" >
                {{-- {!! QrCode ::generate('Welcome to Makitweb'); !!} --}}

              </div>
            </div>
            <input type="hidden" id="id" name="id">
           
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>


   @section('extra_js')
   <script>
    $("body").on("submit", ".store_cate", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.qr.store') }}",
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
          $(".store_cate")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#category').DataTable().ajax.reload(null, false);

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
  var tables = $('#category').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.qr_ajax_list')}}",
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
        "name": "qr_code",
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
  $("body").on("click", ".editCategory", function(e) {
    var name = $(this).data('name');
    var qr_code = $(this).data('qr_code');
    var id = $(this).data('id');
    $("#edit_cate").val(name)
    $('#id').val(id);
    $('#qr_code').val(qr_code);
    $('#editModal').modal('toggle')
  });


  // Category Edit
  $("body").on("submit", ".edit_cate", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.qr.update') }}",
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
          $(".edit_cate")[0].reset();
          $("#editModal").modal("toggle");
          $('#category').DataTable().ajax.reload(null, false);

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



  // Category delete
  $("body").on("click", ".category-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this category ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.qr.destroy') }}",
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
                $('#category').DataTable().ajax.reload(null, false);

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