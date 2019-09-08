<div class="card mt-3 ml-0 mr-3">
	<div class="card-header">
		<h3>New Order of {{$offer->name}}:</h3>
	</div>

	<div class="card-body">
		<form method="POST" action="/orders">

		{{ csrf_field() }}
		
		<input type="number" name="offer_id" value="{{$offer->id}}" hidden>
		

		<div>
			<h4>Quantity:</h4>
			<input class="form-control" type="number" style="background-color :{{ $errors->has('qty') ? 'red;' : 'white;'}}" name="qty" placeholder="Offer qty..." value="{{ old('qty') }}" required>
		</div>
		

		<div class="mt-2">
			<h4>Payment:</h4>
			<select class="form-control" name="payment" style="background-color :{{ $errors->has('payment') ? 'red;' : 'white;'}}" value="{{ old('payment') }}" required>
				<option value="" selected disabled hidden>Choose here</option>
			    <option value="card">Card</option>
			    <option value="cash">Cash</option>
			    <option value="paypal">Paypal</option>
				</select>
		</div>
	
		<button class="btn btn-primary btn-lg btn-block mt-3" type="submit" ><i class="fas fa-shopping-cart"></i> Send Order</button>
		
		@include('errors')
	</form>	
		
	</div>
</div>


