@section('title', 'HERMES - Offers')

@extends('layouts.layout')

@include('offers.second_navigation')

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/offers.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/cart.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/compare.js') }}"></script>
@endsection

@section('content')
  
  <ul id="offers" class="row justify-content-center" style="padding-bottom: 85px; height:500px; overflow-y: auto; list-style: none;">
    @foreach ($offers as $offer)
    @include('offers.offer')
    @endforeach  
  </ul>

  <div id="offers_links" class="justify-content-end">
    <div class="btn btn-light float-left border p-2 mr-3">Showing <span class="font-weight-bold text-primary">{{$showing_offers}}</span> of <span class="font-weight-bold text-primary">{{$num_of_offers}}</span> Offers</div>
    {{ $offers->links() }}
  </div>

  <div id="offers_cart">
    @include('offers.cart')  
  </div>

  <div id="offers_compare">
    @include('offers.compare')
  </div>

@endsection

