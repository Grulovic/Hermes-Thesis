@section('title', 'HERMES - Register')

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
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-lg-6">
    <div class="card mt-3">
      <div class="card-header">
        <h1>Register</h1>    
      </div>
      <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
        @csrf


        <div class="form-group">
          <label for="name">{{ __('Name') }}</label>
          <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Enter name..." name="name" value="{{ old('name') }}" required autofocus>
          <div class="valid-feedback">Valid.</div>
          @if ($errors->has('name'))
          <div class="invalid-feedback">{{ $errors->first('name') }}</div>
          @endif
        </div>


        <div class="form-group">
          <label for="email">{{ __('E-Mail Address') }}</label>
          <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Enter e-mail..." name="email" value="{{ old('email') }}" required autofocus>

          <div class="valid-feedback">Valid.</div>
          @if ($errors->has('email'))
          <div class="invalid-feedback">{{ $errors->first('email') }}</div>
          @endif
        </div>
        

        <div class="form-group">
          <label for="remember" class="form-check-label">{{ __('Type') }}</label><br>
          
            <label class="checkbox-inline"><input type="radio" class="{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" value="c" checked/>  Consumer</label>
            <label class="checkbox-inline"><input type="radio" class="{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" value="b" />  Business</label>
        <div class="valid-feedback">Valid.</div>
        @if ($errors->has('email'))
        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
        @endif
        
        </div>


        <div class="form-group">
          <label for="password">{{ __('Password') }}</label>
          <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="pwd" placeholder="Enter password..." name="password" required>
          <div class="valid-feedback">Valid.</div>
          
        </div>
        
        <div class="form-group">
          <label for="password">{{ __('Confirm Password') }}</label>
          <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="Confirm password..." required>
          <div class="valid-feedback">Valid.</div>
          @if ($errors->has('password'))
          <div class="invalid-feedback">{{ $errors->first('password') }}</div>
          @endif
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block">
            {{ __('Register') }}
        </button>
    </form>
      </div>
    </div>
  </div>
  <div class="col-md-3"></div>
</div>


@endsection
