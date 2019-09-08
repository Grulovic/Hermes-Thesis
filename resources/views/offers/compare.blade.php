<div class="compare_wrap dropdown droptop">
  <a id="compare" class="dropdown-toggle fa bg-info" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"  aria-expanded="false">
    &#xf362;
  </a>
  <div class="dropdown-menu pt-0 pb-0" aria-labelledby="navbarDropdown" style="margin-right:115px; margin-bottom: 10px; ">
    <h3 class="card-header p-3">Compare List:
      <button id="hide_compare" class="btn btn-outline-danger float-right ml-2" onclick="event.stopPropagation(); hide_compare(this)"><i class="fas fa-window-minimize"></i></button>
      <button id="clear_compare" class="btn btn-outline-danger float-right" onclick="event.stopPropagation(); clear_compare(this)"><i class="fas fa-broom"></i> Clear</button>
    </h3>
    <div id="compare_sort" class="card-header">
      <div class="float-left mr-3" style="font-size: 20px;">Compare by: </div>
      <button class="btn btn-outline-primary " value="user">User <i class="fas fa-sort" style="font-size:20px;"></i></button>
      <button class="btn btn-outline-primary " value="name">Name <i class="fas fa-sort" style="font-size:20px;"></i></button>
      <button class="btn btn-outline-primary " value="category">Category <i class="fas fa-sort" style="font-size:20px;"></i></button>
      <button class="btn btn-outline-primary " value="available">Available <i class="fas fa-sort" style="font-size:20px;"></i></button>
      <button class="btn btn-outline-primary " value="price">Price <i class="fas fa-sort" style="font-size:20px;"></i></button>
      <button class="btn btn-outline-primary " value="rating">Rating <i class="fas fa-sort" style="font-size:20px;"></i></button>
      <button class="btn btn-outline-primary " value="orders"># Orders <i class="fas fa-sort" style="font-size:20px;"></i></button>
    </div>

    <div class="compare" style="height: 420px; max-width: 1500px; white-space: nowrap">
      @if($compare_offers!=null)
        <div class="card d-inline-block mt-2 ml-2 mb-2">
          <!-- <div class="card-header bg-secondary text-info font-weight-bold"> - </div> -->
          <div class="card-header bg-secondary text-white font-weight-bold p-2">User</div>
          <div class="card-header bg-secondary text-white font-weight-bold p-2" style="height: 100px;">Description</div>
          <div class="card-header bg-secondary text-white font-weight-bold p-2">Category</div>
          <div class="card-header bg-secondary text-white font-weight-bold p-2">Available</div>
          <div class="card-header bg-secondary text-white font-weight-bold p-2">Price</div>
          <div class="card-header bg-secondary text-white font-weight-bold p-2">Rating</div>
          <div class="card-header bg-secondary text-white font-weight-bold p-2"># Orders</div>
        </div>
        @foreach($compare_offers as $offer)
        <div class="compare_offer card d-inline-block mt-2 mb-2 ml-1" style="min-width: 150px; max-width: 200px; max-height: 100%;">
          <div class="card-header bg-info text-white font-weight-bold w-100 pr-2 pt-2"> 
            <a class="compare_offer_name text-white" href="/offers/{{$offer->id}}">{{$offer->name}}</a>
            <button class="btn btn-danger float-right btn-sm mr-0" onclick="event.stopPropagation();  delete_compare_item(this);" value="{{$offer->id}}"><i class="fas fa-times"></i></button>
          </div>
          <div class="compare_offer_user card-header p-2"><a class="text-dark" href="/users/{{$offer->user->id}}/show">{{$offer->user->name}}</a></div>
          <div class="card-header p-2" style="height: 100px; overflow-y: auto;">{{$offer->description}}</div>
          <div class="compare_offer_category card-header p-2">{{$offer->category->name}}</div>
          <div class="compare_offer_available card-header p-2">{{$offer->available}}</div>
          <div class="compare_offer_price card-header p-2">${{$offer->price}}<small class="text-muted"> / {{$offer->increment}}</small></div>
          <div class="compare_offer_rating card-header p-2">{{$offer->averageRating()}}</div>
          <div class="compare_offer_orders card-header p-2">{{$offer->orders()->count()}}</div>
        </div>
        @endforeach
      @else
      <h4 class="alert alert-info m-3" role="alert">The Compare List is empty...</h4>
      @endif
    </div>
  </div>
</div>