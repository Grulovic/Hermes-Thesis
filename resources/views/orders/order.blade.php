<div href="/orders/{{ $order->id }}" class="show_order list-group-item list-group-item-action flex-column align-items-start p-2 bg-user" style="word-wrap: break-word; cursor: pointer;"> 
	<div class="d-flex justify-content-between">
	  <h5>Order {{ $order->id}}</h5>
	  
	  	@if($order->status == "ordered")
			<div class="order_status mb-1 btn btn-primary btn-sm float-right text-uppercase font-weight-bold">{{$order->status}}</div>
		@elseif($order->status == "hold")
			<div class="order_status mb-1 btn btn-secondary btn-sm float-right text-uppercase font-weight-bold">{{$order->status}}</div>
		@elseif($order->status == "processing")
			<div class="order_status mb-1 btn btn-info btn-sm float-right text-uppercase font-weight-bold">{{$order->status}}</div>
		@elseif($order->status == "complete")
			<div class="order_status mb-1 btn btn-success btn-sm float-right text-uppercase font-weight-bold">{{$order->status}}</div>
		@elseif($order->status == "closed")
			<div class="order_status mb-1 btn btn-warning btn-sm float-right text-uppercase font-weight-bold text-white">{{$order->status}}</div>
		@elseif($order->status == "canceled")
			<div class="order_status mb-1 btn btn-danger btn-sm float-right text-uppercase font-weight-bold">{{$order->status}}</div>
		@endif
	</div>

	<div class="pt-0 float-left w-75">
		To: 
		<a href="#" aria-label="Go to {{$order->offers_user->name}} profile." title="Go to {{$order->offers_user->name}} profile." onclick="location.href = '/users/{{$order->offers_user->id}}/show';">{{ $order->offers_user->name}}</a>
		<br>
		For:
		@foreach($order->order_offers as $key => $order_offer)
			<a href="#" aria-label="Go to {{$order_offer->offer->name}} page." title="Go to {{$order_offer->offer->name}} page." onclick="location.href = '/offers/{{$order_offer->offer->id}}';">{{$order_offer->offer->name}}</a>
	  		@if($loop->remaining != 0)
			,
			@endif
	  	@endforeach
	</div>

	<small class="float-right w-25">{{$order->created_at}}</small>
</div>