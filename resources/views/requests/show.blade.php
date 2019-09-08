<div class="card mt-3 mr-3">
	<div class="card-header">
		<h1>Request {{ $request->id }} from <a href="/users/{{$request->user_id}}/show">{{$request->user->name}}</a>:
			@if(auth()->user()->id == $request->offers_user_id)
				@if($request->status != 'complete' && $request->status != 'canceled' && $request->status != 'closed')
				<div class="float-right">
					<button id="update_request" class="btn btn-primary btn-lg" value="/requests/{{ $request->id }}"><i class="fas fa-save"></i> Update Request</button>
				</div>
				@endif		
			@endif
		</h1>
		
	</div>
	
	@if(auth()->user()->id == $request->offers_user_id)
		@if($request->status != 'complete' && $request->status != 'canceled' && $request->status != 'closed')
			<form id="update_request_form">
			<meta name="csrf-token" content="{{ Session::token() }}">
		@endif
	@endif

	<div class="card-body w-100">
		<div class="w-25 float-left">
			<h4>Status: </h4>
		    @if(auth()->user()->id == $request->offers_user_id)
				@if($request->status != 'complete' && $request->status != 'canceled' && $request->status != 'closed')
					<select  class="form-control w-75 mb-3" name="status" style="text-transform: capitalize; background-color :{{ $errors->has('status') ? 'red;' : 'white;'}}" value="{{ old('status') }}" placeholder="test">
						<option value="{{$request->status}}" disabled selected>{{$request->status}}</option>
						<option value="hold" {{$request->status == 'hold'  ? 'selected' : '' }}>Hold</option>
						<option value="processing" {{$request->status == 'processing'  ? 'selected' : '' }}>Processing</option>
						<option value="complete" {{$request->status == 'complete'  ? 'selected' : '' }}>Complete</option>
						<option value="closed" {{$request->status == 'closed'  ? 'selected' : '' }}>Closed</option>
					</select>
				@else
					@if($request->status == "complete")
				    	<p class="mb-1 btn btn-success  text-uppercase font-weight-bold">{{$request->status}}</p>
				    @elseif($request->status == "closed")
				    	<p class="mb-1 btn btn-warning text-uppercase font-weight-bold">{{$request->status}}</p>
				    @elseif($request->status == "canceled")
				    	<p class="mb-1 btn btn-danger text-uppercase font-weight-bold">{{$request->status}}</p>
				    @endif
				@endif
			@endif

			<h4>Payment: </h4>
			<p style="text-transform: capitalize;">{{ $request->details->payment }}</p>
			
			<h4>Shipper: </h4>
			<p style="text-transform: capitalize;">{{ $request->details->shipper }}</p>
			
			<h4>Shipping Date: </h4>
			@if(auth()->user()->id == $request->offers_user_id)
				@if($request->status != 'complete' && $request->status != 'canceled' && $request->status != 'closed')
					<input class="form-control mb-3 w-75" type="date" name="shipping_date" value="{{$request->details->shipping_date}}">
				@else
					<p>{{($request->details->shipping_date != null) ? $request->details->shipping_date : 'TBA'}}</p>
				@endif
			@endif

			
			<h4>Delivery Date: </h4>
			@if(auth()->user()->id == $request->offers_user_id)
				@if($request->status != 'complete' && $request->status != 'canceled' && $request->status != 'closed')
					<input class="form-control mb-4 w-75" type="date" name="delivery_date" value="{{$request->details->delivery_date}}">
				@else
					<p>{{($request->details->delivery_date != null) ? $request->details->delivery_date : 'TBA'}}</p>
				@endif
			@endif
		</div>

		<div class="w-75 float-right">
			<h4> For offers: </h4>

			<table class="table table-striped">
			  <thead class="bg-primary text-white text-center" style="font-size: 20px;">
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
			@foreach($request->order_offers as $key => $request_offer)
			<!-- <div><a href="/offers/{{$request_offer->offer->id}}">{{$request_offer->offer->name}}</a>({{$request_offer->order_price}}) X {{$request_offer->qty}}</div> -->
			    <tr class="text-center align-middle" style="height: 100px;">
			      <th scope="row">{{++$key}}</th>
			      <td class="m-0 p-0 text-center" style="max-width: 200px;"><a href="/offers/{{$request_offer->offer->id}}"><img src="{{url('uploads/'.$request_offer->offer->images->first()->file_name)}}" style=" max-height: 100px;"></a></td>
			      <td><a href="/offers/{{$request_offer->offer_id}}">{{$request_offer->offer->name}}</a></td>
			      <td>${{$request_offer->order_price}}<small class="text-muted"> / unit</small></td>
	      		  <td>{{$request_offer->qty}}</td>
			      <td>${{$request_offer->order_price * $request_offer->qty}}<small class="text-muted"> / total</small></td>
			    </tr>
			@endforeach
				<tr class="bg-primary text-white m-0 p-0 text-center">
			      <th scope="row" class="m-0 p-0 m-0 pl-2 pt-1"><h4>Total:</h4></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0"></th>
			      <th class="m-0 p-0  pl-2 pt-1"><h2 class="pricing-card-title">${{ $total_price }}</h2></th>
			    </tr>
			</tbody>
			</table>
		</div>

	</div>

	@if(auth()->user()->id == $request->offers_user_id)
		@if($request->status != 'complete' && $request->status != 'canceled' && $request->status != 'closed')
			</form>
		@endif
	@endif
</div>


		

			
@include('errors')