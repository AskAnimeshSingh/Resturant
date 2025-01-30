@extends('kitchen.layout.layouts')
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
                            <h4>Order History</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="detail">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>User Name</th>
                                            {{-- <th>User Address</th> --}}
                                            <th>Total Amount</th>
                                            <th>Cooking Time</th>
                                            <th>Delivery Time</th>
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


    </section>
    <!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button> --}}

  <!-- Modal -->
  <div class="modal fade" id="chefclick" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" class="submitchef">
            <div class="modal-body">
                <input type="hidden" name="weborder_id" id="weborder_id">
                <div class="form-group">
                    <label for="exampleInputEmail1">Select Chef</label>
                    <select class="form-control show-tick ms select2" data-placeholder="Select" name="chef_id">
                        @foreach ($chefs as $chef)
                        <option value="{{$chef->id}}">{{$chef->first_name.' '.$chef->last_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>



@section('extra_js')
    <script>
        var tables = $('#detail').DataTable({
            "processing": true,
            pageLength: 10,
            "serverSide": true,
            "ajax": {
                url: "{{ route('kitchen.order_list.ajax') }}",
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
                    "name": "created_at",
                    'searchable': false,
                    'orderable': false
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
            ],
        });

        $("body").on("click", ".chefmodal", function(e) {

                // var first_name = $(this).data('first_name');
                // var last_name = $(this).data('last_name');
                var id = $(this).data('id');
                // var datas =
                $('#weborder_id').val(id);
                $('#chefclick').modal('toggle')
            });




$("body").on("submit", ".submitchef", function(e) {
            e.preventDefault()
            let fd = new FormData(this)
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('kitchen.assign.chef') }}",
                type: "POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {

                },
                success: function(result) {
                    if (result.status) {
                        iziToast.success({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                        $(".submitchef")[0].reset();
                        $("#chefclick").modal("toggle");
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

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
    </script>
@endsection
@endsection
