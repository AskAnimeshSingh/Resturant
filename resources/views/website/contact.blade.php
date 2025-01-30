@extends('website.layout.layout')
@section('extra_css')
@endsection
@section('content')
{{-- <section class="banner-inner border-zigzag-up" style="background-image: url('http://localhost/restaurant_pos/public/assets/website/images/booktable-bg.webp');">
   <div class="container">
       <h2 class="banner-title text-uppercase text-center text-white">Contact</h2>
   </div>
</section> --}}

<section class="contactus py-80 pb-0">
   <div class="container">
       <div class="row">
           <div class="col-lg-7">
               <div class="contact-map">
                   <div class="mapouter">
                       <div class="gmap_canvas">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3503.49079723617!2d77.06977671508149!3d28.58504958243666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d04d87fa425e9%3A0xabbae143206fe3b7!2sXcrino%20Business%20Solutions%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1663849986275!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-lg-5">
               <div class="contact-detail">
                   <h4 class="mb-5 text-uppercase text-default">WE ARE LOCATED IN THE HEART OF India.</h4>
                   <ul>
                       <li class="mb-4">
                           <h6 class="text-uppercase">Address</h6>
                           <a href="#">near Ramphal Chock Road, <br> Sector 7 Dwarka,</a>
                       </li>
                       <li class="mb-4">
                           <h6 class="text-uppercase">Contact</h6>
                           <a class="text-uppercase" href="">345676543</a>
                       </li>
                       <li class="mb-4">
                           <h6 class="text-uppercase">Email</h6>
                           <a class="text-uppercase" href="">demo@restuarant.com</a>
                       </li>
                   </ul>
               </div>
           </div>
       </div>
   </div>
</section>
@section('extra_js')

@endsection
@endsection