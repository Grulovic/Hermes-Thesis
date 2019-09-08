@if(auth()->user()->id == $order->user_id)
			@if($order->status == 'ordered' || $order->status == 'hold')
<div class="card mt-3">
	<div class="card-header">
		<h1 class="title">Edit Order:</h1>		
	</div>

	<div class="card-body">
		<form>

			<meta name="csrf-token" content="{{ Session::token() }}"> 
				
			<div class="form-group">
				<h5>Quantity:</h5>
				<input class="form-control form-control-lg" type="number" style="background-color :{{ $errors->has('qty') ? 'red;' : 'white;'}}" name="qty" placeholder="Order qty..." value="{{$order->details->qty}}" >
			</div>

			<div class="form-group">
				<h5>Payment:</h5>
				<select class="form-control form-control-lg" name="payment" style="background-color :{{ $errors->has('payment') ? 'red;' : 'white;'}}" >
				    <option value="card" {{$order->details->payment == 'card'  ? 'selected' : '' }}>Card</option>
				    <option value="cash" {{$order->details->payment == 'cash'  ? 'selected' : '' }}>Cash</option>
				    <option value="paypal" {{$order->details->payment == 'paypal'  ? 'selected' : '' }}>Paypal</option>
	  			</select>
			</div>

			<div class="form-group">
				@if(auth()->user()->id == $order->user_id)
					<button id="update_order" class="btn btn-primary" value="/orders/{{$order->id}}">Update Order</button>
					@if($order->status == 'ordered' || $order->status == 'hold')
						<button id="cancel_order" class="btn btn-danger" value="/orders/{{ $order->id }}">Cancel Order</button>		
					@endif		
				@endif
			</div>
		</form>
	</div>
</div>
	@endif
@endif

@include('errors')	