<div class="card mt-3 mr-3">
	<div class="card-header">
		<h1>Order {{ $order->id }} to <a href="/users/{{$order->offers_user->id}}/show">{{$order->offers_user->name}}</a>:
			@if(auth()->user()->id == $order->user_id)
				@if($order->status == 'ordered' || $order->status == 'hold')
				<div class="float-right">
					<button id="update_order" class="btn btn-primary btn-lg" value="/orders/{{ $order->id }}"><i class="fas fa-save"></i> Update Order</button>
					<button id="cancel_order" class="btn btn-danger btn-lg" value="/orders/{{ $order->id }}"><i class="fas fa-times"></i> Cancel Order</button>
				</div>
				@endif		
			@endif
		</h1>
		
	</div>
	
	@if(auth()->user()->id == $order->user_id)
		@if($order->status == 'ordered' || $order->status == 'hold')
			<form id="update_order_form">
			<meta name="csrf-token" content="{{ Session::token() }}">
		@endif
	@endif

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
			@if(auth()->user()->id == $order->user_id)
				@if($order->status == 'ordered' || $order->status == 'hold')
		      	<select class="form-control mb-2 w-50" name="payment" style="background-color :{{ $errors->has('payment') ? 'red;' : 'white;'}}" >
				    <option value="card" {{$order->details->payment == 'card'  ? 'selected' : '' }}>Card</option>
				    <option value="cash" {{$order->details->payment == 'cash'  ? 'selected' : '' }}>Cash</option>
				    <option value="paypal" {{$order->details->payment == 'paypal'  ? 'selected' : '' }}>Paypal</option>
	  			</select>
		      	@else
					<p style="text-transform: capitalize;">{{ $order->details->payment }}</p>
		      	@endif
		      @endif
			
			<h4>Shipper: </h4>
			<p style="text-transform: capitalize;">{{ $order->details->shipper }}</p>
			
			<h4>Shipping Date: </h4>
			<p>{{($order->details->shipping_date != null) ? $order->details->shipping_date : 'TBA'}}</p>
			
			<h4>Delivery Date: </h4>
			<p>{{($order->details->delivery_date != null) ? $order->details->delivery_date : 'TBA'}}</p>
		</div>

		<div class="float-right w-75">
			<h4> For offers: </h4>

			<table class="table table-striped text-center">
			  <thead class="bg-primary text-white" style="font-size: 20px;">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Picture</th>
			      <th scope="col">Name</th>
			      <th scope="col">Price</th>
			      <th scope="col">Quantity</th>
			      <th scope="col">Total<small class=""> /offer</small></th>
			    </tr>
			  </thead>
			  <tbody>
			@foreach($order->order_offers as $key => $order_offer)
			<!-- <div><a href="/offers/{{$order_offer->offer->id}}">{{$order_offer->offer->name}}</a>({{$order_offer->order_price}}) X {{$order_offer->qty}}</div> -->
			    <tr class="text-center" style="height: 100px;">
			      <th scope="row">{{++$key}}</th>
			      <td class="m-0 p-0 text-center" style="max-width: 200px;"><a href="/offers/{{$order_offer->offer->id}}"><img src="{{url('uploads/'.$order_offer->offer->images->first()->file_name)}}" alt="{{$order_offer->offer->images->first()->file_name}}" style=" max-height: 100px;"></a></td>
			      <td><a href="/offers/{{$order_offer->offer_id}}" aria-label="Go to .">{{$order_offer->offer->name}}</a></td>
			      <td>${{$order_offer->order_price}}<small class="text-muted"> / unit</small></td>
			      @if(auth()->user()->id == $order->user_id)
					@if($order->status == 'ordered' || $order->status == 'hold')
			      	<td>
			      		<input name="offers[]" value="{{$order_offer->id}}"" hidden>
			      		<input class="form-control m-0" type="number" style="max-width: 100px; background-color :{{ $errors->has('qty') ? 'red;' : 'white;'}}" name="qtys[]" placeholder="Order qty..." value="{{$order_offer->qty}}" >
			      	</td>
			      	@else
			      	<td>{{$order_offer->qty}}</td>
			      	@endif
			      @endif
			      
			      <td>${{$order_offer->order_price * $order_offer->qty}}<small class="text-muted"> / total</small></td>
			    </tr>
			@endforeach
				<tr class="bg-primary text-white m-0 p-0 text-center">
			      <th scope="row" class="m-0 p-0 m-0 pl-2 pt-1"><h4>Total:</h4></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0  pl-2 pt-1"><h4 class="pricing-card-title">${{ $total_price }}</h4></th>
			    </tr>
			</tbody>
			</table>
		</div>
	</div>
	@if(auth()->user()->id == $order->user_id)
		@if($order->status == 'ordered' || $order->status == 'hold')
			</form>
		@endif
	@endif
</div>

		

			
@include('errors')