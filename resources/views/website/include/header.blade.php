
 @if(request()->is('menu') || request()->is('login') || request()->is('otp/id') || request()->is('pos_detail')
 || request()->is('pos-detail') || request()->is('contact') || request()->is('privacy') || request()->is('term') || request()->is('/help') )
 <section class="header-area p-0" style="background: #e01414;">
   <div class="container">
      <div class="row">
         <div class="col-md-12 px-0">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
               <a class="navbar-brand" href="{{url('')}}"><img src="{{asset('assets/website/images/logo.webp')}}" alt="logo" title="logo" class="img-fluid" style="width:150px !important"></a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto ">
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white  {{request()->is('/') == "/" ? 'active' : ''}}" aria-current="page" href="{{ route('website.dashboard')}}">Home</a>
                     </li>
                     <li class="nav-item me-5">
                        @if(Auth::user())
                        <a class="nav-link p-0 text-white  {{request()->is('pos_detail') == "/" ? 'active' : ''}}" href="{{ route('website.pos_detail')}}">Menu</a>
                        @else
                        <a class="nav-link p-0 text-white  {{request()->is('menu') == "/" ? 'active' : ''}}" href="#menu">Menu</a>
                        @endif
                     </li>
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white  {{request()->is('/') == "contact" ? 'active' : ''}}" href="{{ route('website.contact')}}">Contact</a>
                     </li>
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white {{request()->is('/privacy') == "privacy" ? 'active' : ''}}" href="{{ route('website.privacy')}}">Privacy & policy</a>
                     </li>
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white {{request()->is('/term') == "term" ? 'active' : ''}}" href="{{ route('website.term')}}">Term & condition</a>
                     </li>
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white  {{request()->is('help') == "/" ? 'active' : ''}}" href="{{ route('website.help.view')}}">Help</a>
                        </li>
                  </ul>
                  @if(Auth::user())
                  <button class="btn btn-danger"  type="button" onclick="event.preventDefault();document.getElementById('user_logout_form').submit();">
                    {{ Auth::user()->name }}</button>
                  @else
                    <a href="{{ route('website.login')}}"><button class="btn btn-danger"  type="button">
                        LOGIN</button></a>
                    <a href="{{ route('website.register')}}"><button class="btn btn-danger"  type="button">
                    Register</button></a>
                  @endif
               </div>
            </nav>
         </div>
      </div>
   </div>
</section>

   @else
   <header class="header-area sticky">
      <div class="container">
         <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
               <a class="navbar-brand p-0" href="index.html"><img src="{{ asset('assets/website/images/logo.webp')}}" alt="logo" title="logo"></a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto ">
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white  {{request()->is('/') == "/" ? 'active' : ''}}" aria-current="page" href="{{ route('website.dashboard')}}">Home</a>
                     </li>
                     <li class="nav-item me-5">
                        @if(Auth::user())
                        <a class="nav-link p-0 text-white  {{request()->is('pos_detail') == "/" ? 'active' : ''}}" href="{{ route('website.pos_detail')}}">Menu</a>
                        @else
                        <a class="nav-link p-0 text-white  {{request()->is('menu') == "/" ? 'active' : ''}}" href="#menu">Menu</a>
                        @endif
                     </li>
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white  {{request()->is('contact') == "/" ? 'active' : ''}}" href="{{ route('website.contact')}}">Contact</a>
                     </li>
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white {{request()->is('/privacy') == "privacy" ? 'active' : ''}}" href="{{ route('website.privacy')}}">Privacy & policy</a>
                     </li>
                     <li class="nav-item me-5">
                        <a class="nav-link p-0 text-white {{request()->is('/term') == "term" ? 'active' : ''}}" href="{{ route('website.term')}}">Term & condition</a>
                     </li>

                     <li class="nav-item me-5">
                     <a class="nav-link p-0 text-white  {{request()->is('help') == "/" ? 'active' : ''}}" href="{{ route('website.help.view')}}">Help</a>
                     </li>
                  </ul>
                  @if(Auth::user())
                  <button class="btn btn-danger"  type="button" onclick="event.preventDefault();document.getElementById('user_logout_form').submit();">
                     {{ Auth::user()->name }}</button>
                  @else
                     <a href="{{ route('website.login')}}"><button class="btn btn-danger"  type="button">
                        LOGIN</button></a>
                     <a href="{{ route('website.register')}}"><button class="btn btn-danger"  type="button">
                        Register</button></a>
                  @endif
               </div>
            </nav>
         </div>
      </div>
   @endif
   <form id="user_logout_form" action="{{ route('website.logout') }}" method="POST" class="display-none">
      @csrf
  </form>
</header>
