@extends('website.layout.layout')
@section('extra_css')
<style>
    header.header-area.sticky {
        padding: 0.5rem !important;
    }
</style>
@endsection
@section('content')

<!--- Menu -->
<section>
    <div class="container-fluid">
        <div class="row">

            <!-- First column -->



            <!-- Second Column -->

            <div class="col-md-12">
                <div class="bg-lights ms-2 mt-3">

                    <!-- MENUS -->

                    <div id="menus" class="j-tab p-3">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h3>Menus</h3>
                                <p>Choose Category</p>

                                <!-- Tabs -->

                                <ul class="nav nav-pills mb-3 nav-category text-nowrap" id="pills-tab">
                                    <li class="nav-item">
                                        <button class="nav-link catg-link active d-flex align-items-center rounded-pill px-4" id="pills-all" data-bs-toggle="pill" data-bs-target="#all" type="button">
                                            <img src="{{ asset('assets/website/image/shwarma.webp')}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4"> All</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link catg-link d-flex align-items-center rounded-pill px-4" id="pills-pizza" data-bs-toggle="pill" data-bs-target="#pizza" type="button" role="tab">
                                            <img src="{{ asset('assets/website/image/4.webp')}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4">Pizza</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link catg-link d-flex align-items-center rounded-pill px-4" id="pills-burger" data-bs-toggle="pill" data-bs-target="#burger" type="button" role="tab">
                                            <img src="{{ asset('assets/website/image/2.jpg')}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4">Shawarma</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link catg-link d-flex align-items-center rounded-pill px-4" id="pills-snacks" data-bs-toggle="pill" data-bs-target="#snacks" type="button"><img src="{{ asset('assets/website/image/smooth.webp')}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4"> Smoothies</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link catg-link d-flex align-items-center rounded-pill px-4" id="pills-china" data-bs-toggle="pill" data-bs-target="#china" type="button" role="tab">
                                            <img src="{{ asset('assets/website/image/milk.jpg')}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4">MilkShakes</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link catg-link d-flex align-items-center rounded-pill px-4" id="pills-grilled" data-bs-toggle="pill" data-bs-target="#grilled" type="button" role="tab">
                                            <img src="{{ asset('assets/website/image/3.jpg')}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4">Grill Sandwich</button>
                                    </li>

                                </ul>

                                <!-- Tab Content -->

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active mx-2" id="all">
                                        <div class="row">

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/milk.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Milk Shake</p>
                                                        <p class="text-center">$26.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/3.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Grill Sandwich</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/4.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Trail Mix Smoothie</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/1.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Pot Chicken Shawarma</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/5.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Meat Pizza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/2.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Keto Beef Shawarma</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/5.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Veggie Piza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/3.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Pepperoni Pizza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/4.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Cheese Pizza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane fade mx-2" id="pizza" role="tabpanel">
                                        <div class="row">

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/5.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Veggie Pizza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/3.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Pepperoni Pizza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/4.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Cheese Pizza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/5.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Meat Pizza</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane fade mx-2" id="burger" role="tabpanel">
                                        <div class="row">

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/1.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Pot Chicken Shawarma</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/2.webp')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Keto Beef Shawarma</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade mx-2" id="snacks" role="tabpanel">
                                        <div class="row">

                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/4.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Trail Mix Smoothie</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade mx-2" id="china" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/milk.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Milk Shake</p>
                                                        <p class="text-center">$26.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade mx-2" id="grilled" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 col-md-12">
                                                <div class="card card-menu mb-3" data-bs-toggle="modal" data-bs-target="#modal-menus">
                                                    <div class="card-body">
                                                        <img src="{{ asset('assets/website/image/3.jpg')}}" alt="" class="img-menu mx-auto d-block">
                                                        <p class="text-center fw-bold mt-3 mb-0">Grill Sandwich</p>
                                                        <p class="text-center">$56.00</p>
                                                        <div class="clearfix">
                                                            <div class="float-start c-text">
                                                                <a href="" data-bs-toggle="modal" data-bs-target="#customisable"><i class="fa fa-cutlery"></i> Custom</a>
                                                            </div>
                                                            <div class="float-end">
                                                                <a href="login.html" class="p-2 btn-primary"><i class="fa fa-cart-shopping"></i> Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <!-- Third  Column -->


        </div>
    </div>


</section>
<!-- Modal -->

<div class="modal fade" id="customisable" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose Your Topping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->

            <div class="modal-body">
                <h6 style="color: #569fd4;">MEATS</h6>
                <div class="container px-0 mt-3">
                    <div class="row accordion">
                        <!-- First Collapse -->
                        <div class="col-md-6 mb-3">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                    <h2 class="accordion-button collapsed px-1 text-dark pt-0  border-bottom" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        Pepperoni <br>
                                        50 cal/slice
                                    </h2>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse">
                                    <div class="accordion-body ps-0 pt-1">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <div class="click-menu">
                                                    <img src="custom/1.png" alt="">
                                                    <p class="mb-0">Left</p>
                                                </div>
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu">
                                                    <img src="custom/2.png" alt="">
                                                    <p class="mb-0">Center</p>
                                                </div>
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu">
                                                    <img src="custom/3.png" alt="">
                                                    <p class="mb-0">Right</p>
                                                </div>
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu">
                                                    <img src="custom/4.png" alt="" class="img-special">
                                                    <p class="mb-0">Extra</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Collapse -->

                        <div class="col-md-6 mb-3">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingTwo">
                                    <h2 class="accordion-button collapsed px-1 text-dark pt-0 border-bottom" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        Italian Suasage <br>
                                        50 cal/slice
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="accordion-collapse collapse">
                                    <div class="accordion-body ps-0 pt-1">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <div class="click-menu-2">
                                                    <img src="custom/1.png" alt="">
                                                    <p class="mb-0">Left</p>
                                                </div>
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu-2">
                                                    <img src="custom/2.png" alt="">
                                                    <p class="mb-0">Center</p>
                                                </div>

                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu-2">
                                                    <img src="custom/3.png" alt="">
                                                    <p class="mb-0">Right</p>
                                                </div>

                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu-2">
                                                    <img src="custom/4.png" alt="" class="img-special">
                                                    <p class="mb-0">Extra</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 style="color: #569fd4;">VEGGIES</h6>

                        <!-- Third Collapse -->

                        <div class="col-md-6 mb-3">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed  px-1 text-dark pt-0 border-bottom" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        Mushrooms
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse">
                                    <div class="accordion-body ps-0 pt-1">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <div class="click-menu-3">
                                                    <img src="custom/1.png" alt="">
                                                    <p class="mb-0">Left</p>
                                                </div>
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu-3">
                                                    <img src="custom/2.png" alt="">
                                                    <p class="mb-0">Center</p>
                                                </div>
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu-3">
                                                    <img src="custom/3.png" alt="">
                                                    <p class="mb-0">Right</p>
                                                </div>
                                            </div>
                                            <div class="col-3 text-center">
                                                <div class="click-menu-3">
                                                    <img src="custom/4.png" alt="" class="img-special">
                                                    <p class="mb-0">Extra</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>

            <!-- End Modal Body -->

            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="fa fa-cart-shopping"></i> Add to Cart</button>
            </div>
        </div>
    </div>\
</div>

<!-- End Modal -->
@section('extra_js')
<script>
    $(document).ready(function() {
        const url = String(window.location.href)
        const u = url.split('?=')
        if (u.length === 2) {
            const a = u[1]
            $('.food-card').removeClass('repair-active-new')
            $(`a[data-target="#${a}"] .card`).addClass('repair-active-new')
            $('.j-tab').hide()
            $(`#${a}`).show()
        }
        $(".j-nav").click(function(e) {
            e.preventDefault();
            const target = $(this).attr('data-target')
            $('.j-tab').hide()
            $(target).show()
            const name = $(this).attr('data-name')
            history.pushState({}, "POS", "pos.html?=" + name)
        });
    });

    // quantity js
    function incrementQty() {
        var value = document.querySelector('input[name="qty"]').value;
        var cardQty = document.querySelector(".cart-qty");
        value = isNaN(value) ? 1 : value;
        value++;
        document.querySelector('input[name="qty"]').value = value;
        cardQty.innerHTML = value;
        cardQty.classList.add("rotate-x");
    }

    function decrementQty() {
        var value = document.querySelector('input[name="qty"]').value;
        var cardQty = document.querySelector(".cart-qty");
        value = isNaN(value) ? 1 : value;
        value > 1 ? value-- : value;
        document.querySelector('input[name="qty"]').value = value;
        cardQty.innerHTML = value;
        cardQty.classList.add("rotate-x");
    }

    function removeAnimation(e) {
        e.target.classList.remove("rotate-x");
    }
    const counter = document.querySelector(".cart-qty");
    counter.addEventListener("animationend", removeAnimation);

    $(document).ready(function() {
        $('.menu-add-class .class-add .food-card').click(function() {
            $('.food-card').removeClass("repair-active-new");
            $(this).addClass("repair-active-new");
        });
        $('.click-menu').click(function() {
            $('.click-menu').removeClass("add-menu");
            $(this).addClass("add-menu");
        });
        $('.click-menu-2').click(function() {
            $('.click-menu-2').removeClass("add-menu-2");
            $(this).addClass("add-menu-2");
        });
        $('.click-menu-3').click(function() {
            $('.click-menu-3').removeClass("add-menu-3");
            $(this).addClass("add-menu-3");
        });
        $('.payment .payment-item').click(function() {
            $('.payment-item').removeClass("repair-active");
            $(this).addClass("repair-active");
        });
    });
    $(document).ready(function() {
        $('#example').DataTable();
        $('.catg-link').click(function(argument) {
            $(this)[0].scrollIntoView({
                behavior: "smooth",
                block: "nearest",
                inline: "center"
            })
        })
    });

    /* zoomer image */
    $(document).ready(function() {
        $('.sp-wrap').smoothproducts();
    });
</script>
@endsection
@endsection