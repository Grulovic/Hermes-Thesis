@extends('layouts.layout')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/users.js') }}"></script>
@endsection

@section('content')
<div class="row">

<div class="col-lg-5 pt-3 pr-0">
	<div class="card ml-lg-3 mr-3" >
	
	<div class="card-header">
		<h1 class="float-left">Edit Profile: </h1>
	</div>

	<div class="card-body">
		<form method="POST" action="/users/{{$user->id}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			
			<h3>Name:</h3>
			<input class="form-control mb-2" type="text" style="background-color :{{ $errors->has('name') ? 'red;' : 'white;'}}" name="name" placeholder="User name..." value="{{ $user->name }}">
			
			<h3>E-mail:</h3>
			<input class="form-control mb-2" type="email" style="background-color :{{ $errors->has('email') ? 'red;' : 'white;'}}" name="email" placeholder="User email..." value="{{ $user->email }}">

			<div class="form-group">
	          <label for="password"><h3>{{ __('Password') }}:</h3></label>
	          <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Enter password..." name="password">
	          <div class="valid-feedback">Valid.</div>
	        </div>

	        <div class="form-group">
	          <label for="password"><h3>{{ __('Confirm Password') }}:</h3></label>
	          <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="Confirm password...">
	          <div class="valid-feedback">Valid.</div>
	          @if ($errors->has('password'))
	          <div class="invalid-feedback">{{ $errors->first('password') }}</div>
	          @endif
	        </div>

	        <h3>Description:</h3>
			<textarea class="form-control mb-2" name="description" style="background-color :{{ $errors->has('description') ? 'red;' : 'white;'}}" placeholder="Page description...">{{ $user->details->description }}</textarea>


			<div class="form-group">
				<h3>Avatar:</h3>
				<div class="custom-file" style="width: 70%;">
					<input id="user_image" type="file" name="image" class="custom-file-input" value="{{ old('image') }}">
					<label class="custom-file-label text-secondary" for="validatedCustomFile">{{($user->details->file_name != null) ? $user->details->original_file_name : "Choose images..."}}</label>
					<div class="invalid-feedback">Error</div>
				</div>

				<button id="delete_avatar" class="btn btn-danger mt-1 " value="{{$user->id}}"><i class="fas fa-trash-alt"></i> Delete Avatar</button>
			</div>
			
			

			<button class="btn btn-primary btn-lg float-right btn-lg btn-block" type="submit" ><i class="fas fa-save"></i> Update Profile</button>
		</form>
		@include('errors')
	</div>
</div>	
</div>

<div class="col-lg-2">
	@include('users.show')	
</div>



</div>
@endsection
