<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="HERMES - Social-Commerce Platform">
  <meta name="author" content="Stefan Grulovic(stefan.grulovic@gmial.com)">
  <meta name="theme-color" content="#2ebbdc"/>

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="shortcut icon" href="{{url('images/hermes_icon_new.ico')}}"/>
  <title>@yield('title','HERMES')</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('css/bootstrap2.min.css') }}" rel="stylesheet">
  
  
  <!-- Custom styles for this template -->
  <link href="{{ asset('css/simple-sidebar.css') }}" rel="stylesheet">
  <link href="{{ asset('css/css.css') }}" rel="stylesheet">
  <link href="{{ asset('css/product.css') }}" rel="stylesheet">
  
  <!-- Icons -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<body>
  <div id="wrapper" class="d-flex h-100 w-100">
    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      
      <a href="/" style="text-decoration: none;" class="p-0 m-0">
        <img class="sidebar-heading p-0 mx-auto d-block" src="{{url('images/hermes_logo3.png')}}" style="height: 58px;" alt="HERMES">
        <!-- <span style="font-size: 30px; top: 30px;">HERMES</span> -->
      </a>
      
      <div class="navigation list-group list-group-flush">
        @guest
        @else
        <a href="/users" class="list-group-item list-group-item-action bg-light"><i class="fas fa-users"></i> Users</a>
        <a href="/friends" class="list-group-item list-group-item-action bg-light"><i class="fas fa-user-friends"></i> Friends</a>
        <a href="/offers" class="list-group-item list-group-item-action bg-light"><i class="fas fa-shopping-basket"></i> Offers</a>
          @if(auth()->user()->type == "c")
            <a href="/orders" class="list-group-item list-group-item-action bg-light"><i class="fas fa-box"></i> Orders</a>
            <a href="/lists" class="list-group-item list-group-item-action bg-light"><i class="fas fa-clipboard-list"></i> Lists</a>
            <a href="/favorites" class="list-group-item list-group-item-action bg-light"><i class="fas fa-star"></i> Favorites</a>
          @else
            <a href="/requests" class="list-group-item list-group-item-action bg-light"><i class="fas fa-shipping-fast"></i> Requests</a>
            <a href="/orders" class="list-group-item list-group-item-action bg-light"><i class="fas fa-box"></i> Orders</a>

          @endif
        <a href="/conversations" class="list-group-item list-group-item-action bg-light"><i class="fas fa-comments"></i> Conversations</a>
        <a href="/forum" class="list-group-item list-group-item-action bg-light"><i class="fas fa-server"></i> Forum</a>
        @endguest
        <a href="/faq" class="list-group-item list-group-item-action bg-light"><i class="fas fa-comment-alt"></i> F.A.Q's</a>
        <a href="/documentation" class="list-group-item list-group-item-action bg-light"><i class="fas fa-book"></i> Documentation</a>
        <a href="/about_contact" class="list-group-item list-group-item-action bg-light"><i class="fas fa-address-card"></i> About / Contact</a>

        <a id="hide_menu"></a>
      </div>

    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper" style='background-image: linear-gradient(to bottom right, #a5a5a5, #cccccc);'>
    <!-- <div id="page-content-wrapper" style='background-image: linear-gradient(to bottom right, #000f24, #004b47 , #01d09a);'> -->

<!--NAVIGATION-->      
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
  <a class="btn btn-primary btn-space" id="back_btn btn-space" href="{{ URL::previous() }}"><i class="fas fa-caret-left"></i></a>
  <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <!-- Authentication Links -->
      @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
      </li>
      @if (Route::has('register'))
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
      </li>
      @endif
      @else

      <li class="nav-item active">
        <a class="nav-link btn btn-light" href="{{ url('/home') }}"><i class="fas fa-home"></i> Home <span class="sr-only"></span></a>
      </li>
    
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle text-black" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
         Language
       </a>

       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a href="#" class="dropdown-item">English <i class="float-right pt-1 fas fa-check"></i></a>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }} <span class="caret"></span>
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

        <a class="dropdown-item" href="/users/{{auth()->user()->id}}/edit"><i class="fas fa-cog"></i> Edit Profile
        </a>
        
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
        </a>

      @auth
        <a class="dropdown-item" href="{{ url('/home') }}"><i class="fas fa-home"></i> Home <span class="sr-only"></span></a>
        <a class="dropdown-item" href="/users/{{auth()->user()->id}}/show"><i class="fas fa-user"></i> Profile <span class="sr-only"></span></a>
      @endauth
        

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </div>
  </li>

  <li class="nav-item p-0 m-0" >
    <a href="/users/{{auth()->user()->id}}/show">
      @if(auth()->user()->details->file_name != null)
        <img class="m-0 p-0 ml-1 mr-1 float-left border" src="{{url('uploads/'.auth()->user()->details->file_name)}}" style='height: 40px; width: 40px; border-radius: 50%; object-fit: cover;'>
      @else
        <div class="m-0 p-0 ml-1 mr-1 float-left" style="height: 40px; width: 40px;"><i class="fas fa-user-circle p-0 m-0" style="font-size: 40px;"></i></div>
      @endif
    </a>
  </li>
  @endguest
</ul>
</nav>
<!--NAVIGATION-->      

      

      
      @yield('second_navigation')

      <div id="content">
        @yield('content')  
      </div>
      
      
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  
  <script type="text/javascript" src="{{ asset('js/shared.js') }}"></script>
  @yield('scripts')
  
  <!-- User JavaScript/Jquery -->
  <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
