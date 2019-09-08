<div class="card-header">
	<h3>Edit Thread "{{$thread->name}}" ({{$thread->id}}):</h3>
</div>

<div class="card-body">
<form>
	<meta name="csrf-token" content="{{ Session::token() }}"> 

	<div class="form-group">
		<h5 for="name">Name:<h5>
		<input type="text" class="form-control bg-light" name="name" placeholder="Name..." value="{{ $thread->name }}">
	</div>

	<div class="form-group">
		<h5 for="category">Category:<h5>
		<!-- <input type="text" class="form-control form-control-lg bg-light" name="category" placeholder="Category..." value="{{ $thread->category }}"> -->
		<select name="category_id" class="form-control  mb-2" style="background-color :{{ $errors->has('category_id') ? 'red;' : 'white;'}}" placeholder="Offer category..." value="{{ $thread->category  }}" required>
      		@foreach($form_categories as $category)
	      		<option value="{{$category->id}}">{{$category->name}}</option>
	      		@if($category->id == $thread->category_id)
	      		<option value="{{$category->id}}" selected>{{$category->name}}</option>
	      		@endif
      		@endforeach
	    </select>
	</div>

	<div class="form-group">
		<h5 for="description">Description:<h5>
		<textarea class="form-control bg-light" name="description">{{ $thread->description}}</textarea>
	</div>

	<div class="form-group">
		<button id="update_thread" class="btn btn-primary" value="/forum/{{$thread->id}}"><i class="fas fa-save"></i> Update Thread </button>
		<button id="delete_thread" class="btn btn-danger" value="/forum/{{ $thread->id }}"><i class="fas fa-trash-alt"></i> Delete Thread</button>		
	</div>
</form>
</div>
@include('errors')