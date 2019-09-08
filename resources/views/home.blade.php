@section('title', 'HERMES - Home')

@extends('layouts.layout')

@section('scripts')
    @if(auth()->user()->type == "c")
        <script type="text/javascript" src="{{ asset('js/c_home.js') }}"></script>
    @else
        <script type="text/javascript" src="{{ asset('js/b_home.js') }}"></script>
    @endif
    <script type="text/javascript" src="{{ asset('js/offers.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/cart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/compare.js') }}"></script>
@endsection

@section('navigation')
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
<button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<!-- Right Side Of Navbar -->
<ul class="navbar-nav ml-auto">
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
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
</ul>
</nav>
@endsection

@section('content')
@if(auth()->user()->type == "c")
    <div class="row">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
        <div class="col">
            <div class="card m-lg-3">
                <div class="card-header">
                    <h1>Number of Orders per Category:</h1>
                </div>
                <div class="card-body" style="height: 325px;">
                    <!--  width="1300" -->
                    <canvas id="myChart"  height="275" style="width: 100%;"></canvas>
                </div>
            </div>    
        </div>
        
        
        

        <div class="col-lg-12">
             <div class="w-100 float-left" style="max-height: 34rem;">
                    <div class="card m-lg-3">
                        <div class="card-header">
                            <h1>Recommendations:</h1>
                        </div>
                        <div class="card-body overflow-auto p-0 m-0">
                            <div class="d-lg-flex align-items-stretch" style="overflow-x: auto; overflow-y: hidden;">
                                @foreach($recommendations as $offer)
                                    @include('offers.offer')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@else
<div class="row">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
        
        <div class="col-lg-6">
            <div class="card ml-lg-3 mt-3">
                <div class="card-header">
                    <h1>Number of Orders per Customer:</h1>
                </div>
                <div class="card-body" style="height: 850px;">
                    <!-- width="650" -->
                    <canvas id="customers_chart" style="width: 50%; height: 50%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mr-lg-3 mt-3">
                <div class="card-header">
                    <h1>Number of Orders per Offer:</h1>
                </div>
                <div class="card-body" style="height: 375px;">
                    <!-- width="650" -->
                    <canvas id="offers_chart" style="width: 50%; height: 50%;"></canvas>
                </div>
            </div>

            <div class="card mr-lg-3 mt-3">
                <div class="card-header">
                    <h1>Number of Orders per Month:</h1>
                </div>
                <div class="card-body" style="height: 375px;">
                    <!-- width="650" -->
                    <canvas id="months_chart" style="width: 50%; height: 50%;"></canvas>
                </div>
            </div>
        </div>
        
@endif




    
        
            
    

@endsection


{{--<div>Home</div>

    <div>
        @if (session('status'))
            <div>
                {{ session('status') }}
            </div>
        @endif

        You are logged in!
    </div>--}}