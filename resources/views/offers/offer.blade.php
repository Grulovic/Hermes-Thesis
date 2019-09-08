@if($offer->user_id != auth()->user()->id)
  <li class="offer" style="list-style: none;">
@else
  <li class="user_offer" style="list-style: none;">
@endif    

<div class="card box-shadow m-2" style="cursor: pointer; width: 19.5rem; height:26rem; ">
  
    @if($offer->user_id == auth()->user()->id)
      <div class="card-header" style="background-color: #e5f0ff;">
        <h4 class="offer_header font-weight-normal float-left" onclick="window.location='/offers/{{ $offer->id }}';">{{ $offer->name }}</h4>
        <div class="offer_add_buttons w-100 mb-4 mt-1">
          <button class="add_to_compare btn btn-info float-right fa w-25 mr-1" value="{{$offer->id}}">&#xf362;</button>
        </div>
      </div>
    @else
      <div class="card-header">

        <h4 class="offer_header font-weight-normal float-left" onclick="window.location='/offers/{{ $offer->id }}';">{{ $offer->name }}</h4>

        <div class="offer_add_buttons mt-1 mb-1 float-right w-100">
          <button class="add_to_cart btn btn-warning fa w-25" value="{{$offer->id}}">&#xf217;</button>
          <button class="add_to_compare btn btn-info fa w-25" value="{{$offer->id}}">&#xf362;</button>
          @if(auth()->user()->type != "b")
          <button class='add_offer_to_favorites btn fa w-25  {{$offer->inFavorite() ? "btn-danger":"btn-primary"}}' value="{{$offer->id}}">&#xf005;</button>

           <div class="dropdown float-right">
              <button class="btn btn-secondary pt-1 pb-2 fas w-100 dropdown-toggle" type="button" id="offer{{$offer->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-notes-medical"></i>
              </button>
              
              <div class="dropdown-menu" aria-labelledby="offer{{$offer->id}}">
                <a class="dropdown-item bg-secondary text-white" href="#">Add Offer to List:</a>
                @foreach($lists as $list)
                  <!-- <a class="dropdown-item" href="#">{{$list->name}}</a> -->
                  
                  <form class="offer_add_list" method="POST" action="/lists/{{$list->id}}/items">
                    @csrf
                    <input class="offer_value" type="number" name="offer_id" hidden="" value="{{$offer->id}}">
                    <button class="dropdown-item" type="submit" onclick="event.preventDefault();">{{$list->name}}
                      @if($offer->inList($list->id))
                        <i class="float-right pt-1 fas fa-check"></i>
                      @endif
                    </button>
                  </form>
                @endforeach
                  <a class="dropdown-item bg-primary text-white" href="/lists">Go to Lists</a>
              </div>

          </div>
          @endif
        </div>
      </div>      
    @endif
    
    
    
<div class="offer_image_description card-body align-content-center p-0 m-0" onclick="window.location='/offers/{{ $offer->id }}';">    
    @if($offer->images->first()->file_name)
      <!-- <div class="d-flex justify-content-center p-0 m-0 overflow-hidden" style="object-fit: contain; width: 100%;">
      <a href="/offers/{{ $offer->id }}" style="text-decoration: none; color:black; cursor: default;">
       <img class="offer_image overflow-hidden" src="{{url('uploads/'.$offer->file_name)}}" alt="{{$offer->file_name}}" style="height: 250px;">

      <div class="offer_description p-3" style="height: 250px; display: none;">
        <p class=" font-italic" style="width: 100%; text-align: center;">{{$offer->description}}</p>
      </div> -->

      
      
      <div class="d-flex justify-content-center p-0 m-0 overflow-hidden" style="object-fit: contain; width: 100%;">
      <a href="/offers/{{ $offer->id }}" style="text-decoration: none; color:black; cursor: default;">
      <div class="offer_image border-bottom" alt="{{$offer->images->first()->file_name}}" style='height: 250px; width: 19.5rem; background-image: url("{{url('uploads/'.$offer->images->first()->file_name)}}"); background-repeat:no-repeat;
    background-size:auto 100%; background-position: center; '>

        <div class="offer_description font-italic" style="align-items: center; padding: 25px; justify-content: center; background-color: white; width: 100%; height:100%; text-align: center;">
          
          <h3 class="font-weight-bold">{{ $offer->name }}</h3>
           <div>{{$offer->description}}</div>
        </div>
      </div> 
      

    </a>
    </div>
    @endif
    
</div>
{{--
<!-- @if($offer->user_id == auth()->user()->id)
<div class="card-body pt-2" onclick="window.location='/offers/{{ $offer->id }}';" style="background-color: #e5f0ff;">
@else
<div class="card-body pt-2" onclick="window.location='/offers/{{ $offer->id }}';">
@endif -->
--}}
<div class="card-body pt-2" onclick="window.location='/offers/{{ $offer->id }}';">


    <ul class="list-unstyled">
      <span class="text-muted float-right">{{$offer->category->name}}</span>
      <li>User: <a href="/users/{{$offer->user->id}}/show">{{$offer->user->name}}</a></li>
      <li class="float-right">{{--$offer->averageRating()--}}<span class="font-weight-bold text-warning">

        @if($offer->averageRating() != 0)
          @for ($i = 0; $i < 5; $i++)
          <!-- ★ -->
            @if(!($i < $offer->averageRating()))
              <i class="fas fa-star text-secondary"></i>
            @elseif( strpos( $offer->averageRating(), "." ) == true  && ($offer->averageRating()-($i+1)<=0) ) 
              <i class="fas fa-star-half-alt"></i>
            @else
              <i class="fas fa-star"></i>  
            @endif

          @endfor
        @else
          <span class="text-secondary">No rating</span>
        @endif
        
      </span></li>
      <li>Available: <span class="font-weight-bold">{{$offer->available}}</span></li>
      <h2 class="card-title pricing-card-title float-right">${{$offer->price}} <small class="text-muted">/ {{$offer->increment}}</small></h2>
    </ul>

  </div>

</div>

</li>