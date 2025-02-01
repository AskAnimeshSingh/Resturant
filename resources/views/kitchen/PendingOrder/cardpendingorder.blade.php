{{-- @extends('kitchen.layout.layouts') --}}
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

@section('content1')
    <section class="section">
        <div class="section body">
            {{-- <div class="row"> --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h5>New And Cooking Orders List</h5>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="row">
                    @if (count($groups) > 0)
                        @foreach ($groups as $order)
                            @php

                            @endphp
                            <div class="col-lg-4 col-sm-12 col-md-6">
                                <div class="card">
                                    @if ($order->status == 'PENDING')
                                        <button class="btn btn-primary btn-sm"
                                            style="float: right; width:120px; font-weight:700;">
                                            New Order <span id="timer-{{ $order->id }}"></span>
                                        </button>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                let orderCreatedAt = new Date("{{ $order->created_at }}").getTime();
                                                let timerElement = document.getElementById("timer-{{ $order->id }}");
                            
                                                function updateTimer() {
                                                    let now = new Date().getTime();
                                                    let elapsedTime = Math.floor((now - orderCreatedAt) / 1000); // seconds
                            
                                                    let minutes = Math.floor(elapsedTime / 60);
                                                    let seconds = elapsedTime % 60;
                            
                                                    timerElement.innerText = `(${minutes}m ${seconds}s)`;
                                                }
                            
                                                setInterval(updateTimer, 1000);
                                                updateTimer();
                                            });
                                        </script>
                                    @elseif($order->status == 'COOKING')
                                        <button class="btn btn-success btn-sm"
                                            style="float: right; width:100px; font-weight:700;">
                                            Cooking
                                        </button>
                                    @endif
                            
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5 mb-2">
                                                <span>Order Number :</span>
                                            </div>
                                            <div class="col-7">
                                                <strong>{{ $order->id }}</strong>
                                            </div>
                                        </div>
                            
                                        <div class="row">
                                            <div class="col-5 mb-2">
                                                <span>Customer Name :</span>
                                            </div>
                                            <div class="col-7">
                                                <strong>{{ $order->uname }}</strong>
                                            </div>
                                        </div>
                            
                                        <div class="row">
                                            <div class="col-5 mb-2">
                                                <span>Delivery Type :</span>
                                            </div>
                                            <div class="col-7">
                                                <strong>{{ $order->delivery_type }}</strong>
                                            </div>
                                        </div>
                            
                                        @if ($order->delivery_type == 'Home Delivery')
                                            @if (!empty($order->chef_id))
                                                @if ($order->delivery_id == '')
                                                    <div class="mb-2">
                                                        <button class="btn btn-warning btn-sm w-100 dboymodal"
                                                            data-id="{{ $order->id }}" style="width: 120px">
                                                            Assign Delivery Boy+
                                                        </button>
                                                    </div>
                                                @elseif ($order->delivery_id != '')
                                                    <div class="row">
                                                        <div class="col-5 mb-2">
                                                            <span>Delivery Boy:</span>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>{{ $order->name }}</strong>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                            
                                        <div class="">
                                            <a href="{{ url('kitchen/order-details', $order->id) }}"
                                                class="btn btn-warning btn-sm w-100">
                                                View Order Details
                                            </a>
                                        </div>
                            
                                        @if ($order->status == 'COOKING' && $order->delivery_id != '')
                                            <button class="statusrdispatch btn btn-sm btn-primary w-100 mt-2"
                                                data-status="DISPATCHED" data-id={{ $order->id }}>
                                                Make Ready For Handover
                                            </button>
                                        @elseif ($order->status == 'COOKING' && $order->delivery_type == 'Take Away')
                                            <button class="statusrdispatch btn btn-sm btn-primary w-100 mt-2"
                                                data-status="DISPATCHED" data-id={{ $order->id }}>
                                                Make Ready For Handover
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    @else
                        {{-- <div class="row"> --}}
                        <div class="col-12">
                            <div class="justify-content-center" style="text-align: center; font-size:24px;">No Record Found
                            </div>
                        </div>
                        {{-- </div> --}}
                    @endif
                </div>
                {{-- <div class="d-flex justify-content-center">
                    <div class="your-paginate mt-4">
                        {{$groups->links("pagination::bootstrap-4")}}
                    </div>
                </div> --}}
            </div>
            {{-- </div> --}}

        </div>


    </section>

    <!-- Modal -->
    <div class="modal fade" id="chefclick" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Chef</h5>
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
                                    <option value="{{ $chef->id }}">{{ $chef->first_name . ' ' . $chef->last_name }}
                                    </option>
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


    <!--Delevery Boy Modal -->
    <div class="modal fade" id="dboyclick" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Assign Delivery Boy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="submitdboy">
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <label>Select Delivery Boy</label>
                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="delivery_id">
                                @foreach ($dboys as $dboy)
                                    <option value="{{ $dboy->id }}">{{ $dboy->name }}
                                    </option>
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

        $(document).ready(function() {
            $("body").on("click", ".chefmodal", function(e) {
                // alert('hello');
                // var first_name = $(this).data('first_name');
                // var last_name = $(this).data('last_name');
                var id = $(this).data('id');
                // var datas =
                $('#weborder_id').val(id);
                $('#chefclick').modal('toggle')
            });

            $("body").on("click", ".dboymodal", function(e) {
                // alert('hello');
                // var first_name = $(this).data('first_name');
                // var last_name = $(this).data('last_name');
                var id = $(this).data('id');
                // var datas =
                $('#order_id').val(id);
                $('#dboyclick').modal('toggle')
            });
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


        $("body").on("submit", ".submitdboy", function(e) {
            e.preventDefault()
            let fd = new FormData(this)
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('kitchen.order.store_delivery_boy') }}",
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
                        $(".submitdboy")[0].reset();
                        $("#dboyclick").modal("toggle");
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


        $("body").on("click", ".statuscooking,.statusrdispatch", function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            let fd = new FormData()
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('status', status);
            fd.append('id', id);

            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to change status?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('kitchen.update.order.status.dispatch') }}",
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
    </script>
    {{-- <script>
    var tables = $('#detail').DataTable({
        "processing": true,
        pageLength: 10,
        "serverSide": true,
        "ajax": {
            url: "{{ route('kitchen.order_pending_list.ajax') }}",
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
        ],
    });
</script> --}}
@endsection
@endsection
