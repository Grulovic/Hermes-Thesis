@section('title', 'HERMES - Favorites')

@extends('layouts.layout')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/favorites.js') }}"></script>
@endsection

@section('content')
<div class="row mr-1 ml-1">

	@if($users!=null)
	<div class="col-lg-4">
		<div class="card mt-3">
			<div class="card-header">
				<h3><i class="fas fa-user"></i> Favorite Users:</h3>
			</div>
			<div class="card-body">
				<div class="accordion" id="accordionExample">
					@foreach($users as $user)
						@include('favorites.page')
					@endforeach
				</div>
			</div>
		</div>
	</div>
	@endif

	@if($offers!=null)
	<div class="col-lg-4">
		<div class="card mt-3">
			<div class="card-header">
				<h3><i class="fas fa-shopping-basket"></i> Favorite Offers:</h3>
			</div>
			<div class="card-body">
				<div class="accordion" id="accordionExample">
					@foreach($offers as $offer)
						@include('favorites.offer')
					@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif
		
		@if($threads!=null)
		<div class="col-lg-4">
			<div class="card mt-3">
				<div class="card-header">
					<h3><i class="fas fa-align-justify"></i> Favorite Threads:</h3>
				</div>
				<div class="card-body">
					<div class="accordion" id="accordionExample">
						@foreach($threads as $thread)
							@include('favorites.thread')
						@endforeach
					</div>
				</div>
			</div>	
		</div>
		@endif
@endsection

