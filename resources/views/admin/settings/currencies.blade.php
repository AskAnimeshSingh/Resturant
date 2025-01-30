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
            <h4>currency List</h4>
            <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="currency">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>1 USD = ?</th>
                    <th>Symbol</th>
                    <th>Rate</th>
                    <th>Allignment</th>
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
          <h5 class="modal-title" id="formModal">Add currency</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="store_set" method="POST">
            <div class="form-group">
              <label>currency Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="e.g. US Dollar" name="currency">
              </div>
            </div>

            <div class="form-group">
                <label>Code:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="e.g. USD for US Dollar" name="code">
                </div>
              </div>

              <div class="form-group">
                <label>Symbol:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="e.g. $" name="symbol">
                </div>
              </div>

              <div class="form-group">
                <label>Rate:</label>
                <div class="input-group">
                  <input type="number" class="form-control" placeholder="1 USD=?" name="rate">
                </div>
              </div>

              {{-- <div class="form-group">
                <label>Allignment:</label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="please select an allignment" name="allignment">
                </div>
              </div> --}}


            <div class="form-group ">
                <label>Allignment</label>
                <select class="input-style form-control" name="allignment" id="allignment">
                    <option value="" selected></option>
                    <option value="Left-[Symbol][Amount]">Left-[Symbol][Amount]</option>
                    <option value="Right-[Amount][Symbol]">Right-[Amount][Symbol]</option>
                </select>
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
          <h5 class="modal-title" id="formModal">Edit currency</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_set" method="POST">


                  <div class="form-group">
                    <label>currency Name:</label>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="e.g. US Dollar" name="currency" id="edit_currency">
                    </div>
                  </div>

                  <div class="form-group">
                      <label>Code:</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="e.g. USD for US Dollar" name="code" id="edit_code">
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Symbol:</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="e.g. $" name="symbol" id="edit_symbol">
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Rate:</label>
                      <div class="input-group">
                        <input type="number" class="form-control" placeholder="1 USD=?" name="rate" id="edit_rate">
                      </div>
                    </div>

                    {{-- <div class="form-group">
                      <label>Allignment:</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="please select an allignment" name="allignment">
                      </div>
                    </div> --}}
                    <div class="form-group ">
                        <label>Allignment</label>
                        <select class="input-style form-control" name="allignment" id="edit_allignment">
                            <option value="" selected></option>
                            <option value="Left-[Symbol][Amount]">Left-[Symbol][Amount]</option>
                            <option value="Right-[Amount][Symbol]">Right-[Amount][Symbol]</option>
                        </select>
                    </div>

                    <input type="hidden" name="setid" id="setid">

                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                </form>
            </div>

      </div>
    </div>
</section>
@section('extra_js')
<script>

  // currency Store
  $("body").on("submit", ".store_set", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.currency.store') }}",
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
          $(".store_set")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#currency').DataTable().ajax.reload(null, false);

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
  var tables = $('#currency').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.currency_ajax_list')}}",
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
        "name": "currency",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "symbol",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 4,
        "name": "allignment",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 5,
        "name": "status",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 6,
        "name": "action",
        'searchable': true,
        'orderable': true
      },
    ],
  });


  // Edit currency
  $("body").on("click", ".editcurrency", function(e) {
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
    // $("#edit_set").val(name)
    $('#setid').val(id);

    $('#editModal').modal('toggle')
  });


  // currency Edit
  $("body").on("submit", ".edit_set", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.currency.update') }}",
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
          $(".edit_set")[0].reset();
          $("#editModal").modal("toggle");
          $('#currency').DataTable().ajax.reload(null, false);

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
      content: 'Sure you want to change currency status?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.currency.status') }}",
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
                $('#currency').DataTable().ajax.reload(null, false);

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


  // currency delete
  $("body").on("click", ".currency-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this currency ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.currency.destroy') }}",
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
                $('#currency').DataTable().ajax.reload(null, false);

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
