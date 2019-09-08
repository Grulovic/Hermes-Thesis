@if(auth()->user()->id == $request->offer->user_id)
			@if($request->status != 'complete' && $request->status != 'canceled' && $request->status != 'closed')
<div class="card mt-3">
	<div class="card-header">
		<h1 class="title">Edit Request:</h1>		
	</div>

	<div class="card-body">
		<form>

			<meta name="csrf-token" content="{{ Session::token() }}"> 
				
			<div class="form-group">
				<h5>Shipping Date:</h5>
				<input class="form-control form-control-lg" type="date" name="shipping_date" value="{{$request->details->shipping_date}}">
			</div>

			<div class="form-group">
				<h5>Delivery Date:</h5>
				<input class="form-control form-control-lg" type="date" name="delivery_date" value="{{$request->details->delivery_date}}">
			</div>

			<div class="form-group">
				<h5>Status:</h5>
				<select  class="form-control form-control-lg" name="status" style="background-color :{{ $errors->has('status') ? 'red;' : 'white;'}}" value="{{ old('status') }}" >
					<option value="hold" {{$request->status == 'hold'  ? 'selected' : '' }}>Hold</option>
					<option value="processing" {{$request->status == 'processing'  ? 'selected' : '' }}>Processing</option>
					<option value="complete" {{$request->status == 'complete'  ? 'selected' : '' }}>Complete</option>
					<option value="closed" {{$request->status == 'closed'  ? 'selected' : '' }}>Closed</option>
				</select>
			</div>

			<div class="form-group">
				@if(auth()->user()->id == $request->offer->user_id)
					<button id="update_request" class="btn btn-primary" value="/requests/{{$request->id}}">Update Request</button>
				@endif
			</div>
		</form>
	</div>
</div>
	@endif
@endif

@include('errors')	