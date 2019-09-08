@extends('layouts.layout')

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/offers.js') }}"></script>
@endsection

@section('content')

<div class="card mt-3 float-left ml-3" >
	
	<div class="card-header">
		<h1 class="float-left">Edit Offer ({{$offer->name}}): </h1>
	</div>

	<div class="card-body">
		<form method="POST" action="/offers/{{$offer->id}}" enctype="multipart/form-data">

		{{method_field('PATCH')}}
		{{ csrf_field() }}
			
			<h3>Name:</h3>
			<input class="form-control mb-2" type="text" style="background-color :{{ $errors->has('name') ? 'red;' : 'white;'}}" name="name" placeholder="Offer name..." value="{{ $offer->name }}" required>
		

			<h3>Description:</h3>
			<textarea class="form-control mb-2" name="description" style="background-color :{{ $errors->has('description') ? 'red;' : 'white;'}}" placeholder="Offer description..." required>{{ $offer->description }}</textarea>
		

			<h3>Category:</h3>
			<!-- <input class="form-control mb-2" type="number" style="background-color :{{ $errors->has('category_id') ? 'red;' : 'white;'}}" name="category_id" placeholder="Offer category..." value="{{ $offer->category_id }}" required> -->
			<select name="category_id" class="form-control  mb-2" style="background-color :{{ $errors->has('category_id') ? 'red;' : 'white;'}}" placeholder="Offer category..." value="{{ old('category_id') }}" required>
	      		@foreach($categories as $category)
		      		<option value="{{$category->id}}">{{$category->name}}</option>
		      		@if($category->id == $offer->category_id)
		      		<option value="{{$category->id}}" selected>{{$category->name}}</option>
		      		@endif
	      		@endforeach
		    </select>

		    <h3>Increment:</h3>
			<select name="increment" class="form-control  mb-2" style="background-color :{{ $errors->has('increment') ? 'red;' : 'white;'}}" placeholder="Offer increment..." value="{{ $offer->increment }}" required>
	      		<option value="unit" @if($offer->increment == "unit") selected @endif >unit</option>
	      		<option value="service" @if($offer->increment == "service") selected @endif >service</option>
	      		<option value="hour" @if($offer->increment == "hour") selected @endif >hour</option>
	      		<option value="month" @if($offer->increment == "month") selected @endif >month</option>
	      		<option value="year" @if($offer->increment == "year") selected @endif >year</option>
		    </select>
			
			<h3>Available:</h3>
			<input class="form-control mb-2" type="available" style="background-color :{{ $errors->has('available') ? 'red;' : 'white;'}}" name="available" placeholder="Offer available..." value="{{ $offer->available }}" required>
			
			<h3>Price:</h3>
			<input class="form-control mb-2" type="price" style="background-color :{{ $errors->has('price') ? 'red;' : 'white;'}}" name="price" placeholder="Offer price..." value="{{ $offer->price }}" required>
		
			<h3>Pictures:</h3>
			<div class="custom-file mb-2">
				<input id="offer_image" type="file" name="images[]" class="custom-file-input" value="{{ old('image') }}" multiple>
				<label class="custom-file-label text-secondary" for="validatedCustomFile">Choose images...</label>
				<div class="invalid-feedback">Error</div>
			</div>

			<div id="upload_images" class="card">
			
			</div>
		
			<button class="btn btn-primary btn-lg float-right btn-lg btn-block" type="submit" ><i class="fas fa-save"></i> Update Offer</button>
		</form>
		<form method="POST" action="/offers/{{ $offer->id }}">
			@method('DELETE')
			@csrf 
			<button class="btn btn-danger btn-lg float-right btn-lg btn-block mt-1" type="submit"><i class="fas fa-trash-alt"></i> Delete Offer</button>
		</form>
	</div>
	@include('errors')
</div>

@include('offers.preview')

@endsection