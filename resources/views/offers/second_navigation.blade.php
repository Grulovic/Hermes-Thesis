@section('second_navigation')
<form id="offers_search" action="/offers" method="GET">
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent2">
      <ul class="navbar-nav mr-auto">

        <li class="nav-item mr-3">
          <a id="show_categories" class="btn btn-secondary text-white">Categories</a>
        </li>
        <li class="nav-item mr-3">
        	<div class="input-group">
          <label for="name"></label>
           <input id="search_offers" class="form-control" type="text" name="name" placeholder="Search..." value='{{(isset(request()->name)) ? request()->name : ""}}' style="max-width: 150px;" focus>
           <div class="input-group-append"><span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span></div>
         </div>
         <div id="search_display"></div>

       </li>

       <li class="nav-item">

        <div class="btn-group" role="group">
          <button id="show_all_offers" type="button" class='btn btn-primary {{request()->show=="offers" ? "active" : ""}} {{request()->show=="user" ? "active" : ""}}'>All Offers <input type="radio" name="show" {{request()->show=="all" ? "checked" : ""}} {{!isset(request()->show) ? "checked" : ""}} value="all" hidden></button>
          <button id="show_offers" type="button" class="btn btn-primary {{request()->show=="offers" ? "" : "active"}}">Offers <input type="radio" name="show"  value="offers" {{request()->show=="offers" ? "checked" : ""}} hidden></button>
          <button id="show_user_offers" type="button" class="btn btn-primary {{request()->show=="user" ? "" : "active"}}">User Offers <input type="radio" name="show"  value="user" {{request()->show=="user" ? "checked" : ""}} hidden></button>
        </div>

      </li>

      <li class="btn btn-light p-0 ml-2" style="width: 400px; background-color: silver;">
          <label class="pl-0" for="range" style="text-align: right;">${{$price_min}}</label>
          <!-- <input type="button" value="-" onClick="subtract_one()" style="width: 5%;">  -->
          <input type="range" class="custom-range pt-2" id="range" value="{{isset(request()->range) ? request()->range : $price_max}}" min="{{$price_min}}" max="{{$price_max}}" step="1" name="range" onchange="show_range(this.value)" style="width:200px;">
          <!-- <input type="button" value="+" onClick="add_one()" style="width: 5%;"> -->
          <label class="pt-1 pr-0" for="range">${{$price_max}} (< <span id="show_range" class="font-weight-bold">${{isset(request()->range) ? request()->range : $price_max}}</span>) </label>
      </li>
      
      <li class="nav-item">
        
      </li>

       <li class="nav-item">
          <!-- <input type="text" name="categories[]" value="99" hidden> -->
          <button type="submit" class="btn btn-primary font-weight-bold ml-3" value="Submit">SEARCH <i class="fas fa-search"></i></button>        
       </li>

    </ul>
    @if(auth()->user()->type == "b")
    <div class="form-inline">
      <a class="btn btn-primary" href="/offers/create"><i class="fas fa-plus"></i> Create Offer</a>
    </div>
    @endif
  </div>
  </nav>

  <!-- <div id="offer_categories" class="text-black bg-light" style="width: 250px; height: 100%;"> -->
    <div id="categories" class="list-group list-group-flush col-lg-2 p-0 m-0 float-left bg-light text-black bg-light" style="width: 250px;">
      @include('layouts.categories')
    </div>
</form>
@endsection