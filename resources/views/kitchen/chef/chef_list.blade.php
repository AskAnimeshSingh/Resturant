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
                    <div class="card-header justify-content-between">
                        <div class="">Chef List</div>
                        <div class=""><a href="{{route('kitchen.chef')}}" class="btn btn-primary btn-sm">Add Chef</a></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="detail">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Image</th>
                                        <th>Email</th>
                                        <th>Phone</th>
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




@section('extra_js')
<script>
    var tables = $('#detail').DataTable({
        "processing": true,
        pageLength: 10,
        "serverSide": true,
        "ajax": {
            url: "{{ route('kitchen.list_ajax.chef') }}",
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
                "name": "id",
                'searchable': false,
                'orderable': false
            },
            {
                "targets": 1,
                "name": "first_name",
                'searchable': true,
                'orderable': true
            },
            {
                "targets": 2,
                "name": "last_name",
                'searchable': true,
                'orderable': true
            },
            {
                "targets": 3,
                "name": "image",
                'searchable': true,
                'orderable': true
            },

            {
                "targets": 4,
                "name": "email",
                'searchable': true,
                'orderable': true
            },
            {
                "targets": 5,
                "name": "phone",
                'searchable': true,
                'orderable': true
            },
            {
                "targets": 6,
                "name": "status",
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
    $(function() {
            // alert('hello');
            $("body").on("click", ".delete_chef", function(e) {

                e.preventDefault()

                let id = $(this).attr('data-id');
                // alert('l');
                let fd = new FormData();
                fd.append('id', id);
                fd.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    method: "POST",
                    url: "{{ route('kitchen.delete.chef') }}",
                    data: fd,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    success: function(result) {

                        if (result.status) {
                            iziToast.success({
                                title: '',
                                message: result.msg,
                                position: 'topRight'
                            });
                            setTimeout(function() {
                                window.location.reload()
                            }, 2000);

                        } else {
                            iziToast.error({
                                title: '',
                                message: result.msg,
                                position: 'topRight'
                            });
                        }
                    }
                })
            })






        });


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
                content: 'Sure you want to change chef status?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            url: "{{ route('kitchen.status.chef') }}",
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
                                    $('#detail').DataTable().ajax.reload(null, false);

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
