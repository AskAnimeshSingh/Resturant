{{-- @extends('deliveryboy.layout.layouts') --}}
@extends('kitchen.layout.layouts')
@section('extra_css')
    <style>
        .timer-container {
            display: flex;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }

        .timer-values {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            font-size: 28px;
            gap: 35px;
        }

        .timer-value {
            margin: 0 10px;
        }

        .timer-labels {
            display: flex;
            justify-content: center;
            margin-top: 5px;
            font-size: 15px;
        }

        .timer-label {
            margin: 0 10px;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section body">
            <div class="card">
                <div class="card-header">
                    <h5>New Deliveries</h5>
                </div>
            </div>
            <div class="card">
                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col col-lg-6">
                            <div class="deliveryGuy">
                                <label for="SelectDeliveryGuy" style="color:grey; font-weight:bolder;">Delivery
                                    Guy</label>
                                <select name="SelectDeliveryGuy" style="border: 1px solid grey;" class="form-control"
                                    id="deliveryGuyId">
                                    <option value="">Select Delivery Guy</option>
                                    @foreach ($deliveryGuys as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="orderDetailsContainer" class="card">
                <div class="card-body">
                    <div class="row" id="orderDetailsContent">
                        <!-- Order details will be injected here -->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@section('extra_js')
    <script>
        function updateTimers() {
            const timerElements = document.getElementsByClassName('timer');
            for (let i = 0; i < timerElements.length; i++) {
                const timerElement = timerElements[i];
                const startTime = parseInt(timerElement.getAttribute('data-start-time'), 10);
                const currentTime = Math.floor(Date.now() / 1000);
                const elapsedSeconds = currentTime - startTime;
                const hours = Math.floor(elapsedSeconds / 3600);
                const minutes = Math.floor((elapsedSeconds % 3600) / 60);
                const seconds = elapsedSeconds % 60;
                timerElement.innerHTML = `
            <div class="timer-values">
                <div class="timer-value">${hours}</div>
                <div class="timer-value">${minutes}</div>
                <div class="timer-value">${seconds}</div>
            </div>
            <div class="timer-labels">
                <div class="timer-label">HOURS</div>
                <div class="timer-label">MINUTES</div>
                <div class="timer-label">SECONDS</div>
            </div>
        `;
            }
        }
        updateTimers();
        setInterval(updateTimers, 1000);

        // $(document).ready(function() {
        //     var id = $(this).val();

        //     var tables = $('#detail').DataTable({
        //         "processing": true,
        //         pageLength: 10,
        //         "serverSide": true,
        //         "ajax": {
        //             url: "{{ route('deliveryboy.order_list.pending.ajax', '') }}/" + id,
        //             dataFilter: function(data) {
        //                 var json = jQuery.parseJSON(data);

        //                 json.recordsTotal = json.recordsTotal;
        //                 json.recordsFiltered = json.recordsFiltered;
        //                 json.data = json.data;
        //                 return JSON.stringify(json);
        //             }
        //         },

        //         'order': [
        //             [1, 'desc']
        //         ],
        //         'columnDefs': [{
        //                 "targets": 0,
        //                 "name": "created_at",
        //                 'searchable': false,
        //                 'orderable': false
        //             },
        //             {
        //                 "targets": 1,
        //                 "name": "name",
        //                 'searchable': true,
        //                 'orderable': true
        //             },
        //             {
        //                 "targets": 2,
        //                 "name": "name",
        //                 'searchable': true,
        //                 'orderable': true
        //             },
        //             {
        //                 "targets": 3,
        //                 "name": "name",
        //                 'searchable': true,
        //                 'orderable': true
        //             },

        //             {
        //                 "targets": 4,
        //                 "name": "name",
        //                 'searchable': true,
        //                 'orderable': true
        //             },
        //             {
        //                 "targets": 5,
        //                 "name": "name",
        //                 'searchable': true,
        //                 'orderable': true
        //             },

        //         ],
        //     });
        // });
        function updateTimers() {
            const timerElements = document.getElementsByClassName('timer');
            for (let i = 0; i < timerElements.length; i++) {
                const timerElement = timerElements[i];
                const startTime = parseInt(timerElement.getAttribute('data-start-time'), 10);
                const currentTime = Math.floor(Date.now() / 1000);
                const elapsedSeconds = currentTime - startTime;
                const hours = Math.floor(elapsedSeconds / 3600);
                const minutes = Math.floor((elapsedSeconds % 3600) / 60);
                const seconds = elapsedSeconds % 60;
                timerElement.innerHTML = `
            <div class="timer-values">
                <div class="timer-value">${hours}</div>
                <div class="timer-value">${minutes}</div>
                <div class="timer-value">${seconds}</div>
            </div>
            <div class="timer-labels">
                <div class="timer-label">HOURS</div>
                <div class="timer-label">MINUTES</div>
                <div class="timer-label">SECONDS</div>
            </div>
        `;
            }
        }
        updateTimers();
        setInterval(updateTimers, 1000);


        $('#deliveryGuyId').change(function() {
            var id = $(this).val();
            $.get('{{ route('kitchen.deliveryboy.order_list.pending.ajax', ':id') }}'.replace(':id', id), function(
                response) {
                if (response.orders) {
                    var orderDetailsHtml = '';
                    if (response.orders.length > 0) {
                        $.each(response.orders, function(index, order) {
                            var viewProductUrl =
                                '{{ route('kitchen.deliveryboy.view_product.details', ':id') }}'
                                .replace(':id', order.id);
                            orderDetailsHtml += `
                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-12 order-item">
                                        <div class="timer-container">
                                            <span class="timer" data-start-time="${Math.floor(new Date(order.endcooking).getTime() / 1000)}"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-2"><span>User Number :</span></div>
                                    <div class="col-8"><strong>${order.uname}</strong></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4 mb-2"><span>Address :</span></div>
                                    <div class="col-8"><strong>${order.house}, ${order.street}, ${order.apartment}, ${order.city}, ${order.state}</strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-2"><span>User Number :</span></div>
                                    <div class="col-8"><strong>${order.user_phone}</strong></div>
                                </div>
                                <div class=""><a href="${viewProductUrl}" class="btn btn-warning btn-sm w-100">View Order Details</a></div>
                                <div class="mt-2">
                                    ${order.status === 'COOKING' || order.status === 'DISPATCHED' ? `<button class="statusdeliver btn btn-sm btn-warning w-100" data-status="COMPLETED" data-id="${order.id}">Deliver</button>` : `<button class="btn btn-sm btn-info">Pickup the food</button>`}
                                </div>
                                <div class="mt-2">
                                    ${order.payment_status === 'PENDING' ? `<button class="statuspaid btn btn-sm btn-warning w-100" data-payment_status="PAID" data-id="${order.id}">Change Payment Status</button>` : `<button class="btn btn-sm btn-success w-100" style="filter: brightness(80%);">Paid<i class="fa fa-check"></i></button>`}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                        });
                    } else {
                        orderDetailsHtml += `
                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                <strong style="font-size:2rem;"> No Delivery Assigned </strong> <span style='font-size:35px;'>&#128522;</span>
                                </div>
                            </div>
                        </div>
                    </div>`        
                    }
                    $('#orderDetailsContent').html(orderDetailsHtml);
                    updateTimers(); // Call this function to initialize the timers
                }
            });
        });

        // Event delegation for statusdeliver button
        $(document).on('click', '.statusdeliver', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            let fd = new FormData();
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('status', status);
            fd.append('id', id);

            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to change status?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('kitchen.deliveryboy.update.order.status.approve') }}",
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
                            });
                    },
                    no: function() {},
                }
            });
        });

        // Event delegation for statuspaid button
        $(document).on('click', '.statuspaid', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var payment_status = $(this).attr('data-payment_status');

            let fd = new FormData();
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('payment_status', payment_status);
            fd.append('id', id);

            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to change payment status?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('kitchen.deliveryboy.update.order.status.payment') }}",
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
                            });
                    },
                    no: function() {},
                }
            });
        });
    </script>
@endsection
@endsection
