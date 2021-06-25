<!-- Header -->

<div class="header"> 
  
  <!-- Logo -->
  <div class="header-left"> <a href="javascript:void(0)" class="logo"> <img src='{{ sendPath(constants("dir_name.company")).@Session::get("companydata.invoice_logo") }}'  alt="Logo"> </a> <a href="javascript:void(0)" class="logo logo-small"> <img src='{{ sendPath(constants("dir_name.company")).@Session::get("companydata.invoice_logo") }}' alt="Logo" width="30" height="30"> </a> </div>
  <!-- /Logo --> 


  
  <!-- Mobile Menu Toggle --> 
  <a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a> 
  <!-- /Mobile Menu Toggle --> 
  
  <!-- Header Menu -->
  <ul class="nav user-menu">
    

    <!-- User Menu -->
    <li class="nav-item dropdown has-arrow main-drop"> <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"> 
    <!--img src="{{ asset('admin_assets/assets/img/logo.png') }}" alt=""--> <span class="status online"></span> </span> <span>{{ Session::get('adminfullname') }}</span> </a>
      <div class="dropdown-menu"> 
      <a class="dropdown-item" href="{{ route('my-profile') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-1"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>My Profile</a>
      <a class="dropdown-item" href="{{ route('log-out') }}"><i data-feather="log-out" class="mr-1"></i> Logout</a>
       </div>
    </li>
    
    
    <!-- /User Menu -->
    
  </ul>
  <!-- /Header Menu --> 
  
</div>
<!-- /Header --> 