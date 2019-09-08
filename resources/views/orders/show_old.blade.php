<div class="card mt-3">
	<div class="card-header">
		<h1>Order {{ $order->id }} to <a href="/users/{{$order->offers_user->id}}">{{$order->offers_user->name}}</a>:
			@if($order->user_id == auth()->user()->id)
				@if($order->status == 'ordered' ||  $order->status == 'hold')
					<a class="show_edit_order btn btn-outline-primary float-right mt-2" href="/orders/{{$order->id}}/edit">Edit Order</a>
				@endif
			@endif
		</h1>
		
	</div>
	
	<div class="card-body">
		<div class="float-left w-25">
			<h4>Status: </h4>
				@if($order->status == "ordered")
			    	<p class="mb-1 btn btn-primary text-uppercase font-weight-bold">{{$order->status}}</p>
			    @elseif($order->status == "hold")
			    	<p class="mb-1 btn btn-secondary text-uppercase font-weight-bold">{{$order->status}}</p>
			    @elseif($order->status == "processing")
			    	<p class="mb-1 btn btn-info  text-uppercase font-weight-bold">{{$order->status}}</p>
			    @elseif($order->status == "complete")
			    	<p class="mb-1 btn btn-success  text-uppercase font-weight-bold">{{$order->status}}</p>
			    @elseif($order->status == "closed")
			    	<p class="mb-1 btn btn-danger text-uppercase font-weight-bold">{{$order->status}}</p>
			    @elseif($order->status == "canceled")
			    	<p class="mb-1 btn btn-danger text-uppercase font-weight-bold">{{$order->status}}</p>
			    @endif
			<h4>Payment: </h4>
			<p>{{ $order->details->payment }}</p>
			
			<h4>Shipper: </h4>
			<p>{{ $order->details->shipper }}</p>
			
			<h4>Shipping Date: </h4>
			<p>{{($order->details->shipping_date != null) ? $order->details->shipping_date : 'TBA'}}</p>
			
			<h4>Delivery Date: </h4>
			<p>{{($order->details->delivery_date != null) ? $order->details->delivery_date : 'TBA'}}</p>
		</div>

		<div class="float-right w-75">
			<h4> For offers: </h4>

			<table class="table table-striped">
			  <thead class="bg-primary text-white" style="font-size: 20px;">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Offer Name</th>
			      <th scope="col">Price</th>
			      <th scope="col">Quantity</th>
			      <th scope="col">Total<small class=""> /offer</small></th>
			    </tr>
			  </thead>
			  <tbody>
			@foreach($order->order_offers as $key => $order_offer)
			<!-- <div><a href="/offers/{{$order_offer->offer->id}}">{{$order_offer->offer->name}}</a>({{$order_offer->order_price}}) X {{$order_offer->qty}}</div> -->
			    <tr>
			      <th scope="row">{{++$key}}</th>
			      <td><a href="/offers/{{$order_offer->offer_id}}">{{$order_offer->offer->name}}</a></td>
			      <td>${{$order_offer->order_price}}<small class="text-muted"> / unit</small></td>
			      <td>{{$order_offer->qty}}</td>
			      <td>${{$order_offer->order_price * $order_offer->qty}}<small class="text-muted"> / total</small></td>
			    </tr>
			@endforeach
				<tr class="bg-primary text-white m-0 p-0">
			      <th scope="row" class="m-0 p-0 m-0 pl-2 pt-1"><h4>Total:</h4></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0  pl-2 pt-1"><h4 class="pricing-card-title">${{ $total_price }}</h4></th>
			    </tr>
			</tbody>
			</table>
			<!-- <div class="float-right">
				<h4 class="mt-5">Total Price: </h4>
				<h3 class="card-title pricing-card-title">${{ $total_price }}</h3>
			</div> -->
		</div>
	
	</div>
</div>

		

			
@include('errors')