@if(isset($offer))
<div class="card mt-3 ml-3 w-25 float-left">
	<div class="card-header">
		<h1 id="offer_preview_name" >{{$offer->name}}</h1>	
	</div>			
	
	<div id="carouselExampleControls" class="carousel slide container-fluid m-0 p-0" data-ride="carousel">
		  <div class="carousel-inner">
		    @foreach($offer->images as $image)
			  		@if ($loop->first)
			  			<div class="carousel-item active" style="height:300px;">
			  		@else
			  			<div class="carousel-item" style="height:300px;">
			  		@endif
				  	
				      <img class="d-block " src="{{url('uploads/'.$image->file_name)}}" style="max-height: 300px; margin-left: auto; margin-right: auto;" alt="First slide">
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
	
	<div class="card-body">		
		<p id="offer_preview_description" class="card-text font-italic text-center" style="word-break:break-all;">{{$offer->description}}</p>

		<p>User: <a href="/users/{{auth()->user()->id}}/show">{{auth()->user()->name}}</a></p>
		<p>Category: <span id="offer_preview_category_id" class="font-weight-bold">{{ $offer->category->name }}</span></p>
		<p>Available: <span id="offer_preview_available" class="font-weight-bold">{{ $offer->available }}</span></p>
		<p>Average Rating: <span class="font-weight-bold">{{ $offer->averageRating() }}</span></p>
		<p>Number of Orders: <span class="font-weight-bold">{{ $offer->orders->count() }}</span></p>	
		<h1 class="card-title pricing-card-title text-center">$<span id="offer_preview_price">{{ $offer->price }}</span><small class="text-muted">/ {{$offer->increment}}</small></h1>
		
		<a class="btn btn-warning btn-lg btn-block" href="#"><i class="fas fa-edit"></i> Edit</a>
		<a class="show_make_order btn btn-primary btn-lg btn-block" href="#"><i class="fas fa-shopping-cart"></i> Order</a>
		<a class="btn btn-outline-primary btn-lg btn-block" href="#"><i class="fas fa-comment-dots"></i> Message User</a>	
	</div>
</div>
@else
<div class="card mt-3 ml-3 w-25 float-left">
	<div class="card-header">
		<h1 id="offer_preview_name" >Offer Preview Name</h1>	
	</div>			
	
	<div id="carouselExampleControls" class="carousel slide container-fluid m-0 p-0" data-ride="carousel">
		  <div class="carousel-inner">
		    
			    <div class="carousel-item active" >
			      <img class="d-block " src="{{url('images/offer_preview_default.jpg')}}" style="max-height: 300px; margin-left: auto; margin-right: auto;">
			    </div>
			
			    <div class="carousel-item" >
			      <img class="d-block" src="{{url('images/offer_preview_default.jpg')}}" style="max-height: 300px; margin-left: auto; margin-right: auto;">
			    </div>

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
	
	<div class="card-body">		
		<p id="offer_preview_description" class="card-text font-italic text-center" style="word-break:break-all;">Offer Preview Description</p>

		<p>User: <a href="/users/{{auth()->user()->id}}/show">{{auth()->user()->name}}</a></p>
		<p>Category: <span id="offer_preview_category_id" class="font-weight-bold">Offer Preview Category</span></p>
		<p>Available: <span id="offer_preview_available" class="font-weight-bold">Offer Preview Available</span></p>
		<p>Average Rating: <span class="font-weight-bold">5</span></p>
		<p>Number of Orders: <span class="font-weight-bold">123</span></p>	
		<h1 class="card-title pricing-card-title text-center">$<span id="offer_preview_price">Offer Preview Price</span><small class="text-muted"> / 
			<span id="offer_preview_increment">unit</span></small></h1>

		
		<a class="btn btn-warning btn-lg btn-block" href="#"><i class="fas fa-edit"></i> Edit</a>
		<a class="show_make_order btn btn-primary btn-lg btn-block" href="#"><i class="fas fa-shopping-cart"></i> Order</a>
		<a class="btn btn-outline-primary btn-lg btn-block" href="#"><i class="fas fa-comment-dots"></i> Message User</a>	
	</div>
	
</div>

<div id="upload_image_preview">
	
</div>
@endif