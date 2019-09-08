@section('title')
	HERMES - Offer / {{$offer->name}}
@endsection

@extends('layouts.layout')

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/offers.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/cart.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/compare.js') }}"></script>
@endsection

@section('content')
<div class="row">

<div class="col-lg-4">
	<div class="card mt-3 ml-lg-3" >
		<div class="card-header">
			<h1>{{ $offer->name }}</h1>	
		</div>			
		
		<div id="carouselExampleControls" class="carousel slide container-fluid m-0 p-0" data-ride="carousel" style="height:300px;">
			  <div class="carousel-inner border-bottom">
			  	@foreach($offer->images as $image)
			  		@if ($loop->first)
			  			<div class="carousel-item active">
			  		@else
			  			<div class="carousel-item">
			  		@endif
				  	
				      <!-- <img class="d-block" src="{{url('uploads/'.$image->file_name)}}" style="max-height: 300px; margin-left: auto; margin-right: auto; " alt="First slide"> -->
				      <div class="d-block" style='height: 300px; background-image: url("{{url('uploads/'.$image->file_name)}}"); background-repeat:no-repeat; background-size:auto 100%; background-position: center; '></div>

				    </div>
			  	@endforeach
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
	  	</div>
		
		<div class="card-body" style="max-height: 580px; overflow-y: auto;">		
			<p class="card-text font-italic text-center" style="word-break:break-all;">{{$offer->description}}</p>

			<p>User: <a href="/users/{{$offer->user_id}}/show">{{$offer->user->name}}</a></p>
			<p>Category: <span class="font-weight-bold">{{$offer->category->name}}</span></p>
			<p>Available: <span class="font-weight-bold">{{$offer->available}}</span></p>
			<p>Rating({{$offer->averageRating()}}): <span class="font-weight-bold text-warning">
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
			</p>
			<p>Number of Orders: <span class="font-weight-bold">{{$offer->orders()->count()}}</span></p>	
			<h1 class="card-title pricing-card-title text-center">${{$offer->price}} <small class="text-muted">/ {{$offer->increment}}</small></h1>

			@if(auth()->user()->id == $offer->user_id)
				<a class="btn btn-warning btn-lg btn-block" href="/offers/{{ $offer->id }}/edit"><i class="fas fa-edit"></i> Edit</a>
			@else
				<a class="show_make_order btn btn-primary btn-lg btn-block" href="/orders/{{$offer->id}}/create/"><i class="fas fa-shopping-cart"></i> Order</a>
				<button class="add_to_cart btn btn-warning btn-block btn-lg" value="{{$offer->id}}"><i class="fas fa-cart-plus"></i> Add to Cart</button>
          		<button class="add_to_compare btn btn-info btn-block btn-lg" value="{{$offer->id}}"><i class="fas fa-exchange-alt"></i> Add to Compare</button>
          		@if(auth()->user()->type != "b")
          		<button class='add_offer_to_favorites btn  btn-block btn-lg  {{$offer->inFavorite() ? "btn-danger":"btn-primary"}}' value="{{$offer->id}}"><i class="fas fa-star"></i> {{$offer->inFavorite() ? "Remove from":"Add to"}} Favorites</button>
          		@endif

				<a class="message_user btn btn-outline-primary btn-lg btn-block" href="/conversations/{{$offer->user_id}}/create/"><i class="fas fa-comment-dots"></i> Message User</a>	
			@endif
		</div>
		
		
	</div>
</div>

<div class="col-lg-5">
	<div class="card mt-3">
		
		<div class="card-header">
			<h1>Reviews({{sizeof($offer->reviews)}}):</h1>
		</div>
		
		<div class="card-body" style="max-height: 880px; overflow-y: auto;">
			@if(sizeof($offer->reviews) != 0)
				@foreach($offer->reviews as $review)
					@include('offers.review')
				@endforeach
			@else
				<h4 class="alert alert-info m-1" role="alert">There are no reviews...</h4>
			@endif

		@if(auth()->user()->hasReview($offer->id) && auth()->user()->id != $offer->user_id)
			<div class="card">
				
			
			<div class="card-header "><h3>New Review:</h3></div>
			<div class="card-body p-3">
				<form method="POST"  action="/offers/{{ $offer->id }}/reviews">
					@csrf
					<div>
						<h2>Rating: <div class="rate">
					    <input type="radio" id="star5" name="rating" value="5" />
					    <label for="star5" title="text">5 stars</label>
					    <input type="radio" id="star4" name="rating" value="4" />
					    <label for="star4" title="text">4 stars</label>
					    <input type="radio" id="star3" name="rating" value="3" />
					    <label for="star3" title="text">3 stars</label>
					    <input type="radio" id="star2" name="rating" value="2" />
					    <label for="star2" title="text">2 stars</label>
					    <input type="radio" id="star1" name="rating" value="1" />
					    <label for="star1" title="text">1 star</label>
					  </div></h2>

					</div>
					
					<textarea name="description" class="form-control bg-light" rows="5" placeholder="Review comment..."required></textarea>
					<button type="submit" class="d-inline btn btn-primary btn-lg float-right mt-3" ><i class="fas fa-paper-plane"></i> Post Review</button>	
				</form>	
			</div>
			</div>
		@endif
		</div>

	</div>


</div>

<div class="col-lg-3">
		<div id="make_order"></div>
		<div id="show_tertiary"></div>
		<div id="show_user"></div>
		@include('errors')
	</div>
</div>

<div id="offers_cart">
		@include('offers.cart')  
	</div>

	<div id="offers_compare">
		@include('offers.compare')
	</div>
@endsection