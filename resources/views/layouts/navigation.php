
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
  <a class="btn btn-primary btn-space" id="back_btn" href="{{ URL::previous() }}"><i class="fas fa-caret-left"></i></a>
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

      <li class="nav-item dropdown">
        <a id="navbarDropdown1" class="nav-link dropdown-toggle text-black" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
         Language
       </a>

       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
        <a href="#" class="dropdown-item">English <i class="float-right fas fa-check"></i></a>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a id="navbarDropdown2" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }} <span class="caret"></span>
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">

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
        <img class="m-0 p-0 ml-1 mr-1 float-left border" src="{{url('uploads/'.auth()->user()->details->file_name)}}" alt="{{auth()->user()->details->file_name}}" style='height: 40px; width: 40px; border-radius: 50%; object-fit: cover;'>
      @else
        <div class="m-0 p-0 ml-1 mr-1 float-left" style="height: 40px; width: 40px;"><i class="fas fa-user-circle p-0 m-0" style="font-size: 40px;"></i></div>
      @endif
    </a>
  </li>
  @endguest
</ul>
</nav>
