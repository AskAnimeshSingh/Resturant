<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Restaurant</title>
   <link rel="stylesheet" href="{{ asset('assets/website/css/font-awesome.min.css')}}" type="text/css">
   <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('assets/website/font/stylesheet.css')}}" type="text/css">
   <link rel="stylesheet" href="{{ asset('assets/website/css/bootstrap.css')}}" type="text/css">
   <link rel="stylesheet" type="text/css" href="{{ asset('assets/website/font/flaticon.css')}}">
   <link rel="stylesheet" href="{{ asset('assets/website/css/aos.css')}}" type="text/css">
   <link rel="stylesheet" href="{{ asset('assets/website/css/style.css')}}" type="text/css">
   <link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css')}}" type="text/css">
   <link rel="stylesheet" href="{{ asset('assets/admin/assets/bundles/izitoast/css/iziToast.min.css')}}">
   <link rel='shortcut icon' type='image/x-icon' href='{{asset('assets/website/images/logo.webp')}}' />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

   <style>
      .border-new {
         border: 1px dashed black;
         width: 150px;
         padding: 10px;
         margin: auto;
      }
   </style>
   @yield('extra_css')
</head>

<body>
   <div class="loader"></div>
   <a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--fade-out" data-bs-abc="true"><i class="fa fa-caret-up" aria-hidden="true"></i>
   </a>

   <!--include footer-->
   @include('website.include.header')

   <main>
      @yield('content')
   </main>

   <!--include footer-->
   @include('website.include.footer')

   <!-- Modal -->

   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="contact-form" style="padding: 20px !important;">
                  <form class="save_address" method="POST">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="tel" class="form-control" placeholder="Phone Number*" name="phone_number">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="FirstName*" name="first_name">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="Last Name*" name="last_name">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="Middle Name*" name="middle_name">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="email" class="form-control" placeholder="Email Address*" name="email_address">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="Business Name*" name="bussiness_name">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="Street*" name="street">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="City*" name="city">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="State*" name="state">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="House*" name="house">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="Apartment*" name="apartment">
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="mb-3 ">
                              <textarea class="form-control" placeholder="special Instruction" name="instruction"></textarea>
                           </div>
                        </div>
                        <div class="col-lg-12 formrow formbtn">
                           <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script src="{{ asset('assets/website/js/aos.js')}}"></script>
   <script>
      AOS.init();
   </script>
   <script src="{{ asset('assets/website/js/jquery.min.js')}}"></script>
   <script src="../../../cdn.jsdelivr.net/npm/%40popperjs/core%402.10.2/dist/umd/popper.min.js"></script>
   <script src="{{ asset('assets/website/js/bootstrap.js')}}"></script>
   <script src="{{ asset('assets/website/js/backtotop.js')}}"></script>
   <script src="{{ asset('assets/admin/assets/bundles/izitoast/js/iziToast.min.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

   <script>
      $('.loader').hide();

      $(function() {
         $(".save_address").on("submit", function(e) {
            e.preventDefault();
            let fd = new FormData(this)
            fd.append('_token', "{{ csrf_token() }}");

            $.ajax({
               url: "{{ route('website.home_address') }}",
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
                     $("#example").modal('toggle');
                  } else {
                     iziToast.error({
                        title: '',
                        message: result.msg,
                        position: 'topRight'
                     });
                     $("#example").modal('toggle');
                     $(".save_address")[0].reset();
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

   <script>
      $(function() {
         $('.owl-prev').hide();
         $('.owl-next').click(() => {
            $('.owl-prev').fadeIn(300);
         })
      })
   </script>
   @yield('extra_js')
</body>

</html>
