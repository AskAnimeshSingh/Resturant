@extends('website.layout.layout')
@section('extra_css')
    <style>
        .contact-form-new {
            padding: 39px 10px
        }
    </style>
@endsection
@section('content')
<section class="py-100">
   <div class="container">
      <div class="row">
         <div class="col-md-6">

            <div class="contact-form-new">
               <h3>Register</h3>

               {{-- <p>Add your phone number to login</p> --}}
               <form class="form_login" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-4 mb-4">
                                <label for="">Person ID.</label>
                                <input type="text" class="form-control" name="person_id" placeholder="Person ID" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ; required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-4 mb-4">
                                <label for="">First Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="First Name" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ; required >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4 mb-4">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ; required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-4 mb-4">
                                <label for="">Phone Number</label>
                                <input type="number" class="form-control" name="phone_number" placeholder="Phone number*" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ; required >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4 mb-4">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ; required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-4 mb-4">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="password" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ; required >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4 mb-4">
                                <label for="">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="password" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ; required >
                            </div>
                        </div>
                    </div>


                    <div class="mb-0 btnsubmit">
                        <button type="submit" name="submit" class="btn btn-primary w-100">Continue</button>
                    </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <img src="{{ asset('assets/website/custom/6.png')}}" alt="" class="img-fluid">
         </div>
      </div>
   </div>
</section>
@section('extra_js')
<script>
   $(function () {
        $('.form_login').on('submit', function(e){
            e.preventDefault()
            let fd = new FormData(this)
            fd.append('_token',"{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('website.register.process') }}",
                type:"POST",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                  $('.loader').show();
                },
                success:function(result){
                    if(result.status)
                    {
                        iziToast.success({
                              title: '',
                              message: result.msg,
                              position: 'topRight'
                            });
                        setTimeout(function(){
                            window.location.href = result.location;
                        }, 500);
                    }
                    else
                    {
                           iziToast.error({
                              title: '',
                              message: result.msg,
                              position: 'topRight'
                            });
                    }
                },
                complete: function () {
                  $('.loader').hide();
                },
                error: function(jqXHR, exception) {
                  $('.loader').hide();
                }
            });
        })
    });

</script>
@endsection
@endsection
