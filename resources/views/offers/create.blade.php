@extends('layouts.layout')

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/offers.js') }}"></script>
@endsection

@section('content')

<div class="card mt-3 float-left ml-3">
	
	<div class="card-header">
		<h1>Create New Offer: </h1>
	</div>

	<div class="card-body">
		<form method="POST" action="/offers" enctype="multipart/form-data">

		{{ csrf_field() }}

			<h3>Name:</h3>
			<input class="form-control mb-2" type="text" style="background-color :{{ $errors->has('name') ? 'red;' : 'white;'}}" name="name" placeholder="Offer name..." value="{{ old('name') }}" required>
		

			<h3>Description:</h3>
			<textarea class="form-control mb-2" name="description" style="background-color :{{ $errors->has('description') ? 'red;' : 'white;'}}" placeholder="Offer description..." required>{{ old('description') }}</textarea>
		

			<h3>Category:</h3>
			<!-- <input class="form-control mb-2" type="number" style="background-color :{{ $errors->has('category_id') ? 'red;' : 'white;'}}" name="category_id" placeholder="Offer category..." value="{{ old('category_id') }}" required> -->
			<select name="category_id" class="form-control  mb-2" style="background-color :{{ $errors->has('category_id') ? 'red;' : 'white;'}}" placeholder="Offer category..." value="{{ old('category_id') }}" required>
	      		@foreach($categories as $category)
		      		<option value="{{$category->id}}">{{$category->name}}</option>
	      		@endforeach
		    </select>

		    <h3>Increment:</h3>
			<select name="increment" class="form-control  mb-2" style="background-color :{{ $errors->has('increment') ? 'red;' : 'white;'}}" placeholder="Offer increment..." value="{{ old('increment') }}" required>
	      		<option value="unit">unit</option>
	      		<option value="service">service</option>
	      		<option value="hour">hour</option>
	      		<option value="month">month</option>
	      		<option value="year">year</option>
		    </select>
			
			<h3>Available:</h3>
			<input class="form-control mb-2" type="available" style="background-color :{{ $errors->has('available') ? 'red;' : 'white;'}}" name="available" placeholder="Offer available..." value="{{ old('available') }}" required>
			
			<h3>Price:</h3>
			<input class="form-control mb-2" type="price" style="background-color :{{ $errors->has('price') ? 'red;' : 'white;'}}" name="price" placeholder="Offer price..." value="{{ old('price') }}" required>
		
			<h3>Pictures:</h3>
			<div class="custom-file mb-2">
				<input id="offer_image" type="file" name="images[]" class="custom-file-input" value="{{ old('image') }}" multiple required>
				<label class="custom-file-label text-secondary" for="validatedCustomFile">Choose images...</label>
				<div class="invalid-feedback">Error</div>
			</div>

			<div id="upload_images" class="card">
			
			</div>

			<button class="btn btn-primary btn-lg float-right btn-lg btn-block" type="submit" ><i class="fas fa-plus"></i> Create Offer</button>
		
		</form>
	</div>
	@include('errors')
</div>

@include('offers.preview')

@endsection

