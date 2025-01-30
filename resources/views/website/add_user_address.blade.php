@extends('website.layout.layout')
@section('extra_css')
<style>
   .qr-code-generator {
      width: 500px;
      margin: 0 auto;
   }

   .qr-code-generator * {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
   }

   #qrcode {
      width: 128px;
      height: 128px;
      margin: 0 auto;
      text-align: center;
   }

   #qrcode a {
      font-size: 0.8em;
   }

   .qr-url,
   .qr-size {
      padding: 0.5em;
      border: 1px solid #ddd;
      border-radius: 2px;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
   }

   .qr-url {
      width: 79%;
   }

   .qr-size {
      width: 20%;
   }

   .generate-qr-code {
      display: block;
      width: 100%;
      margin: 0.5em 0 0;
      padding: 0.25em;
      font-size: 1.2em;
      border: none;
      cursor: pointer;
      background-color: #e5554e;
      color: #fff;
   }
   .sticky {
    background-color: #000;
   }
</style>
@endsection
@section('content')
<section class="home-banner border-zigzag-up">

   <section class="order-menu py-100">
      <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-top: 5%">
                <form class="home_address" method="POST">
                    <div class="row">
                       <div class="col-md-4">
                          <div class="mb-3">
                             <input type="text" class="form-control" placeholder="House*" name="house" >
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="mb-3">
                             <input type="text" class="form-control" placeholder="Apartment*" name="apartment" >
                          </div>
                       </div>
                       <div class="col-md-4">
                        <div class="mb-3">
                           <input type="text" class="form-control" placeholder="Street*" name="street" >
                        </div>
                     </div>
                       <div class="col-md-4">
                          <div class="mb-3">
                             <input type="text" class="form-control" placeholder="City*" name="city" >
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="mb-3">
                             <input type="text" class="form-control" placeholder="State*" name="state" >
                          </div>
                       </div>
                       <div class="col-md-4">
                            <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Zip Code*" name="zip_code" >
                            </div>
                        </div>
                       <div class="col-md-4">
                          <div class="mb-3">
                             <input type="text" class="form-control" placeholder="Cross Street" name="cross_street" >
                          </div>
                       </div>
                       <div class="col-md-4">
                        <div class="mb-3">
                           <input type="text" class="form-control" placeholder="Block" name="block" >
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <input type="text" class="form-control" placeholder="Plot No" name="plot_no" >
                        </div>
                     </div>
                       {{-- <div class="col-md-12">
                          <div class="mb-3 ">
                             <textarea class="form-control" placeholder="special Instruction" name="instruction"></textarea>
                          </div>
                       </div> --}}
                       <div class="col-md-12">
                          <div class="mb-0 text-center btnsubmit">
                             <button type="submit" name="submit" class="btn btn-primary">Add Address</button>
                             {{-- <a href="javascript:void(0)"><button type="button" class="btn btn-success">Next</button></a> --}}
                          </div>
                       </div>
                    </div>
                 </form>
            </div>
        </div>
      </div>
   </section>
</section>

 @section('extra_js')

 <script>
   $(function()
   {
      $(".home_address").on("submit" , function(e) {
         e.preventDefault();
         let fd = new FormData(this)
         fd.append('_token', "{{ csrf_token() }}");

         $.ajax({
            url: "{{ route('website.user.address.add') }}",
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
                  setTimeout(() => {
                    location.reload()
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
            }
         });
      })

   })


</script>
 @endsection
 @endsection
