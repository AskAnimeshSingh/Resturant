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
                        <div class="card-header d-flex justify-content-between">
                            <h4>Branch List</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="branch">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Delivery Charges</th>
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
    <!-- Modal Add Branch -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="store_branch" method="POST">
                        <div class="form-group">
                            <label>Name<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Phone Number" name="phone"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Address" name="address"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Delivery Fee<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="any" min="0" class="form-control"
                                       placeholder="Delivery Fee" name="delivery_fee" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Branch -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Update Branch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit_branch" method="POST">
                        <div class="form-group">
                            <label>Name<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Name" name="name"
                                       id="edit_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Phone Number" name="phone"
                                       id="edit_phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Address" name="address"
                                       id="edit_address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Delivery Fee<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="any" min="0" class="form-control"
                                       placeholder="Delivery Fee" name="delivery_fee" id="edit_delivery_fee"
                                       required>
                            </div>
                        </div>
                        <input type="hidden" id="edit_branch_id" name="edit_branch_id">
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
        @section('extra_js')
            <script>

                // Category Store
                $("body").on("submit", ".store_branch", function (e) {
                    e.preventDefault()
                    let fd = new FormData(this)
                    fd.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('admin.branch.store') }}",
                        type: "POST",
                        data: fd,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('.loader').show();
                        },
                        success: function (result) {
                            if (result.status) {
                                iziToast.success({
                                    title: '',
                                    message: result.msg,
                                    position: 'topRight'
                                });
                                $(".store_branch")[0].reset();
                                $("#exampleModal").modal("toggle");
                                $('#branch').DataTable().ajax.reload(null, false);

                            } else {
                                iziToast.error({
                                    title: '',
                                    message: result.msg,
                                    position: 'topRight'
                                });
                            }
                        },
                        complete: function () {
                            $('.loader').hide();
                        },
                        error: function (jqXHR, exception) {
                            $('.loader').hide();
                            console.log(jqXHR.responseText);
                        }
                    });
                })


                // Datatable
                // $.fn.tableload = function (e) {
                var tables = $('#branch').DataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "ajax": {
                        url: "{{route('admin.branch.branch_ajax_list')}}",
                        dataFilter: function (data) {
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
                            "name": "phone",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 3,
                            "name": "address",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 3,
                            "name": "delivery_charge",
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


                // Edit Category
                $("body").on("click", ".editBranch", function (e) {
                    var name = $(this).data('name');
                    var id = $(this).data('id');
                    var phone = $(this).data('phone');
                    var address = $(this).data('address');
                    var delivery_fee = $(this).data('delivery_fee');

                    $("#edit_name").val(name);
                    $("#edit_phone").val(phone);
                    $("#edit_address").val(address);
                    $("#edit_delivery_fee").val(delivery_fee);
                    $('#edit_branch_id').val(id);
                    $('#editModal').modal('toggle')
                });


                // Category Edit
                $("body").on("submit", ".edit_branch", function (e) {
                    e.preventDefault()
                    let fd = new FormData(this)
                    fd.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('admin.branch.update') }}",
                        type: "POST",
                        data: fd,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#login-button').prop('disabled', true);
                            $('.loader').show();
                        },
                        success: function (result) {
                            if (result.status) {
                                iziToast.success({
                                    title: '',
                                    message: result.msg,
                                    position: 'topRight'
                                });
                                $(".edit_branch")[0].reset();
                                $("#editModal").modal("toggle");
                                $('#branch').DataTable().ajax.reload(null, false);

                            } else {
                                iziToast.error({
                                    title: '',
                                    message: result.msg,
                                    position: 'topRight'
                                });
                            }
                        },
                        complete: function () {
                            $('.loader').hide();
                        },
                        error: function (jqXHR, exception) {
                            $('.loader').hide();
                            console.log(jqXHR.responseText);
                        }
                    });
                })

                // Update status for category
                $("body").on("click", ".statusVerifiedClick", function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var status = $(this).data('status');
                    let fd = new FormData()
                    fd.append('_token', "{{ csrf_token() }}");
                    fd.append('status', status);
                    fd.append('id', id);
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Sure you want to change branch status?',
                        buttons: {
                            yes: function () {
                                $.ajax({
                                    url: "{{ route('admin.branch.status') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                    .done(function (result) {
                                        if (result.status) {
                                            iziToast.success({
                                                title: '',
                                                message: result.msg,
                                                position: 'topRight'
                                            });
                                            $('#branch').DataTable().ajax.reload(null, false);

                                        } else {
                                            iziToast.error({
                                                title: '',
                                                message: result.msg,
                                                position: 'topRight'
                                            });
                                        }
                                    })
                                    .fail(function (jqXHR, exception) {
                                        console.log(jqXHR.responseText);
                                    })


                            },
                            no: function () {
                            },
                        }
                    })
                })


                // Category delete
                $("body").on("click", ".branch-delete", function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    let fd = new FormData()
                    fd.append('_token', "{{ csrf_token() }}");
                    fd.append('id', id);
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Sure you want to delete this branch ?',
                        buttons: {
                            yes: function () {
                                $.ajax({
                                    url: "{{ route('admin.branch.destroy') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                    .done(function (result) {
                                        if (result.status) {
                                            iziToast.success({
                                                title: '',
                                                message: result.msg,
                                                position: 'topRight'
                                            });
                                            $('#branch').DataTable().ajax.reload(null, false);

                                        } else {
                                            iziToast.error({
                                                title: '',
                                                message: result.msg,
                                                position: 'topRight'
                                            });
                                        }
                                    })
                                    .fail(function (jqXHR, exception) {
                                        console.log(jqXHR.responseText);
                                    })


                            },
                            no: function () {
                            },
                        }
                    })
                })
            </script>
@endsection
@endsection
