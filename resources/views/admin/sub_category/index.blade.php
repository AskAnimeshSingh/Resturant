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
                        <div class="card-header justify-content-between">
                            <h4>Sub Category List</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="sub_category">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Sub Category</th>
                                        <th>Category</th>
                                        <th>Image</th>
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
    <!-- Modal with form -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="store_cate" method="POST">
                        <div class="form-group">
                            <label>Category Name:</label>
                            <div class="input-group">
                                <select type="text" class="form-control" placeholder="Category" name="category">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach ($category as $item)
                                        <option value="{{$item->id}}">{{$item->cate_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sub Category Name:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Sub Category"
                                       name="sub_category">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="image" accept="image/*"
                                       onchange="readURL(this,'add');">
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Icon Preview</label>
                            <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                 src="{{ asset('assets/admin/assets/img/default_cate.jpeg') }}" alt="your image"/>
                        </div>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit form -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Edit Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit_cate" method="POST">
                        <div class="form-group">
                            <label>Category Name:</label>
                            <div class="input-group">
                                <select type="text" class="form-control" placeholder="Category" name="category"
                                        id="parent_cate">
                                    <option value="">Select Category</option>
                                    @foreach ($category as $item)
                                        <option value="{{$item->id}}">{{$item->cate_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Sub Category Name:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Category" name="sub_category"
                                       id="edit_cate">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="image" accept="image/*" id="editIcon"
                                       onchange="readURL(this,'edit');">
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Icon Preview</label>
                            <span id="image-icon"></span>
                        </div>
                        <input type="hidden" name="oldimage" id="oldicon">
                        <input type="hidden" id="cateid" name="cateid">
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </form>
                </div>
            </div>
        </div>

        @section('extra_js')
            <script>
                // Image preview
                function readURL(input, place) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            if (place === 'add') {
                                $('#previewImage').attr('src', e.target.result);
                            } else {
                                $('#editpreviewImage').attr('src', e.target.result);
                            }
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                // Category Store
                $("body").on("submit", ".store_cate", function (e) {
                    e.preventDefault()
                    let fd = new FormData(this)
                    fd.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('admin.sub_category.store') }}",
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
                                $(".store_cate")[0].reset();
                                $("#exampleModal").modal("toggle");
                                $('#sub_category').DataTable().ajax.reload(null, false);

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
                var tables = $('#sub_category').DataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "ajax": {
                        url: "{{route('admin.sub_category_ajax_list')}}",
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
                            "name": "cate_name",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 3,
                            "name": "cate_img",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 4,
                            "name": "status",
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


                // Edit Category
                $("body").on("click", ".editCategory", function (e) {
                    var name = $(this).data('name');
                    var img = $(this).data('img');
                    var id = $(this).data('id');
                    var parent_id = $(this).data('cate_id');
                    $('#editIcon').val("")
                    $("#edit_cate").val(name)
                    $('#cateid').val(id);
                    $('#parent_cate').val(parent_id);
                    $('#oldicon').val(img);
                    $('#image-icon').html('<img class="img-thumbnail image-width mt-4 mb-3" id="editpreviewImage" src="{{url('')}}' + img + '" alt="" />')
                    $('#editModal').modal('toggle')
                });


                // Category Edit
                $("body").on("submit", ".edit_cate", function (e) {
                    e.preventDefault()
                    let fd = new FormData(this)
                    fd.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('admin.sub_category.update') }}",
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
                                $(".edit_cate")[0].reset();
                                $("#editModal").modal("toggle");
                                $('#sub_category').DataTable().ajax.reload(null, false);

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
                        content: 'Sure you want to change sub category status?',
                        buttons: {
                            yes: function () {
                                $.ajax({
                                    url: "{{ route('admin.sub_category.status') }}",
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
                                            $('#sub_category').DataTable().ajax.reload(null, false);

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
                $("body").on("click", ".category-delete", function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    let fd = new FormData()
                    fd.append('_token', "{{ csrf_token() }}");
                    fd.append('id', id);
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Sure you want to delete this sub category ?',
                        buttons: {
                            yes: function () {
                                $.ajax({
                                    url: "{{ route('admin.sub_category.destroy') }}",
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
                                            $('#sub_category').DataTable().ajax.reload(null, false);

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
