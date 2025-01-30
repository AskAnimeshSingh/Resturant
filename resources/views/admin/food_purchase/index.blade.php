@extends('admin.layout.layouts')
@section('extra_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice, .select2-container--default .select2-results__option[aria-selected="true"], .select2-container--default .select2-results__option--highlighted[aria-selected] {
            color: #403838;
            font-weight: bold;
        }

        .select2-selection__choice__remove {
            color: #403838 !important;
            font-weight: bold !important;
        }

        .select2-search__field {
            vertical-align: middle !important;
        }

        th, td {
            border-color: #dbd1d1 !important;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class') }} alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add New Purchase</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{route('admin.food_purchase.new.store')}}" class="store_purchase"
                                  method="POST">
                                @csrf
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Branch <span class="text-danger">*</span></label>
                                            <select name="branch" id="branch" class="form-control" required>
                                                <option value="" selected disabled>Select Branch</option>
                                                @foreach($branches as $key => $getBranches)
                                                    <option value="{{$getBranches->id}}">{{$getBranches->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Supplier <span class="text-danger">*</span></label>
                                            <select name="supplier" id="supplier" class="form-control" required>
                                                <option value="" selected disabled>Select Supplier</option>
                                                @foreach($supplier as $key => $getSupplier)
                                                    <option value="{{$getSupplier->id}}">{{$getSupplier->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Invoice <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="e.g.123"
                                                       name="invoice" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Purchase Date <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" placeholder="Purchase Date"
                                                       name="purchase_date" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <div class="input-group">
                                                <textarea name="description" id="description" cols="30" rows="10"
                                                          class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Payment Type <span class="text-danger">*</span></label>
                                            <select name="payment_type" id="" class="form-control" required>
                                                <option value="" selected disabled>Select Payment Type</option>
                                                <option value="cash">Cash</option>
                                                <option value="cc">Credit Card</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Food Items <span class="text-danger">*</span></label>
                                    <select type="text" class="form-control" name="items[]" id="items" multiple
                                            style="width: 100%" required disabled>
                                        @foreach($foodItems as $key => $getItems)
                                            <option value="{{$getItems->id}}">{{$getItems->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="itemsList">

                                </div>

                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@section('extra_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(function () {

            $('#items').select2({
                multiple: true,
                placeholder: "Please select items.."
            })
        })

        $('#branch').change(function () {
            let branchId = $('#branch').val()
            const foodCount = {{count($foodItems)}}

            if(foodCount > 0)
            {
                $('#items').attr('disabled', false)
            }
        })

        $('#items,#branch').change(function () {

            let branchId = $('#branch').val()
            let items = $('#items').val()

            if (items.length < 1) {
                $('#itemsList').html('')
                return false
            }

            const url = "{{route('admin.food_purchase_items_show')}}"
            const body = {
                branchId, items,
                '_token': "{{ csrf_token() }}"
            }

            let fetchData = {
                method: 'POST',
                body: JSON.stringify(body),
                headers: new Headers({
                    'Content-Type': 'application/json; charset=UTF-8'
                })
            }
            fetch(url, fetchData)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    if (data.status) {
                        $('#itemsList').html(data.data)
                    } else {
                        $('#itemsList').html('')
                    }
                    check()
                })
        })

        function check() {
            $('.qtychange').keyup(function () {
                let id = $(this).attr('data-id')
                let qty = $(this).val()
                let price = $(`.price${id}`).val()
                const subTotal = qty * price
                $(`.total${id}`).html(`${parseFloat(subTotal.toFixed(2))}`)
                $(`.subTotalPrice${id}`).val(`${parseFloat(subTotal.toFixed(2))}`)
                FinalPrice()
                paidAndDue()
            })

            $('.pricechange').keyup(function () {
                let id = $(this).attr('data-id')
                let qty = $(`.qty${id}`).val()
                let price = $(this).val()
                const subTotal = qty * price
                $(`.total${id}`).html(`${parseFloat(subTotal.toFixed(2))}`)
                $(`.subTotalPrice${id}`).val(`${parseFloat(subTotal.toFixed(2))}`)
                FinalPrice()
                paidAndDue()
            })

            $('.paidAmount').keyup(function () {
                let price = $(this).val()
                let tb = $('.totalBill').text()

                let amt = tb - price
                $('.due').val(parseFloat(amt.toFixed(2)))
                $('.dueAmount').html(parseFloat(amt.toFixed(2)))
            })
        }

        function FinalPrice() {
            const numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
            let values = $("input[name='subTotal[]']")
                .map(function () {
                    if (numberRegex.test($(this).val())) {
                        return $(this).val();
                    }
                }).get();

            let total = 0;
            $.each(values, function () {
                total += parseFloat(this, 10);
            });

            $('.totalBill').html(`${parseFloat(total.toFixed(2))}`)
        }

        function paidAndDue() {
            $('.paidAmount').val("")
            $('.due').val("")
            $('.dueAmount').html("0.00")
        }
    </script>
@endsection
@endsection
