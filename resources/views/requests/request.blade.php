<div href="/requests/{{ $request->id }}" class="show_request list-group-item list-group-item-action flex-column align-items-start p-2 bg-user" style="word-wrap: break-word; cursor: pointer;"> 
	<div class="d-flex justify-content-between">
	  <h5>Request {{ $request->id}}</h5>
	  
	  	@if($request->status == "ordered")
			<div class="request_status mb-1 btn btn-primary btn-sm float-right text-uppercase font-weight-bold">{{$request->status}}</div>
		@elseif($request->status == "hold")
			<div class="request_status mb-1 btn btn-secondary btn-sm float-right text-uppercase font-weight-bold">{{$request->status}}</div>
		@elseif($request->status == "processing")
			<div class="request_status mb-1 btn btn-info btn-sm float-right text-uppercase font-weight-bold">{{$request->status}}</div>
		@elseif($request->status == "complete")
			<div class="request_status mb-1 btn btn-success btn-sm float-right text-uppercase font-weight-bold">{{$request->status}}</div>
		@elseif($request->status == "closed")
			<div class="request_status mb-1 btn btn-warning btn-sm float-right text-uppercase font-weight-bold text-white">{{$request->status}}</div>
		@elseif($request->status == "canceled")
			<div class="request_status mb-1 btn btn-danger btn-sm float-right text-uppercase font-weight-bold">{{$request->status}}</div>
		@endif
	</div>

	<div class="pt-0 float-left w-75">
		From: 
		<a href="#" onclick="location.href = '/users/{{$request->user_id}}/show';">{{ $request->user->name }}</a>
		<br>
		For:
		@foreach($request->order_offers as $key => $request_offer)
			<a href="#" onclick="location.href = '/offers/{{$request_offer->offer->id}}';">{{$request_offer->offer->name}}</a>
	  		@if($loop->remaining != 0)
			,
			@endif
	  	@endforeach
	</div>

	<small class="float-right w-25">{{$request->created_at}}</small>
</div>