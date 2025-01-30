@extends('website.layout.layout')
@section('extra_css')

@endsection
@section('content')
<section>
   <div class="container-fluid">
      <div class="row">

         <!-- First column -->

         <div class="col-md-2 p-2">
            <div class="row pt-3 menu-add-class">
               <div class="col-lg-6 col-md-12">
                  <a href="" class="j-nav class-add" data-target="#menus" data-name="menus">
                     <div class="card text-center mb-3 food-card repair-active-new">
                        <div class="card-body">
                           <div class="h2 mb-0">
                              <i class="fa fa-bars"></i>
                           </div>
                           <p class="mb-0">Menus</p>
                        </div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-6 col-md-12">
                  <a href="" class="j-nav class-add" data-target="#combo" data-name="combo">
                     <div class="card text-center mb-3 food-card ">
                        <div class="card-body">
                           <div class="h2 mb-0">
                              <i class="fa fa-bars"></i>
                           </div>
                           <p class="mb-0">Combo Pack</p>
                        </div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-6 col-md-12">
                  <a href="" class="j-nav class-add" data-target="#cart" data-name="cart">
                     <div class="card text-center mb-4 food-card">
                        <div class="card-body">
                           <div class="h2 mb-0">
                              <i class="fa fa-shopping-cart"></i>
                           </div>
                           <p class="mb-0">Cart</p>
                        </div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-6 col-md-12">
                  <a href="" class="j-nav class-add" data-target="#orders" data-name="orders">
                     <div class="card text-center mb-4 food-card">
                        <div class="card-body">
                           <div class="h2 mb-0">
                              <i class="fa fa-shopping-bag"></i>
                           </div>
                           <p class="mb-0">Orders</p>
                        </div>
                     </div>
                  </a>
               </div>


               <div class="col-md-6">
                  <a href="" class="j-nav class-add" data-target="#profile" data-name="profile">
                     <div class="card text-center mb-4 food-card ">
                        <div class="card-body">
                           <div class="h3 mb-0">
                              <i class="fa fa-user"></i>
                           </div>
                           <p class="mb-0">Profile</p>
                        </div>
                     </div>
                  </a>
               </div>

               <div class="col-md-6">
                  <a href="javscript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                     <div class="card text-center mb-4 food-card">
                        <div class="card-body">
                           <div class="h2 mb-0">
                              <i class="fa fa-sign-out"></i>
                           </div>
                           <p class="mb-0">Logout</p>
                        </div>
                     </div>
                  </a>
                  <form id="logout-form" action="{{ route('website.logout') }}" method="POST" class="display-none">
                     @csrf
                  </form>
               </div>


               <div class="col-md-12 text-center bottom-position">
                  <img src="{{asset('assets/website/images/bottom-img.png')}}" alt="" class="img-fluid w-75 mx-auto d-block">
                  <p class="fw-bold">First, we eat. Then, we do everything else.</p>
               </div>

            </div>
         </div>



         <!-- Second Column -->

         <div class="col-md-7 p-2">
            <div class="bg-lights ms-2 mt-3">

               <!-- MENUS -->

               <div id="menus" class="j-tab p-3">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <h3>Menus</h3>
                        <p>Choose Category</p>

                        <!-- Tabs -->

                        <ul class="nav nav-pills mb-3 nav-category" id="pills-tab">
                           <li class="nav-item">
                              <button class="nav-link catg-link active d-flex align-items-center rounded-pill px-4 get_menu1" id="pills-all" data-bs-toggle="pill" data-bs-target="#all" type="button">
                                 <img src="{{asset('assets/website/images/1.webp')}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4"> All</button>
                           </li>
                           @foreach ($category as $item)
                           <li class="nav-item">
                              <button class="nav-link catg-link d-flex align-items-center rounded-pill px-4 get_menu" data-id="{{$item->id}}" id="pills-all" data-bs-toggle="pill" data-bs-target="#all">
                                 <img src="{{url($item->cate_img)}}" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4">{{$item->cate_name}}</button>
                           </li>
                           @endforeach
                        </ul>

                        <ul class="nav nav-pills mb-3 nav-category sub_category_list" id="pills-tab">

                        </ul>

                        <!-- Tab Content -->

                        <div class="tab-content main-scrollbar">
                           <div class="tab-pane fade show active mx-2" id="all">
                              <div class="row" id="menu_list">
                              </div>
                              <div class="more">

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!--Combo Pack-->
               <div id="combo" class="j-tab p-3">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <h3>Combo Pack</h3>

                        <!-- Tab Content -->

                        <div class="tab-content main-scrollbar">
                           <div class="tab-pane fade show active mx-2" id="all">
                              <div class="row" id="combo_pack_list">
                              </div>
                              <div class="load_more">

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>



               <!-- Cart -->
               <div id="cart" class="j-tab p-3" style="display: none;">
                  <div class="row">
                     <div class="col-md-12 mb-3">

                        <h3>Cart</h3>
                        <p>Choose</p>

                        <div class="main-scrollbar">
                           <div class="mx-2" id="cart_list">
                           </div>
                        </div>

                     </div>
                  </div>
               </div>

               <!-- Orders -->


               <div id="orders" class="j-tab p-3" style="display: none;">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <h3>Orders</h3>
                        <p>Details</p>

                        <div class="main-scrollbar">
                           <div class="card table-card mx-2">
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table id="example" class="table table-striped table-order text-nowrap" style="width: 100%">
                                       <thead>
                                          <tr>
                                             <th><i class="fa fa-calendar"></i> Date</th>
                                             <th><i class="fa fa-cutlery"></i>User Phone</th>
                                             <th><i class="fa fa-cutlery"></i>User Name</th>
                                             <th><i class="fa fa-cutlery"></i>User Address</th>
                                             <th><i class="fa fa-cutlery"></i> Txn id</th>
                                             <th><i class="fa fa-cutlery"></i> Invoice id</th>
                                             <th><i class="fa fa-receipt"></i> Transaction Type</th>
                                             <th><i class="fa fa-money"></i> Price</th>
                                             <th><i class="fa fa-money"></i>Status</th>
                                             <th><i class="fa-solid fa-money-bill"></i>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- profile -->

               <div id="profile" class="j-tab p-3" style="display: none;">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <h3>Profile</h3>
                        <div class="card bg-white border-0">
                           <div class="col-md-12">
                              <div class="mb-3 float-end">
                                 <div class="mb-0 text-center btnsubmit">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal" type="button"><i class="fa fa-plus"></i> Add Address</button>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="menubar">
                                 <div class="contact-form">
                                    <form method="POST" class="update_profile">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="mb-3">
                                                <input type="text" class="form-control" placeholder="Name*" name="name" value="@if(!empty(Auth::user()->name)) {{Auth::user()->name}} @endif">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="mb-3">
                                                <input type="email" class="form-control" placeholder="Email*" name="email" value="@if(!empty(Auth::user()->email)) {{Auth::user()->email}} @endif">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="mb-3">
                                                <input type="date" class="form-control" placeholder="Date of Birth*(m-d-Y)" name="dob" value="@if(!empty(Auth::user()->dob)) {{date('dd-mm-yyyy' , strtotime(Auth::user()->dob))}} @endif">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="mb-3">
                                                <select name="age" id="age-group" class="form-control">
                                                   <option>Age Group</option>
                                                   <option value="10-25" @if(!empty(Auth::user()->age)) {{Auth::user()->age == "10-25" ? 'selected' : '' }} @endif>10 - 25</option>
                                                   <option value="15-25" @if(!empty(Auth::user()->age)) {{Auth::user()->age == "15-25" ? 'selected' : '' }} @endif>15 - 25</option>
                                                   <option value="20-25" @if(!empty(Auth::user()->age)) {{Auth::user()->age == "20-25" ? 'selected' : '' }} @endif>20 - 25</option>
                                                </select>
                                             </div>
                                          </div>

                                          <div class="col-md-12">
                                             {{-- <div class="mb-3 ">
                                                <textarea class="form-control" placeholder="Address*" name="address">@if(!empty(Auth::user()->address)) {{Auth::user()->address}} @endif</textarea>
                                             </div> --}}
                                          </div>
                                          <div class="col-md-12">
                                             <div class="mb-0 text-center btnsubmit">
                                                <button name="submit" type="submit" class="btn btn-primary">Save</button>
                                             </div>
                                          </div>

                                       </div>
                                    </form>
                                 </div>
                                 <div class="row">
                                    <div class="user_address_show"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Add Address-->
               <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog  modal-dialog-centered modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <div class="contact-form" style="padding: 20px !important;">
                              <form class="user_address" method="POST">
                                 <div class="row">
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
                                          <input type="text" class="form-control" placeholder="Street*" name="street">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="Apartment*" name="apartment">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="Cross Street*" name="cross_street">
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

               <!--Edit User Address-->
               <div class="modal fade" id="editAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog  modal-dialog-centered modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Update Address</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <div class="contact-form" style="padding: 20px !important;">
                              <form class="update_user_address" method="POST">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="City*" id="edit_city" name="city">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="State*" id="edit_state" name="state">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="House*" id="edit_house" name="house">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="Street*" id="edit_street" name="street">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="Apartment*" id="edit_apartment" name="apartment">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="mb-3">
                                          <input type="text" class="form-control" placeholder="Cross Street*" id="edit_cross_street" name="cross_street">
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="mb-3 ">
                                          <textarea class="form-control" placeholder="special Instruction" name="instruction" id="edit_instruction"></textarea>
                                       </div>
                                    </div>
                                    <input type="hidden" name="address_id" id="edit_address_id">
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
               <!--order details -->

               <!--Order history detail-->
               <div class="modal fade" id="order_history_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog  modal-dialog-centered modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Order History Details</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <div class="col-12">
                              <table class="table table-striped w-100 text-center" id="order_detail">
                                 <thead>
                                    <tr>
                                       <th>Product Name</th>
                                       <th>Base Price</th>
                                       <th>Size</th>
                                       <th>Quantity</th>
                                       <th>Type</th>
                                       <th>Extra</th>
                                       <th>Total Price</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!--Order History detail-->

            </div>
         </div>

         <!-- Third  Column -->

         <div class="col-md-3 mt-2">
            <div class=" mt-3 border-bottom">

               <!-- Clearfix 1-->

               <div class="clearfix">
                  <div class="float-start">
                     <h6>New Order Fill</h6>
                  </div>
                  <div class="float-end">
                     <p class="small"> {{date('D m, Y')}}</p>
                  </div>
               </div>
            </div>

            <!-- End Clearfix 1 -->

            <div class="cart-scrollbar">

               <div class="mx-2" id="side_card">
                  <!-- Cart 1 -->
                  <!-- End Cart 1 -->
               </div>
            </div>

            <!--Scroll End -->



            <!-- Clearfix 2-->
            <div class="mt-3">
               <input type="text" class="form-control-sm w-100" placeholder="Apply Coupon" id="apply_coupon">
            </div>
            <div class=" mt-3">
               <div class="clearfix">
                  <div class="float-start">
                     <p class="mb-0 small">Sub Total</p>
                  </div>
                  <div class="float-end">
                     <p class="fw-bold" id="sub_total"></p>
                  </div>
               </div>
               <div class="clearfix">
                  <div class="float-start">
                     <p class="mb-0 small">Discount</p>
                  </div>
                  <div class="float-end">
                     <p class="fw-bold" id="total_discount"> - 0.00</p>
                  </div>
               </div>
            </div>

            

            <!-- End Clearfix 2-->


            <!-- Clearfix 3-->

            <div class="" style="border-bottom: 1px dashed #000;">
               <div class="clearfix">
                  <div class="float-start">
                     <p class="mb-0 small">Tax (Included)</p>
                  </div>
                  <div class="float-end">
                     <p class="fw-bold" id="tax_inc"></p>
                  </div>
               </div>
            </div>

            

            <!-- End Clearfix 3-->

            <!-- Clearfix 3-->

            <div class="mt-3" style="border-bottom: 1px dashed #000;">
               <div class="clearfix">
                  <div class="float-start">
                     <p class="mb-0 fw-bold text-warning">Total</p>
                  </div>
                  <div class="float-end">
                     <p class="fw-bold text-success" id="total"></p>
                  </div>
                  <input type="hidden" name="sub_total" class="sub_total">
                  <input type="hidden" name="tax" class="tax_inc">
                  <input type="hidden" name="net_amnt" class="total" id="net_amnt">
               </div>
            </div>

            <!-- End Clearfix 3-->

            <h5 class="my-3">Shipping Address</h5>
            <div class="row">

               @if($ship)
               @foreach ($ship as $item)
               <div class="col-md-12">
                  <div class="form-check">
                     <input type="radio" class="form-check-input check1" name="address" value="{{ $item->id }}">
                     <label class="form-check-label" for="check1"> {{ $item->state  }},{{ $item->house}},{{ $item->street }} {{ $item->apartment }},{{ $item->cross_street }}</label>
                  </div>

                  @endforeach

                  @endif


               </div>
               <h5 class="my-3">Payment Method</h5>

               <div class="row payment">
                  <div class="col-xl-4 col-lg-6 col-md-6">
                     <div class="card text-center mb-4 payment-item">
                        <div class="card-body">
                           <label>
                              <div class="h3 mb-0">
                                 <i class="fa fa-money"></i>
                              </div>
                              <p class="mb-0 small fw-bold">Cash</p>
                              <input type="radio" name="payment" value="Cash">
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-6 col-md-6">
                     <div class="card text-center mb-4 payment-item">
                        <div class="card-body">
                           <label>
                              <div class="h3 mb-0">
                                 <i class="fa fa-credit-card"></i>
                              </div>
                              <p class="mb-0 small fw-bold">Card/Debit</p>
                              <input type="radio" name="payment" value="Card">
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-6 col-md-6">
                     <div class="card text-center mb-4 payment-item">
                        <div class="card-body">
                           <label>
                              <div class="h3 mb-0">
                                 <i class="fa-solid fa-wallet"></i>
                              </div>
                              <p class="mb-0 small fw-bold">E-Wallet</p>
                              <input type="radio" name="payment" value="Wallet">
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- Payment Method -->

            <button class="btn btn-primary w-100" id="place_order">Place Order</button>
         </div>
      </div>
   </div>
</section>

<div class="modal fade" id="customisable" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Choose Your Topping</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <!-- Modal Body -->
         <div class="modal-body">
            <h6 style="color: #fe4e2b;">Toppings</h6>
            <div class="container px-0 mt-3">
               <div class="row" class="accordion" id="new_point">
               </div>
            </div>
         </div>
         <!-- End Modal Body -->
      </div>
   </div>
</div>


{{-- Combo Pack detail --}}
<div class="modal fade" id="combo_detail" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Combo Pack Detail</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <!-- Modal Body -->
         <div class="modal-body">
            <div class="container px-0 mt-3">
               <div class="row" class="accordion" id="combo_pack_detail">
               </div>
            </div>
         </div>
         <!-- End Modal Body -->
      </div>
   </div>
</div>
@section('extra_js')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
   $(document).ready(function() {
      sessionStorage.clear();
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
         // history.pushState({}, "POS", "pos.html?=" + name)
      });
      $('.sel-portion').click(function() {
         let portionId = $(this).val()
         let itemNumber = $(this).parent().parent().siblings('.itemNumber').val()
         let itemId = $(this).parent().parent().siblings('.itemNumber').val()

         sessionStorage.setItem(`ITEM_NUMBER${itemNumber}`, `${itemId},${portionId}`);

      })
      $('.accordion-button ').click(function() {
         let button = $(this).siblings().children().children().children('.itemNumber').val()
         $("input[type=radio][name=portion" + button + "]").prop('checked', false);

         sessionStorage.removeItem(`ITEM_NUMBER${button}`);
      })

      $('.add_topping').click(function() {
         // alert('hello');
         // exit;
         let totalItems = '<?php echo count($extra) ?>';
         let fd = new FormData();
         fd.append('_token', "{{ csrf_token() }}");
         let obj = {};

         for (let i = 1; i <= totalItems; i++) {
            // obj[i] = sessionStorage.getItem(`ITEM_NUMBER${i}`)
            fd.append(i, sessionStorage.getItem(`ITEM_NUMBER${i}`))
         }
         //  echo($i);
         // console.log(fd);

         $.ajax({
            url: "{{ route('website.extra_topping') }}",
            type: "POST",
            data: fd,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
               $('.loader').show();
            },
            success: function(result) {
               console.log(result)
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


<script>
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
</script>

<script>
   // Topping Added
   $("body").on("click", ".topping_added", function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      console.log(id);
      let fd = new FormData()
      fd.append('_token', "{{ csrf_token() }}");
      fd.append('id', id);
      $.ajax({
         url: "{{ route('website.extra_topping') }}",
         type: "POST",
         data: fd,
         dataType: 'json',
         processData: false,
         contentType: false,
         beforeSend: function() {
            $('.loader').show();
         },
         success: function(result) {
            let datas = "";
            if (result.data.length > 0) {
               $.each(result.data, function(i, val) {
                  datas += '<form class="new_add_to_cart" method="POST">';
                  datas += '<div class="col-sm-12 col-md-12">';
                  datas += '<h2 class="accordion-button collapsed px-1 text-dark pt-0  border-bottom" data-bs-toggle="collapse" data-bs-target="#collapseOne' + val.id + '">' + val.name + '';
                  datas += ' </h2>';
                  datas += '<div id="collapseOne' + val.id + '" class="accordion-collapse collapse">';
                  datas += '<div class="accordion-body ps-0 pt-1">';
                  datas += '<div class="row">';
                  datas += '<input class="itemId" name="product_id" type="hidden" value= "' + val.product_id + '"/>';
                  datas += '<div class="col-3 text-center" >';
                  datas += '<div class="click-menu extra">';
                  datas += '<input class="portionValue" type="hidden" value="left">';
                  datas += '<input style="cursor:pointer" class="select sel-portion" name="' + val.name + '" type="radio" value="Half" data-id=>';
                  datas += '<p class="mb-0">Half</p>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '<div class="col-3 text-center">';
                  datas += '<div class="click-menu extra">';
                  datas += '<input class="portionValue" type="hidden" value="center">';
                  datas += '<input style="cursor:pointer" class="select sel-portion" name="' + val.name + '" type="radio" value="Medium">';
                  datas += '<p class="mb-0">Medium</p>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '<div class="col-3 text-center">';
                  datas += '<div class="click-menu extra">';
                  datas += '<input class="portionValue" type="hidden" value="right"> ';
                  datas += '<input style="cursor:pointer" class="select sel-portion" name="' + val.name + '" type="radio" value="Full">';
                  datas += '<p class="mb-0">Full</p>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '<div class="col-3 text-center">';
                  datas += '<div class="click-menu extra">';
                  datas += '<input class="portionValue" type="hidden" value="extra">';
                  datas += '<input style="cursor:pointer" class="select sel-portion" name="' + val.name + '" type="radio" value="Extra">';
                  datas += '<p class="mb-0">Extra</p>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '</div>';


               });
            } else {
               datas += '';
            }
            datas += '<div class="modal-footer border-top-0">';
            datas += '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
            datas += '<button type="submit" class="btn btn-primary add_topping" data-bs-target="modal">';
            datas += '<i class="fa fa-cart-shopping"></i> Add to Cart</button>';
            datas += '</div>';
            datas += '</form>';
            $("#new_point").html(datas);
         },
         complete: function() {
            $('.loader').hide();
         },
         error: function(jqXHR, exception) {
            $('.loader').hide();
         }
      });
      $("#customisable").modal("toggle");
   })

   $(function() {
      var limit = 15;
      var newest = "";
      var asc = "";
      var cate_id = "";
      var sub_cate_id = "";

      //load products
      $.fn.product = function(limit, newest, asc, cate_id, sub_cate_id) {

         $.ajax({
            type: "GET",
            data: {
               "limit": limit,
               "newest": newest,
               "asc": asc,
               "cate_id": cate_id,
               "sub_cate_id": sub_cate_id
            },
            url: "{{ route('website.get_menu')}}",
            beforeSend: function() {
               $('.loaded').show();
            },
            success: function(data) {
               let datas = '';
               let load = '';
               if (data.products.length > 0) {
                  $.each(data.products, function(i, val) {
                     if (val.discount) {
                        var dis = val.discount;
                        var price = (val.price - (val.price * dis / 100));
                     } else {
                        var dis = 0;
                        var price = (val.price)
                     }
                     var url = "{{ url('')}}" + val.product_img;
                     datas += '<div class="col-xl-4 col-lg-6 col-md-12">' +
                        '<div class="card card-menu mb-3">' +
                        '<div class="card-body">' +
                        '<img src="' + url + '" alt="" class="img-menu mx-auto d-block">' +
                        '<p class="text-center fw-bold mt-3 mb-0">' + val.product_name + '</p>' +
                        '<p class="text-center"><b><span><span class="text-success">$' + parseFloat(price).toFixed(2) + '</b></span>&nbsp;&nbsp; <strike><span class="text-danger">$' + parseFloat(val.price).toFixed(2) + '</span></strike> <span><br><span><b>Discount&nbsp</b>' + dis + '%</span><br><span>Type - ' + val.type + '</span></p>' +
                        '<div class="clearfix">' +
                        '<div class="float-start c-text">' +
                        '<a href="" data-id="' + val.id + '" class="topping_added"><i class="fa fa-cutlery"></i> Custom</a>' +
                        '</div>' +
                        '<div class="float-end">' +
                        '<a class="p-2 btn-primary add_to_cart" data-id="' + val.id + '"><i class="fa fa-cart-shopping"></i> Add</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                  })



                  if (data.limit <= data.total) {
                     load += '<div class="page-pagination">' +
                        '<ul class="pagination justify-content-center">' +
                        '<button class="btn btn-primary load_more" data-load_more="' + data.limit + '"><i class="fas fa-spinner fa-spin load_more_spin p-2"></i>Load More</button>' +
                        '</ul>' +
                        '</div>'
                  }
               } else {

               }
               $('#menu_list').html(datas);
               $(".more").html(load);
            },
            complete: function() {
               $('.loaded').hide();

            },
         })
      }
      $.fn.product();

      $('body').on('click', '.load_more', function(e) {
         var load_more = $(this).data('load_more');
         limit = 10 + load_more;
         $.fn.product(limit, newest, asc, cate_id, sub_cate_id);
      });

      $('body').on('click', '.get_menu1', function(e) {
         var sub_cate_id = $(this).data('id');
         $.fn.product(limit, newest, asc, cate_id, sub_cate_id);

      });


      //   // filter
      $('body').on('click', '.get_menu', function(e) {
         var cate_id = $(this).data('id');
         $.fn.subCateory(cate_id);

      });

      // Get Sub Category
      $.fn.subCateory = function(cate_id) {
         $.ajax({
            type: "GET",
            data: {
               "limit": limit,
               "newest": newest,
               "asc": asc,
               "cate_id": cate_id
            },
            url: "{{ route('website.get_sub_category')}}",
            beforeSend: function() {
               $('.loaded').show();
            },
            success: function(data) {
               let datas = '';

               if (data.data.length > 0) {

                  $.each(data.data, function(i, val) {
                     var url = "{{ url('')}}" + val.image;
                     datas += '<li class="nav-item">' +
                        '<button class="nav-link catg-link d-flex align-items-center rounded-pill px-4 get_menu1" data-id="' + val.id + '" id="pills-all" data-bs-toggle="pill" data-bs-target="#all">' +
                        '<img src="' + url + '" alt="" style="width:40px;height: 40px;border-radius: 50%;" class="me-4">' + val.name + '</button>' +
                        '</li>';
                  })
               } else {
                  datas = '';
               }
               $('.sub_category_list').html(datas);
            },
            complete: function() {
               $('.loaded').hide();

            },
         })
      }



      // Add to cart
      $("body").on("click", ".add_to_cart", function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         let fd = new FormData()
         fd.append('_token', "{{ csrf_token() }}");
         fd.append('id', id);
         $.ajax({
            url: "{{ route('website.add_to_cart') }}",
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
                  $.fn.cart();
                  $.fn.sideCart();
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


      // Cart List
      $.fn.cart = function() {
         $.ajax({
            type: "GET",
            url: "{{ route('website.get_cart_list_ajax')}}",
            beforeSend: function() {
               $('.loaded').show();
            },
            success: function(data) {
               let datas = '';
               if (data.products.length > 0) {
                  $.each(data.products, function(i, val) {
                     console.log(val.image);

                     if(val.type == "combo") {
                        console.log(val.package_name);
                        var url = "{{ url('')}}" + val.image;
                        var name = val.package_name;
                     }else{
                        var url = "{{ url('')}}" + val.product_img;
                        var name = val.product_name;
                     }

                     datas += ' <div class="card mb-3 main-cart pb-3 mt-0">' +
                        '<div class="row align-items-center">' +
                        '<div class="col-md-3">' +
                        '<div class="ps-2 pt-3">' +
                        '<img src="' + url + '" class="img-fluid rounded-start w-100 h-100" alt="...">' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-5">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title  fw-bold">' + name + '</h5>' +
                        '<p class="mb-0">$10.00</p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-2">' +
                        '<div class="qty-block">' +
                        '<div class="qty">' +
                        '<input type="text" name="qty" maxlength="12" value="' + val.qty + '" title="" class="input-text" />' +
                        '<div class="qty_inc_dec">' +
                        '<i class="increment" data-id="' + val.id + '" data-qty="' + val.qty + '">+</i>' +
                        '<i class="decrement" data-id="' + val.id + '" data-qty="' + val.qty + '">-</i>' +

                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-2">' +
                        '<a class="small mb-0 text-end text-danger remove_to_cart" data-id="' + val.id + '" >Remove <i class="fa fa-close  me-2"></i>' +
                        '</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                  })
               } else {

               }
               $('#cart_list').html(datas);
            },
            complete: function() {
               $('.loaded').hide();

            },
         })
      }
      $.fn.cart();


      // Remove for cart
      $("body").on("click", ".remove_to_cart", function(e) {
         e.preventDefault();
         var cart_id = $(this).data('id');
         let fd = new FormData()
         fd.append('_token', "{{ csrf_token() }}");
         fd.append('cart_id', cart_id);
         $.ajax({
            url: "{{ route('website.remove_from_cart') }}",
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
                  $.fn.cart();
                  $.fn.sideCart();
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

      // Increament Qty
      $("body").on("click", ".increment", function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         var qty = $(this).data('qty');
         let fd = new FormData()

         fd.append('_token', "{{ csrf_token() }}");
         fd.append('qty', qty);
         fd.append('id', id);
         $.ajax({
            url: "{{ route('website.qty_increase') }}",
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
                  $.fn.cart();
                  $.fn.sideCart();
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

      // Qty decrese
      $("body").on("click", ".decrement", function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         var qty = $(this).data('qty');
         let fd = new FormData()

         fd.append('_token', "{{ csrf_token() }}");
         fd.append('qty', qty);
         fd.append('id', id);
         $.ajax({
            url: "{{ route('website.qty_decrease') }}",
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
                  $.fn.cart();
                  $.fn.sideCart();
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

      // Side cart show
      $.fn.sideCart = function() {
         $.ajax({
            type: "GET",
            url: "{{ route('website.get_cart_list_ajax')}}",
            beforeSend: function() {
               $('.loaded').show();
            },
            success: function(data) {
               let datas = '';
               var sub_total = 0;
               var net_amnt = 0;
               var tax = 0;
               if (data.products.length > 0) {
                  $.each(data.products, function(i, val) {
                     if (val.discount) {
                        var dis = val.discount;
                        var price = (val.price - (val.price * val.discount / 100));
                     } else {
                        var dis = 0;
                        var price = val.price;
                     }
                     sub_total += (val.qty * price);
                     net_amnt += (val.qty * price + (val.qty * price * val.tax) / 100)
                     tax += ((val.qty * price * val.tax) / 100)
                     if(val.type == "combo") {
                        var url = "{{ url('')}}" + val.image;
                        var name = val.package_name;
                     }else{
                        var url = "{{ url('')}}" + val.product_img;
                        var name = val.product_name;
                     }

                     datas += '<div class="card mb-3 bg-cart pb-3">' +
                        '<div class="row align-items-center">' +
                        '<div class="col-md-12">' +
                        '<p class="small mb-0 text-end">' +
                        '<a href="javascript:void(0)" class="remove_to_cart" data-id="' + val.id + '"><i class="fa fa-close  me-2"></i></a>' +
                        '</p>' +
                        '</div>' +
                        '<div class="col-xl-3 col-md-12">' +
                        '<div class="ps-xl-2">' +
                        '<img src="' + url + '" class="img-fluid rounded-start w-100" alt="...">' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-xl-5 col-md-6">' +
                        '<div class="card-body p-xl-0">' +
                        '<p class="card-title mb-0 fw-bold n-size">' + name + '</p>' +
                        '<p class="card-text mb-0"><span class="text-success"><b>$' + price + '</b>&nbsp;&nbsp;&nbsp;</span><span class="text-danger">$<strike>' + val.price + '</strike></span><br><span><b>Discount : </b>' + dis + '%</span></p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-xl-4 col-md-6">' +
                        '<div class="qty-block">' +
                        '<div class="qty">' +
                        '<input type="text" name="qty" maxlength="12" value="' + val.qty + '" title="" class="input-text" />' +
                        '<div class="qty_inc_dec">' +
                        '<i class="increment" data-id="' + val.id + '" data-qty="' + val.qty + '">+</i>' +
                        '<i class="decrement" data-id="' + val.id + '" data-qty="' + val.qty + '">-</i>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                  })
               } else {

               }
               $('#side_card').html(datas);
               $("#sub_total").text(parseFloat(sub_total).toFixed(2))
               $("#tax_inc").text(parseFloat(tax).toFixed(2))
               $("#total").text(parseFloat(net_amnt).toFixed(2))

               $(".sub_total").val(parseFloat(sub_total).toFixed(2))
               $(".tax_inc").val(parseFloat(tax).toFixed(2))
               $(".total").val(parseFloat(net_amnt).toFixed(2))


            },
            complete: function() {
               $('.loaded').hide();

            },
         })
      }
      $.fn.sideCart();

      //Place Order Confirm
      $("body").on("click", "#place_order", function(e) {
         e.preventDefault();
         var sub_total = $(".sub_total").val();
         var tax = $(".tax_inc").val();
         var total = $(".total").val();
         var type = $('input[name="payment"]:checked').val();
         var address = $("input[name='address']:checked").val();
         let fd = new FormData()
         fd.append('_token', "{{ csrf_token() }}");
         fd.append('sub_total', sub_total);
         fd.append('tax', tax);
         fd.append('total', total);
         fd.append('type', type);
         fd.append('address', address);

         if (type != "") {
            $.ajax({
               url: "{{ route('website.place_order') }}",
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
                     $.fn.cart();
                     $.fn.sideCart();
                     setTimeout(() => {
                        window.location.reload();
                     }, 1000);
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
         } else {
            iziToast.error({
               title: '',
               message: "select payment method",
               position: 'topRight'
            });
         }
      })

      // Order List Show
      var tables = $('#example').DataTable({
         destroy: true,
         "processing": true,
         pageLength: 10,
         "serverSide": true,
         "ajax": {
            url: "{{route('website.order_history')}}",
            dataFilter: function(data) {
               var json = jQuery.parseJSON(data);
               json.recordsTotal = json.recordsTotal;
               json.recordsFiltered = json.recordsFiltered;
               json.data = json.data;
               return JSON.stringify(json); // return JSON string
            }
         },

         'order': [
            [1, 'desc']
         ],
         'columnDefs': [{
               "targets": 0,
               "name": "created_at",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 1,
               "name": "name",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 2,
               "name": "phone",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 3,
               "name": "state",
               'searchable': true,
               'orderable': true
            },

            {
               "targets": 4,
               "name": "txn_id",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 5,
               "name": "invoice_id",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 6,
               "name": "type",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 7,
               "name": "pay_amount",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 8,
               "name": "status",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 9,
               "name": "action",
               'searchable': true,
               'orderable': true
            },
         ],
      });
   })




   //    Profile
   // Update profile
   $('.update_profile').on('submit', function(e) {
      e.preventDefault()
      let fd = new FormData(this)
      fd.append('_token', "{{ csrf_token() }}");
      $.ajax({
         url: "{{ route('website.user_profile_submit_new') }}",
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

   // Extra add to cart
   $("body").on("submit", ".new_add_to_cart", function(e) {
      e.preventDefault();
      let fd = new FormData(this)
      fd.append('_token', "{{ csrf_token() }}");
      $.ajax({
         url: "{{ route('website.extra_add_to_cart') }}",
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
               $.fn.cart();
               $.fn.sideCart();
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

   // User Address  add
   $("body").on("submit", ".user_address", function(e) {
      e.preventDefault();
      let fd = new FormData(this)
      fd.append('_token', "{{ csrf_token() }}");
      $.ajax({
         url: "{{ route('website.user_address_add') }}",
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
               $(".user_address")[0].reset();
               $.fn.user_address();
               $("#addressModal").modal("toggle");
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

   // function for get user address
   $.fn.user_address = function() {
      $.ajax({
         type: "GET",
         url: "{{ route('website.get_user_address')}}",
         beforeSend: function() {
            $('.loaded').show();
         },
         success: function(data) {
            let datas = '';
            if (data.data.length > 0) {
               $.each(data.data, function(i, val) {
                  datas += '<div class="col-4">';
                  datas += '<div class="card" style="width: 18rem;">';
                  datas += '<div class="card-body">';
                  datas += '<h5 class="card-title">Address</h5>';
                  datas += '<h6 class="card-subtitle mb-2 text-muted"></h6>';
                  datas += '<p class="card-text">' + val.city + ' ' + val.state + ' ' + val.house + ' ' + val.apartment + ' ' + val.cross_street + '</p>';
                  datas += '<a href="javascript:void(0);"  class="card-link text-primary edit_address" data-id="' + val.id + '" data-city="' + val.city + '" data-state="' + val.state + '" data-house="' + val.house + '" data-apartment="' + val.apartment + '" data-cross_street="' + val.cross_street + '" data-instruction="' + val.instruction + '" data-street="' + val.street + '">Edit</a>&nbsp;&nbsp;&nbsp;';
                  datas += '<a href="javascript:void(0);"  class="card-link text-danger delete_address" data-id="' + val.id + '">Delete</a>';
                  datas += '</div>';
                  datas += '</div>';
                  datas += '</div>';
               })
            } else {
            }
            $('.user_address_show').html(datas);
         },
         complete: function() {
            $('.loaded').hide();

         },
      })
   }
   $.fn.user_address();

   $("body").on("click", ".delete_address", function(e) {
      e.preventDefault();
      var address_id = $(this).data('id');
      let fd = new FormData()
      fd.append('_token', "{{ csrf_token() }}");
      fd.append('address_id', address_id);
      $.ajax({
         url: "{{ route('website.remove_address') }}",
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
               $.fn.user_address();
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

   // user address edit
   $("body").on("click", ".edit_address", function(e) {
      e.preventDefault();
      var address_id = $(this).data('id');
      var city = $(this).data('city');
      var state = $(this).data('state');
      var house = $(this).data('house');
      var street = $(this).data('street');
      var apartment = $(this).data('apartment');
      var cross_street = $(this).data('city');
      var instruction = $(this).data('instruction');

      $("#edit_city").val(city);
      $("#edit_state").val(state);
      $("#edit_house").val(house);
      $("#edit_apartment").val(apartment);
      $("#edit_cross_street").val(cross_street);
      $("#edit_instruction").text(instruction);
      $("#edit_address_id").val(address_id);
      $("#edit_street").val(street);
      $("#editAddModal").modal("toggle");
   })

   $("body").on("submit", ".update_user_address", function(e) {
      e.preventDefault();
      let fd = new FormData(this)
      fd.append('_token', "{{ csrf_token() }}");
      $.ajax({
         url: "{{ route('website.update_address') }}",
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
               $(".update_user_address")[0].reset();
               $("#editAddModal").modal("toggle");
               $.fn.user_address();
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

   // Order history detail
   $("body").on("click", ".order_detail", function(e) {
      e.preventDefault();
      let order_id = $(this).attr('data-id');
      var tables = $('#order_detail').DataTable({
         destroy: true,
         "processing": true,
         pageLength: 10,
         "serverSide": true,
         "ajax": {
            url: "{{url('order_history_details')}}/" + order_id,
            dataFilter: function(data) {
               var json = jQuery.parseJSON(data);
               json.recordsTotal = json.recordsTotal;
               json.recordsFiltered = json.recordsFiltered;
               json.data = json.data;
               return JSON.stringify(json); // return JSON string
            }
         },

         'order': [
            [1, 'desc']
         ],
         'columnDefs': [{
               "targets": 0,
               "name": "product_name",
               'searchable': false,
               'orderable': false
            },
            {
               "targets": 1,
               "name": "base_price",
               'searchable': false,
               'orderable': false
            },
            {
               "targets": 2,
               "name": "size",
               'searchable': false,
               'orderable': false
            },
            {
               "targets": 3,
               "name": "qty",
               'searchable': false,
               'orderable': false
            },
            {
               "targets": 4,
               "name": "type",
               'searchable': false,
               'orderable': false
            },
            {
               "targets": 5,
               "name": "type",
               'searchable': false,
               'orderable': false
            },
            {
               "targets": 6,
               "name": "base_price",
               'searchable': false,
               'orderable': false
            },
         ],
      });

      $("#order_history_detail").modal("toggle");
   })

   // Apply coupon
   $("body").on("blur", "#apply_coupon", function(e) {
      e.preventDefault();
      let value = $("#apply_coupon").val();
      let fd = new FormData();
      var total = $("#net_amnt").val();
      fd.append('_token', "{{ csrf_token() }}");
      fd.append('value', value);
      $.ajax({
         url: "{{ route('website.check_coupon') }}",
         type: "POST",
         data: fd,
         dataType: 'json',
         processData: false,
         contentType: false,
         beforeSend: function() {
            $('.loader').show();
         },
         success: function(result) {
            if (result.data) {
               var dis = result.data.discount
               var total_dis = (total * dis / 100);
               var cal = (total - (total * dis / 100));
               $("#net_amnt").val(cal);

               $("#total").text(parseFloat(cal).toFixed(2));
               $("#total_discount").text(parseFloat(total_dis).toFixed(2))
            } else {}
         },
         complete: function() {
            $('.loader').hide();
         },
         error: function(jqXHR, exception) {
            $('.loader').hide();
         }
      });
   })

   // Combo Pack
   let newlimit = 10;

   $.fn.combo = function(newlimit) {
      $.ajax({
         type: "GET",
         data: {
            "limit": newlimit,
         },
         url: "{{ route('website.get_combo_pack')}}",
         beforeSend: function() {
            $('.loaded').show();
         },
         success: function(data) {
            let datas = '';
            let load = '';
            if (data.products.length > 0) {
               $.each(data.products, function(i, val) {

                  var url = "{{ url('')}}" + val.image;
                  datas += '<div class="col-xl-4 col-lg-6 col-md-12">' +
                     '<div class="card card-menu mb-3">' +
                     '<div class="card-body">' +
                     '<img src="' + url + '" alt="" class="img-menu mx-auto d-block">' +
                     '<p class="text-center fw-bold mt-3 mb-0">' + val.package_name + '</p>' +
                     '<p class="text-center"><b><span><span class="text-success">$' + parseFloat(val.price).toFixed(2) + '</b></span>&nbsp;&nbsp; <strike><span class="text-danger">$' + parseFloat(val.price).toFixed(2) + '</span></strike> <span></p>' +
                     '<div class="clearfix">' +
                     '<div class="float-start c-text">' +
                     '<a href="javascript:void(0);" data-id="' + val.id + '" class="show_combo_detail">Detail</a>' +
                     '</div>' +
                     '<div class="float-end">' +
                     '<a class="p-2 btn-primary combo_add_to_cart" data-id="' + val.id + '"><i class="fa fa-cart-shopping"></i> Add</a>' +
                     '</div>' +
                     '</div>' +
                     '</div>' +
                     '</div>' +
                     '</div>';
               })
               if (data.limit <= data.total) {
                  load += '<div class="page-pagination">' +
                  '<ul class="pagination justify-content-center">' +
                  '<button class="btn btn-primary load_more" data-load_more="' + data.limit + '"><i class="fas fa-spinner fa-spin load_more_spin p-2"></i>Load More</button>' +
                  '</ul>' +
                  '</div>';
               }
            } else {

            }
            $('#combo_pack_list').html(datas);
            $(".load_more").html(load);
         },
         complete: function() {
            $('.loaded').hide();

         },
      })
   }
   $.fn.combo();

   // Show combo Pack detail
   $("body").on("click" , ".show_combo_detail" , function(e) {
      e.preventDefault()
      let combo_id   = $(this).attr('data-id');
      let fd         = new FormData();
      fd.append("_token" , "{{csrf_token()}}"),
      fd.append("combo_id" , combo_id);
      $.ajax({
         url: "{{ route('website.get_combo_pack_detail') }}",
         type: "POST",
         data: fd,
         dataType: 'json',
         processData: false,
         contentType: false,
         beforeSend: function() {
            $('.loader').show();
         },
         success: function(result) {
            let combo_data = '';
            if (result.data.length > 0) {
               $.each(result.data , function(i , val) {
                  var url = "{{ url('')}}" + val.product_img;
                  combo_data += '<div class="card" style="width: 10rem; ">';
                  combo_data += '<img src="'+url+'" class="card-img-top" alt="...">';
                  combo_data += '<div class="card-body">';
                  combo_data += '<h5 class="card-title">'+val.product_name+'</h5>';
                  combo_data += '</div>';
                  combo_data += '</div>';
               })

               $("#combo_pack_detail").html(combo_data)
               $("#combo_detail").modal("toggle")
            } else {

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


   //Combo pack add to cart
   $("body").on("click" , ".combo_add_to_cart" , function(e) {
      e.preventDefault();
      let combo_id   = $(this).attr('data-id');
      let fd         = new FormData();
      fd.append('_token' , "{{ csrf_token()}}");
      fd.append('combo_id' , combo_id);

      $.ajax({
         url: "{{ route('website.combo_pack_add_to_cart') }}",
         type: "POST",
         data: fd,
         dataType: 'json',
         processData: false,
         contentType: false,
         beforeSend: function() {
            $('.loader').show();
         },
         success: function(result) {
            if(result.status) {
               iziToast.success({
               title: '',
               message: result.msg,
               position: 'topRight'
            });
            $.fn.cart();
            $.fn.sideCart();
            }else{
               iziToast.error({
               title: '',
               message: result.msg,
               position: 'topRight'
            });
            $.fn.cart();
            $.fn.sideCart();
            }

         },
         complete: function() {
            $('.loader').hide();
         },
         error: function(jqXHR, exception) {
            $('.loader').hide();
         }
      })
   })

   // Show Detail
   $("body").on("click" , ".show_detail" , function(e) {
      e.preventDefault();
      let combo_id   = $(this).attr('data-id');
      let fd         = new FormData();
      fd.append("_token" , "{{csrf_token()}}"),
      fd.append("combo_id" , combo_id);
      $.ajax({
         url: "{{ route('website.get_combo_pack_detail') }}",
         type: "POST",
         data: fd,
         dataType: 'json',
         processData: false,
         contentType: false,
         beforeSend: function() {
            $('.loader').show();
         },
         success: function(result) {
            let combo_data = '';
            if (result.data.length > 0) {
               $.each(result.data , function(i , val) {
                  var url = "{{ url('')}}" + val.product_img;
                  combo_data += '<div class="card" style="width: 10rem; ">';
                  combo_data += '<img src="'+url+'" class="card-img-top" alt="...">';
                  combo_data += '<div class="card-body">';
                  combo_data += '<h5 class="card-title">'+val.product_name+'</h5>';
                  combo_data += '</div>';
                  combo_data += '</div>';
               })

               $("#combo_pack_detail").html(combo_data)
               $("#combo_detail").modal("toggle")
            } else {

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
   //    Cancel Order
$("body").on("click", ".statuscancel", function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            // alert(status);
            let fd = new FormData()
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('status', status);
            fd.append('id', id);
            // alert(status);
            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to cancel the order?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('website.cancel_order') }}",
                                type: 'POST',
                                data: fd,
                                dataType: "JSON",
                                contentType: false,
                                processData: false,
                            })
                            .done(function(result) {
                                if (result.status) {
                                    iziToast.success({
                                        title: '',
                                        message: result.msg,
                                        position: 'topRight'
                                    });
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);

                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: result.msg,
                                        position: 'topRight'
                                    });
                                }
                            })
                            .fail(function(jqXHR, exception) {
                                console.log(jqXHR.responseText);
                            })


                    },
                    no: function() {},
                }
            })
        })
</script>
@endsection
@endsection
