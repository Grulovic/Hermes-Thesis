<div class="favorite card">
	<div class="card-header p-0" id="headingOne">
		<h2 class="mb-0">
			<button class="btn btn-link p-3 text-left" type="button" data-toggle="collapse" data-target="#offer{{$loop->index}}" aria-expanded="true" aria-controls="offer{{$loop->index}}" style="width: 85%;">
				<h4 class="p-0 m-0">{{$offer->name}}</h4>
			</button>
			<button class="remove_favorite btn btn-outline-danger float-right m-2" style="width: 10%;" value="{{$offer->favorite_id}}"><i class="fas fa-ban"></i></button>
		</h2>
	</div>
	<div id="offer{{$loop->index}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
		<div id="carouselExampleControls{{$loop->index}}" class="carousel slide container-fluid m-0 p-0" data-ride="carousel" style="height:300px;">
			
			<div class="carousel-inner">
				@foreach($offer->images as $image)
				@if ($loop->first)
				<div class="carousel-item active">
					@else
					
					<div class="carousel-item">
						@endif
						<a href="/offers/{{$offer->id}}">
						<!-- <img class="d-block " src="{{url('uploads/'.$image->file_name)}}" style=" max-height: 300px; margin-left: auto; margin-right: auto;" alt="First slide"> -->
					     <div class="d-block border-top" style='height: 300px; background-image: url("{{url('uploads/'.$image->file_name)}}"); background-repeat:no-repeat; background-size:auto 100%; background-position: center; '></div>
						</a>
					</div>
					
					@endforeach
				</div>
				<a class="carousel-control-prev" href="#carouselExampleControls{{$loop->index}}" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleControls{{$loop->index}}" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<div class="card-body text-center">
				{{$offer->description}}
			</div>

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

					<div>
						<button class="add_to_cart btn btn-warning float-left fa mr-1" value="{{$offer->id}}">&#xf217;</button>
						<button class="add_to_compare btn btn-info float-left fa mr-1" value="{{$offer->id}}">&#xf362;</button>
					</div>
				</ul>
			</div>
		</div>
	</div>