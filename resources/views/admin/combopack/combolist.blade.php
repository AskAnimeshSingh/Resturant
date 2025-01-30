@extends('admin.layout.layouts')
@section('extra_css')
<style>
  span.select2-selection.select2-selection--multiple {
    width: 450px;
  }
</style>

@endsection

@section('content')
<section class="section">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header float-right">
            <h4>Combo Pack List</h4>
            <button class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped text-center" id="combo">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Pack Name</th>
                    <th>Item</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Price</th>
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
          <h5 class="modal-title" id="formModal">Add Combo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="combo_list" method="POST">
            <div class="form-group">
              <label>Image:</label>
              <div class="input-group">
                <input type="file" class="form-control" name="image" onchange="readURL(this);">
              </div>
            </div>
            <div class="row justify-content-left">
              <div class="col-4 col-md-6 col-sm-12">
                <div class="form-group">
                  <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/admin/assets/img/default_cate.jpeg') }}" alt="your image" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Compo Pack Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Packname" name="Packname">
              </div>
            </div>
            <div class="form-group">
              <label>Item Name:</label>
              <div class="input-group">
                <select class="form-control select2 item_change" multiple="" required name="item[]">
                  @foreach ($items as $item)
                  <option value="{{$item->id}}" data-price="{{$item->price}}">{{$item->product_name}} - {{$item->price}}</option>
                  @endforeach
                </select>
              </div>
            </div>


            <div class="form-group">
              <label>Start Date</label>
              <input type="date" name="start_date" class="form-control" placeholder="" required min="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
              <label>End Date</label>
              <input type="date" name="end_date" class="form-control" placeholder="" required min="{{ date('Y-m-d') }}">
            </div>


            <div class="form-group">
              <label>Tax:</label>
              <input type="number" min="0" step="any" class="form-control tax" required="" placeholder="Tax" name="tax">

            </div>

            <div class="form-group">
              <label>Price:</label>
              <input type="number" min="0" step="any" class="form-control total" required="" placeholder="Product Price" name="price">

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
          <h5 class="modal-title" id="formModal">Edit Combo pack</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="edit_combo" method="POST">
            <div class="form-group">
              <label>Compo Pack Name:</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Package Name" name="packname" id="packname">
              </div>
            </div>

            <div class="form-group">
              <label>Item:</label>
              <div class="input-group">
                <select class="form-control select2 item_change" multiple="" required name="item[]" id="item_edit">
                  @foreach ($items as $item)
                  <option value="{{$item->id}}" data-price="{{$item->price}}">{{$item->product_name}} - {{$item->price}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Start Date:</label>
              <div class="input-group">
                <input type="date" class="form-control" placeholder="" name="start_date" id="start_date">
              </div>
            </div>

            <div class="form-group">
              <label>End Date:</label>
              <div class="input-group">
                <input type="date" class="form-control" placeholder="" name="end_date" id="end_date">
              </div>
            </div>

            <div class="form-group">
              <label>Tax:</label>
              <input type="number" min="0" step="any" class="form-control tax" required="" placeholder="Tax" name="tax" id="tax">
            </div>

            <div class="form-group">
              <label>Price:</label>
              <div class="input-group">
                <input type="number" class="form-control total" placeholder="" name="price" id="price">
              </div>
            </div>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>

        </div>

        <input type="hidden" id="comboid" name="comboid">
        </form>
      </div>
    </div>
  </div>

</section>
@section('extra_js')
<script>
 function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#previewImage').attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  // $("body").on("keyup" , ".tax" , function() {
  //   var tax = $(this).val();
  //   var totalPrice = $(".total").val();
  //   var totalTax = parseFloat(totalPrice * tax / 100).toFixed(2);
  //   $(".total").val(parseFloat(totalPrice - totalTax).toFixed(2));


  // })

  // Item  price get
  $("body").on("change", ".item_change", function() {
    var  id = $(".item_change").val();
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id' , id);
    $.ajax({
      url: "{{ route('common.cal_price') }}",
      type: "POST",
      data: fd,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        // $('.loader').show();
      },
      success: function(result) {
        console.log(result.price);
        $(".total").val(result.price);
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


  // Category Store
  $("body").on("submit", ".combo_list", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.combo.store') }}",
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
          $(".combo_list")[0].reset();
          $("#exampleModal").modal("toggle");
          $('#combo').DataTable().ajax.reload(null, false);

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
  var tables = $('#combo').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.combo_ajax_list')}}",
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
        "name": "package_name",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 2,
        "name": "item",
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
        "name": "price",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 7,
        "name": "action",
        'searchable': true,
        'orderable': true
      },
    ],
  });

  // Edit combo
  $("body").on("click", ".editCategory", function(e) {
    var package_name = $(this).data('package_name');
    var item = $(this).data('item');
    console.log(item);
    var start_date = $(this).data('start_date');
    var end_date = $(this).data('end_date');
    var status = $(this).data('status');
    var price = $(this).data('price');
    var tax = $(this).data('tax');
    var id = $(this).data('id');
    $("#packname").val(package_name)
    $("#start_date").val(start_date)
    $("#end_date").val(end_date)
    $("#status").val(status)
    $("#price").val(price)
    $("#tax").val(tax)
    $.each(item , function(i, val) {
      
    })
    

    $('#comboid').val(id);
    $('#editModal').modal('toggle')
  });

  // Category Edit
  $("body").on("submit", ".edit_combo", function(e) {
    e.preventDefault()
    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
      url: "{{ route('admin.combopack.update') }}",
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
          $(".edit_combo")[0].reset();
          $("#editModal").modal("toggle");
          $('#combo').DataTable().ajax.reload(null, false);

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
      content: 'Sure you want to change combopack status?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.combopack.status') }}",
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
                $('#combo').DataTable().ajax.reload(null, false);

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
  $("body").on("click", ".category-delete", function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    let fd = new FormData()
    fd.append('_token', "{{ csrf_token() }}");
    fd.append('id', id);
    $.confirm({
      title: 'Confirm!',
      content: 'Sure you want to delete this combopack ?',
      buttons: {
        yes: function() {
          $.ajax({
              url: "{{ route('admin.combopack.destroy') }}",
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
                $('#combo').DataTable().ajax.reload(null, false);

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