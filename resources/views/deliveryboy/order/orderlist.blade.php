{{-- @extends('deliveryboy.layout.layouts') --}}
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
                            <h4>Delivery History</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="detail">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>User Name</th>
                                            <th>User Address</th>
                                            <th>User Phone</th>
                                            <th>Payment Mode</th>
                                            {{-- <th>Payment Status</th> --}}
                                            <th>Status</th>
                                            <th>View Details</th>

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
        $(document).ready(function() {
            var tables = $('#detail').DataTable({
                "processing": true,
                pageLength: 10,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('deliveryboy.order_list.ajax') }}",
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
                    // {
                    //     "targets": 7,
                    //     "name": "name",
                    //     'searchable': true,
                    //     'orderable': true
                    // },

                ],
            });

            $("body").on("click", ".statusdeliver", function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');
                // alert(status);
                let fd = new FormData()
                fd.append('_token', "{{ csrf_token() }}");
                fd.append('status', status);
                fd.append('id', id);
                // alert(status);
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to change status?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('deliveryboy.update.order.status.approve') }}",
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
                                })
                                .fail(function(jqXHR, exception) {
                                    console.log(jqXHR.responseText);
                                })


                        },
                        no: function() {},
                    }
                })
            })
        });
    </script>
@endsection
@endsection
