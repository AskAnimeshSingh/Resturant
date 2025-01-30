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
                            <h4>Edit Ingredient Purchase</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{route('admin.ingredient_purchase_update')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" class="form-control" name="ind_id" value="{{$data->id}}" readonly>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Branch <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Branch" value="{{$data->branchName}}" readonly>
                                            <input type="hidden" class="form-control" placeholder="Branch" name="branch" value="{{$data->branch_id}}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Supplier <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Supplier" value="{{$data->supplierName}}" readonly>
                                            <input type="hidden" class="form-control" placeholder="Supplier" name="supplier" value="{{$data->supplier_id}}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Invoice <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="e.g.123"
                                                       name="invoice" value="{{$data->invoice}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Purchase Date <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" placeholder="Purchase Date"
                                                       value="{{$data->purchase_date}}"
                                                       name="purchase_date" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <div class="input-group">
                                                <textarea name="description" id="description" cols="30" rows="10"
                                                          class="form-control">{{$data->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Payment Type <span class="text-danger">*</span></label>
                                            <select name="payment_type" id="" class="form-control" required>
                                                <option value="" selected disabled>Select Payment Type</option>
                                                <option value="cash" @if($data->payment_type==="cash") selected @endif>
                                                    Cash
                                                </option>
                                                <option value="cc" @if($data->payment_type==="cc") selected @endif>
                                                    Credit Card
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Ingredient Items <span class="text-danger">*</span></label>
                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <th>Name</th>
                                            <th>Stock</th>
                                            <th>Qty</th>
                                            <th>Rate</th>
                                            <th>Total</th>
                                        </tr>
                                        @foreach ($ingredient_stocks as $getData)
                                            <input type="hidden" name="stockId[]" value="{{$getData->id}}">
                                            <tr>
                                                <td>{{$getData->name}}</td>
                                                <td>{{\App\Helpers\MyHelper::getIngredientStock($getData->ingredient_id,$getData->branch_id)}}</td>
                                                <td><input type="text"
                                                           class="form-control text-center qtychange qty{{$getData->id}}"
                                                           data-id="{{$getData->id}}" value="{{$getData->stock}}"
                                                           name="qty[]" placeholder="Qty"
                                                           required></td>
                                                <td><input type="text"
                                                           class="form-control text-center pricechange price{{$getData->id}}"
                                                           data-id="{{$getData->id}}" value="{{$getData->price}}"
                                                           name="price[]"
                                                           placeholder="Price in USD" required></td>
                                                <td class="d-none"><input type="text" name="subTotal[]"
                                                                          class="form-control text-center subTotalPrice{{$getData->id}}"
                                                                          value="{{$getData->stock * $getData->price}}">
                                                </td>
                                                <td>$ <span
                                                        class="total{{$getData->id}}">{{$getData->stock * $getData->price}}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>Total Bill</th>
                                            <th>$ <span class="totalBill">{{$data->total_amount}}</span></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>Paid</th>
                                            <th><input type="text" class="form-control text-center paidAmount"
                                                       name="totalPrice" value="{{$data->paid_amount}}"
                                                       placeholder="Price in USD" required></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>Due</th>
                                            <th class="d-none"><input type="text" class="form-control text-center due"
                                                                      name="duePrice" value="{{$data->due_amount}}"
                                                                      placeholder="Price in USD"></th>
                                            <th>$ <span class="dueAmount">{{$data->due_amount}}</span></th>
                                        </tr>
                                    </table>
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
            const ingredientCount = "10"

            if (ingredientCount > 0) {
                $('#items').attr('disabled', false)
            }
        })

        // function check() {
        $('.qtychange').keyup(function () {
            let id = $(this).attr('data-id')
            let qty = $(this).val()
            let price = $(`.price${id}`).val()
            const subTotal = qty * price
            $(`.total${id}`).html(`${parseFloat(subTotal.toFixed(2))}`)
            $(`.subTotalPrice${id}`).val(`${parseFloat(subTotal.toFixed(2))}`)
            FinalPrice()
            // paidAndDue()
            dueBill('off')
        })

        $('.pricechange').keyup(function () {
            let id = $(this).attr('data-id')
            let qty = $(`.qty${id}`).val()
            let price = $(this).val()
            const subTotal = qty * price
            $(`.total${id}`).html(`${parseFloat(subTotal.toFixed(2))}`)
            $(`.subTotalPrice${id}`).val(`${parseFloat(subTotal.toFixed(2))}`)
            FinalPrice()
            // paidAndDue()
            dueBill('off')
        })

        $('.paidAmount').keyup(function () {
            dueBill('on')
        })

        function dueBill(type) {

            let price = $('.paidAmount').val()

            let tb = $('.totalBill').text()

            let amt = tb - price
            $('.due').val(parseFloat(amt.toFixed(2)))
            $('.dueAmount').html(parseFloat(amt.toFixed(2)))
        }

        // }

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

    </script>
@endsection
@endsection
