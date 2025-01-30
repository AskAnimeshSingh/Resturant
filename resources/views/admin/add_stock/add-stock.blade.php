@extends('admin.layout.layouts')
@section('extra_css')
    <style>
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <div class="card">
                        <div class="card-header float-right">
                            <h4>Stock</h4>
                        </div>
                        <div class="card-body">
                            <form class="addstock">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" class="form-control" name="name" id=""
                                                placeholder="Enter Product Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Price</label>
                                            <input type="number" class="form-control" name="price" id=""
                                                placeholder="Enter Price">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Unit</label>
                                            <select name="unit" class="form-control" id="exampleFormControlSelect1">
                                                <option value="">Select Unit</option>
                                                <option value="Kg">Kg</option>
                                                <option value="Litre">Litre</option>
                                                <option value="Quantity">Quantity</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Stock</label>
                                            <input type="number" class="form-control" name="stock" id=""
                                                placeholder="Enter Stock">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Stock Received From</label>
                                            <input type="text" class="form-control" name="stock_received_from"
                                                id="" placeholder="Enter Received From">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Expiry Date</label>
                                            <input type="date" class="form-control" name="expiry_date" id=""
                                                placeholder="Enter Your Email">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Product Image</label>
                                            <input type="file" class="form-control" name="product_image" required
                                                onchange="stocks(this);"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="row justify-content-left">
                                            <div class="col-4 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                                        src="{{ asset('assets/admin/assets/img/default_cate.jpeg') }}"
                                                        alt="your image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2 mb-4"><button type="submit"
                                        class="btn btn-primary btn-lg btn-block">Save</button></div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
 @section('extra_js')
    <script>
        $("body").on("submit", ".addstock", function(e) {
            e.preventDefault()
            let fd = new FormData(this)
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('admin.add.stock') }}",
                type: "POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,

                success: function(result) {
                    if (result.status) {
                        iziToast.success({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.view.stock') }}"
                        }, 1500);

                    } else {
                        iziToast.error({
                            title: '',
                            message: result.msg,
                            position: 'topRight'
                        });
                    }
                },

                error: function(jqXHR, exception) {
                    console.log('bye');
                    console.log(jqXHR.responseText);
                }
            });
        })

        function stocks(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
 @endsection
@endsection
