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
            <h4>Coupon List</h4>
            <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="coupon">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Coupon code</th>
                    <th>Discount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
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
          <h5 class="modal-title" id="formModal">Add Coupon</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="store_coupon" method="POST">
            <div class="form-group">
              <label>Coupon Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Coupon Name" name="coupon_name">
              </div>
            </div>
            {{-- <div class="form-group">
              <label>Product Name:</label>
              <div class="input-group">
                <select class="form-control" name="product_name" required="">
                  <option value="">Select Product</option>
                @foreach ($products as $item)
                    <option value="{{$item->id}}">{{$item->product_name}}</option>
                @endforeach
                </select>
                
              </div>
            </div> --}}
            <div class="form-group">
              <label>Start Date</label>
              <div class="input-group">
                <input type="date" class="form-control" name="start_date"  required="">
              </div>
            </div>
            <div class="form-group">
                <label>End Date</label>
                <div class="input-group">
                  <input type="date" class="form-control" name="end_date" required="">
                </div>
            </div>
            <div class="form-group">
                <label>discount (%)</label>
                <div class="input-group">
                  <input type="number" step="any" min="0" class="form-control" name="discount" required="">
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
          <h5 class="modal-title" id="formModal">Edit Coupon</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_coupon" method="POST">
            <div class="form-group">
              <label>Coupon Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Coupon Name" name="coupon_name" id="edit_coupon">
              </div>
            </div>
            <div class="form-group">
              <label>Start Date</label>
              <div class="input-group">
                <input type="date" class="form-control" name="start_date"  required="" id="edit_start_date">
              </div>
            </div>
            <div class="form-group">
                <label>End Date</label>
                <div class="input-group">
                  <input type="date" class="form-control" name="end_date" required="" id="edit_end_date">
                </div>
            </div>
            <div class="form-group">
                <label>discount (%)</label>
                <div class="input-group">
                  <input type="number" step="any" min="0" class="form-control" name="discount" required="" id="edit_discount">
                </div>
            </div>
            
            <input type="hidden" id="cateid" name="cateid">
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
          </form>
        </div>
      </div>
    </div>
</section>
@section('extra_js')
<script>

  // Category Store
  $("body").on("submit", ".store_coupon", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.coupon.store') }}",
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
          $(".store_coupon")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#coupon').DataTable().ajax.reload(null, false);

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
  $.fn.tableload = function (e) {
  var tables = $('#coupon').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.coupon.coupon_ajax_list')}}",
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
        "name": "coupon_name",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 2,
        "name": "discount",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "start_date",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 4,
        "name": "end_date",
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
        'searchable': false,
        'orderable': false
      },
    ],
  });
}
$.fn.tableload();


  // Edit Coupon
  $("body").on("click", ".editCoupon", function(e) {
    var coupon_name = $(this).data('coupon');
    var discount    = $(this).data('discount');
    var start_date  = $(this).data('start_date');
    var end_date    = $(this).data('end_date');
    var id          = $(this).data('id');
    $("#edit_coupon").val(coupon_name)
    $("#edit_discount").val(discount)
    $("#edit_start_date").val(start_date)
    $("#edit_end_date").val(end_date)
    $('#cateid').val(id);
    $('#editModal').modal('toggle')
  });


  // Coupon Edit
  $("body").on("submit", ".edit_coupon", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.coupons.update') }}",
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
          $(".edit_coupon")[0].reset();
          $('#editModal').modal('toggle')
          $('#coupon').DataTable().ajax.reload(null, false);

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
      content: 'Sure you want to change coupon status?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.coupons.status') }}",
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
                $('#coupon').DataTable().ajax.reload(null, false);

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
  $("body").on("click", ".coupon-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this coupon ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.coupons.destroy') }}",
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
                $('#coupon').DataTable().ajax.reload(null, false);

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