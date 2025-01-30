@extends('kitchen.layout.layouts')
@section('extra_css')
    <style>
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section body">
            <div class="card">
                <div class="card-header justify-content-between">
                    <div class="">Add Chef</div>
                    <div class=""><a href="{{route('kitchen.list.chef')}}" class="btn btn-primary btn-sm">Chef List</a></div>
                </div>
                <div class="card-body">
                    <form class="addchef" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="first_name">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="last_name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Profile Pic</label>
                                    <input type="file" class="form-control" placeholder="Enter Name" name="image">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" placeholder="Enter Email" name="email">
                                </div>
                            </div>
                        </div>



                          <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status*</label>
                                    <select class="form-control show-tick ms select2" data-placeholder="Select" name="status">
                                        <option value="0">Active</option>
                                        <option value="1">Inactive</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phone</label>
                                    <input type="number" class="form-control" placeholder="Enter Phone" name="phone">
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
$(function() {

$('.addchef').on('submit', function(e) {
    e.preventDefault()

    let fd = new FormData(this)
    fd.append('_token', "{{ csrf_token() }}");
    $.ajax({
        url: "{{ route('kitchen.add.chef') }}",
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
