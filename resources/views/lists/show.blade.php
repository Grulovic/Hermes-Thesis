<div class="card m-0 mt-3 mr-3">
	<div class="card-header">
		<h3>{{$list->name}}</h3>
		<span class="text-muted">{{$list->description}}</span>
		<span class="text-muted float-right">{{$list->created_at}}</span>
		<input id="#list_id" name="list_id" type="text" value="{{$list->id}}" hidden="">		
	</div>

	
	
	<!-- <form method="POST" action="/lists/{{$list->id}}/items">
		@csrf 
		<input type="number" name="offer_id" placeholder="Offer id...">
		<button type="submit">Put item</button>
	</form> -->


	<div class="card-body">
		<ul class="row" >
			<div class="list-group w-100 mr-4">
				@foreach($offers as $offer)
				<a href="/offers/{{$offer->id}}" class="list-group-item p-0 mb-2 mr-4">
					
						<img class="float-left mr-3 p-1" src="{{url('uploads/'.$offer->images->first()->file_name)}}" style=" height: 75px; width: 75px; border-radius: 10%; object-fit: cover;">
						<div>
							
						</div>
						<h4 class="float-left mt-3">{{$offer->name}}</h4>
						<p class=" float-left text-dark w-50 mt-3 ml-3 text-muted" style="text-overflow: ellipsis; overflow:hidden; white-space:nowrap;"> {{$offer->description}} </p>
					
				<form method="POST" action="/lists/{{ $offer->item_id }}/items">
					@method('DELETE')
					@csrf 
					<button class="btn btn-danger float-right pr-2 m-3" type="submit"><i class="fas fa-trash-alt"></i></button>		
				</form>					
				</a>
			@endforeach
			</div>
		</ul>	
	</div>
</div>
