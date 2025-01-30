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
            <h4>Language List</h4>
            <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="language">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>flag</th>
                    <th>Set Default</th>
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
          <h5 class="modal-title" id="formModal">Add new Language</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="store_lang" method="POST">

            <div class="form-group">
              <label>Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="" name="name">
              </div>
            </div>

            <div class="form-group">
                <label>Code:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="" name="code">
                </div>
              </div>

              <div class="form-group ">
                <label class="form-group">Flag</label>
                <div class="input-group">
                  <input type="file" name="image" class="form-control" required onchange="readURL(this);">
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
          <h5 class="modal-title" id="formModal">Edit Language</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_lang" method="POST">


                  <div class="form-group ">
              <label>Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="" name="name">
              </div>
            </div>

            <div class="form-group ">
                <label>Code:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="" name="code">
                </div>
              </div>

              <div class="form-group ">
                <label class="form-group">Flag</label>
                <div class="input-group">
                  <input type="file" name="image" class="form-control" required onchange="readURL(this);">
                </div>
              </div>

                    <input type="hidden" name="langid" id="langid">

                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                </form>
            </div>

      </div>
    </div>
</section>
@section('extra_js')
<script>

  // currency Store
  $("body").on("submit", ".store_lang", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.language.store') }}",
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
          $(".store_lang")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#language').DataTable().ajax.reload(null, false);

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
  var tables = $('#language').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.language_ajax_list')}}",
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
        "name": "code",
        'searchable': true,
        'orderable': true
      },

      {
        "targets": 3,
        "name": "flag",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 4,
        "name": "set default",
        'searchable': true,
        'orderable': true
      },

      {
        "targets": 5,
        "name": "action",
        'searchable': true,
        'orderable': true
      },
    ],
  });


  // Edit currency
  $("body").on("click", ".editlanguage", function(e) {
    var name = $(this).data('name');
    var currency = $(this).data('currency');
    var symbol = $(this).data('symbol');
    var allignment = $(this).data('alignment');
    var rate = $(this).data('rate');
    var code = $(this).data('code');
    var id = $(this).data('id');

    $("#edit_name").val(name);
    $("#edit_currency").val(currency);
    $("#edit_symbol").val(symbol);
    $("#edit_allignment").val(allignment)
    $("#edit_rate").val(rate)
    $("#edit_code").val(currency)
    // $("#edit_lang").val(name)
    $('#langid').val(id);

    $('#editModal').modal('toggle')
  });


  // currency Edit
  $("body").on("submit", ".edit_lang", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.language.update') }}",
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
          $(".edit_lang")[0].reset();
          $("#editModal").modal("toggle");
          $('#language').DataTable().ajax.reload(null, false);

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

  // Update status for currency
//   $("body").on("click", ".statusVerifiedClick", function(e) {
//     e.preventDefault();
//     var id = $(this).data('id');
//     var status = $(this).data('status');
//     let fd = new FormData()
//     fd.append('_token', "{{ csrf_token() }}");
//     fd.append('status', status);
//     fd.append('id', id);
//     $.confirm({
//       title: 'Confirm!',
//       content: 'Sure you want to change currency status?',
//       buttons: {
//         yes: function() {
//           $.ajax({
//               url: "{{ route('admin.currency.status') }}",
//               type: 'POST',
//               data: fd,
//               dataType: "JSON",
//               contentType: false,
//               processData: false,
//             })
//             .done(function(result) {
//               if (result.status) {
//                 iziToast.success({
//                   title: '',
//                   message: result.msg,
//                   position: 'topRight'
//                 });
//                 $('#currency').DataTable().ajax.reload(null, false);

//               } else {
//                 iziToast.error({
//                   title: '',
//                   message: result.msg,
//                   position: 'topRight'
//                 });
//               }
//             })
//             .fail(function(jqXHR, exception) {
//               console.log(jqXHR.responseText);
//             })


//         },
//         no: function() {},
//       }
//     })
//   })


  // language delete
  $("body").on("click", ".language-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this language ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.language.destroy') }}",
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
                $('#language').DataTable().ajax.reload(null, false);

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
