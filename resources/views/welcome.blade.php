@section('title', 'HERMES - Welcome!')

@extends('layouts.layout')

@section('navigation')
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
<button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  
  @if (Route::has('login'))
  <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
    @auth
    <li class="nav-item active">
      <a class="nav-link" href="{{ url('/home') }}">Home <span class="sr-only"></span></a>
    </li>
    @else
    <li class="nav-item active">
      <a class="nav-link" href="{{ route('login') }}">Login <span class="sr-only"></span></a>
    </li>
    @if (Route::has('register'))
    <li class="nav-item active">
      <a class="nav-link" href="{{ route('register') }}">Register <span class="sr-only"></span></a>
    </li>
    @endif
    @endauth
  </ul>
  @endif
</div>

</nav>
@endsection



@section('content')
  
<!-- <div class="jumbotron">

  
    <h1>Welcome to <img class="" src="{{url('images/hermes_logo_new.png')}}" alt="HERMES" style="height: 200px;"></h1> 
    
    <p>The Social-Commerce Platform!</p> 
    
  

  

</div> -->
<div id="welcome_image" style="height: 700px; max-width: 100%; background-image: url('{{url('images/welcome2.png')}}'); background-size: cover; background-position: center; " >
  
</div>
<!-- <img class="" src="{{url('images/welcome2.png')}}" alt="HERMES" style="max-width: 1000px; "> -->
@endsection