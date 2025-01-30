<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="#"> <img alt="image" src="{{ url('public/assets/website/images/logo.webp')}}"
            class="header-logo" style="background-color: red"/> <span
class="logo-name font-14">Restaurant POS</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown active">
          <a href="{{route('deliveryboy.dashboard')}}" class="nav-link"><i data-feather=  "monitor"></i><span>Dashboard</span></a>
        </li>
         <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i
              data-feather="briefcase"></i><span>Deliveries</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('deliveryboy.order_list')}}">Delivery History</a></li>
            <li><a class="nav-link" href="{{route('deliveryboy.order_list.pending')}}">New Deliveries</a></li>
            <li><a class="nav-link" href="{{route('deliveryboy.order_list.delivered')}}">Today's Delivered List</a></li>

          </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                data-feather="settings"></i><span>My Account</span></a>
            <ul class="dropdown-menu">
              <li><h6 class="nav-link" style="font-size: 12px; padding-left:29px; text-transform: uppercase;"><i class="fa fa-user"></i>&nbsp;&nbsp;<span style="color: red"> Hello!</span> {{ Auth::guard('deliveryboy')->user()->name }}</h6 class="nav-link"></li>
              <li><a class="nav-link" href="{{route('deliveryboy.profile')}}">Profile</a></li>
              <li><a class="nav-link" href="{{route('deliveryboy.logout')}}">Log Out</a></li>

            </ul>
          </li>


      </ul>
    </aside>
  </div>
