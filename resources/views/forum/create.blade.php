<div class="card mt-3">
	<div class="card-header">
		<h1>Create a New Thread: </h1>
	</div>
	<div class="card-body">
	<form>
		<meta name="csrf-token" content="{{ Session::token() }}"> 

		<div class="form-group">
			<h5>Name:</h5>
			<input type="name" class="form-control form-control-lg" style="background-color :{{ $errors->has('name') ? 'red;' : 'white;'}}" name="name" placeholder="Thread name..." value="{{ old('name') }}" required>
		</div>

		<div class="form-group">
			<h5>Category:</h5>
			<!-- <input type="category" class="form-control form-control-lg" style="background-color :{{ $errors->has('category') ? 'red;' : 'white;'}}" name="category" placeholder="Thread category..." value="{{ old('category') }}" required> -->
			<select name="category_id" class="form-control form-control-lg mb-2" style="background-color :{{ $errors->has('category_id') ? 'red;' : 'white;'}}" placeholder="Offer category..." value="{{ old('category_id') }}" required>
				@if($form_categories != null)
		      		@foreach($form_categories as $category)
			      		<option value="{{$category->id}}">{{$category->name}}</option>
		      		@endforeach
	      		@endif
		    </select>
		</div>
		

		<div class="form-group">
			<h5>Description:</h5>		
			<textarea name="description" class="form-control form-control-lg" style="background-color :{{ $errors->has('description') ? 'red;' : 'white;'}}" placeholder="Thread description..." required>{{ old('description') }}</textarea>
		</div>
		
		<div class="form-group">
			<button id="create_thread" class="btn btn-primary" value="/forum">Create Thread</button>
		</div>
		
	</form>	
	@include('errors')

	</div>
</div>


