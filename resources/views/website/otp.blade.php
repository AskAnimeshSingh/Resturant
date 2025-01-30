@extends('website.layout.layout')
@section('extra_css')
@endsection
@section('content')
<section class="py-100">
   <div class="container">
      <div class="row">
         <div class="col-md-6">

            <div class="contact-form-new">
               <h3>OTP</h3>

               <p>We have sent an OTP to your number</p>
               <form class="otp_verify" method="POST">
                  <div class="mt-4 mb-4 f-flex">
                     <input type="number" name="f" class="form-control f-1" maxlength="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ;>

                     <input type="number" name="s" class="form-control f-1" maxlength="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ;>

                     <input type="number" name="t" class="form-control f-1" maxlength="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ;>

                     <input type="number" name="l" class="form-control f-1" maxlength="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="border:3px solid #e7eff3 !important;line-height: 2.5 !important" ;>
                  </div>
                  <input type="hidden" name="user_id" value="{{$id}}">
                  <div class="mb-0 btnsubmit">
                     <button type="submit" name="submit" class="btn btn-primary w-100">Verify</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-md-6">
            <img src="{{ asset('assets/website/custom/7.png')}}" alt="" class="img-fluid">
         </div>
      </div>
   </div>
</section>
@section('extra_js')
<script>
   $(function() {
      $('.otp_verify').on('submit', function(e) {
         e.preventDefault()
         let fd = new FormData(this)
         fd.append('_token', "{{ csrf_token() }}");

         $.ajax({
            url: "{{ route('website.otp_verify') }}",
            type: "POST",
            data: fd,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
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
            }
         });
      })
   });
</script>
@endsection
@endsection