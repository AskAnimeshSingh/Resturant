@extends('kitchen.layout.layouts')
@section('extra_css')
    <style>
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section body">
            <div class="card">
                <div class="card-header">
                    Add Chef
                </div>
                <div class="card-body">
                    <form class="editchef" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="first_name" value="{{$chef->first_name}}">
                                    <input type="hidden" name="id" value="{{$chef->id}}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="last_name" value="{{$chef->last_name}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Profile Pic</label>
                                    <input type="file" class="form-control" name="image" onchange="stocks(this);">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row justify-content-left">
                                    <div class="col-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                                src="{{ url($chef->image) }}" width="150px;" alt="your image" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" placeholder="Enter Email" name="email" value="{{$chef->email}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status*</label>
                                    <select class="form-control show-tick ms select2" data-placeholder="Select"
                                        name="status">
                                        <option value="0" {{ $chef->status == '0' ? 'selected' : '' }}>Active</option>
                                        <option value="1" {{ $chef->status == '1' ? 'selected' : '' }}>Inactive</option>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phone</label>
                                    <input type="number" class="form-control" placeholder="Enter Phone" name="phone" value="{{$chef->phone}}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>


    </section>




@section('extra_js')
    <script>
        function stocks(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function() {

            $('.editchef').on('submit', function(e) {
                e.preventDefault()

                let fd = new FormData(this)
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('kitchen.update.chef') }}",
                    type: "POST",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#login-button').prop('disabled', true);
                        $('.loader').show();
                    },
                    success: function(result) {
                        if (result.status) {
                            iziToast.success({
                                title: '',
                                message: result.msg,
                                position: 'topRight'
                            });
                            setTimeout(function() {
                                window.location.href = result.location;
                            }, 500);
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
        });
    </script>
@endsection
@endsection
