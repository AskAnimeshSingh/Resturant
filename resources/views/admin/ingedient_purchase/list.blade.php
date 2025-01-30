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
                            <h4>Ingredient Purchases List</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Add</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="ingredient_list">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Supplier</th>
                                        <th>Invoice</th>
                                        <th>Purchased</th>
                                        <th>Total</th>
                                        <th>Due</th>
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

    </section>
@section('extra_js')
    <script>
        $(function() {
            var tables = $('#ingredient_list').DataTable({
                "processing": true,
                pageLength: 10,
                "serverSide": true,
                "ajax": {
                    url: "{{route('admin.ingredient_purchase.ajax_list')}}",
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
                        "name": "invoice",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 3,
                        "name": "purchase_date",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 4,
                        "name": "total_amnt",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 5,
                        "name": "due_amnt",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 6,
                        "name": "action'",
                        'searchable': false,
                        'orderable': false
                    },
                ],
            });
        })

        // Ingredient delete
        $("body").on("click", ".delete_ingredient", function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            let fd = new FormData()
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('id', id);
            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to delete this ingredient ?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            url: "{{ route('admin.ingredient_purchase.destory') }}",
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
                                    $('#ingredient_list').DataTable().ajax.reload(null, false);

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
