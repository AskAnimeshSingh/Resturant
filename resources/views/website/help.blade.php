@extends('website.layout.layout')
@section('extra_css')
@endsection
@section('content')
    <section class="home-banner border-zigzag-up">
        <div id="banner-slide" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="item carousel-item active">
                    <img src="{{ asset('assets/website/images/slide2.webp') }}" alt="Los Angeles" class="img-fluid w-100">
                    <div class="carousel-caption my-auto">
                        <h2 class="text-white">Help Desk</h2>
                    </div>
                </div>
            </div>
        </div>


            <div id="menu"></div>

            <section class="order-menu py-100">
                {{-- <div class="container">
                    <h4 class="primary text-center mb-lg-4">Help Desk</h4>
                    <div class="contact-form" style="background: none !important;padding-top: 0px !important;">
                        <form class="formreply">
                            <div class="row justify-content-center">


                            </div>
                        </form>
                    </div>
                </div> --}}

                {{-- <div class="sky-bg py-50"> --}}
                <div class="container">
                    <div class="col-lg-12 col-md-12 ">
                        <div class="row" style="background-color: rgb(239, 239, 255)">
                            <h6 class="text-center text-uppercase mt-4" style="font-size:28px; font-weight: 600">Get Help
                            </h6>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="footer-widget text-center">
                                        <ul class="widget-list">
                                            <li>
                                                <a href="">
                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                    <div class="details">
                                                        <h6 class="text-uppercase" style="font-size:15px; font-weight: 400">
                                                            Phone</h6>
                                                        <p> {{ $help->phone }}</p>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="footer-widget text-center">
                                        <ul class="widget-list">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    <div class="details">
                                                        <h4 class="text-uppercase" style="font-size:15px; font-weight: 400">
                                                            Description</h4>
                                                        <p>{!! html_entity_decode($help->description) !!} <br>

                                                        </p>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="footer-widget text-center">
                                        <ul class="widget-list">
                                            <li>
                                                <a href="">
                                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                    <div class="details">
                                                        <h4 class="text-uppercase" style="font-size:15px; font-weight: 400">
                                                            Email</h4>
                                                        <p>{{ $help->email }}</p>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </div> --}}
            </section>
    </section>
@section('extra_js')
    <script></script>
@endsection
@endsection
