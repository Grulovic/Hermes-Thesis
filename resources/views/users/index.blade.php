@section('title', 'HERMES - Users')

@extends('layouts.layout')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/users.js') }}"></script>
@endsection

@include('users.second_navigation')

@section('content')
<div class="row">
	<div class="col-12">
		<!-- <ul class="users list-group">
		<a href="#" class="list-group-item list-group-item-action disabled active">Users:</a>	
		@foreach($users as $user)
			@if(auth()->user()->id != $user->id)
			<a class="list-group-item list-group-item-action" href="/users/{{$user->id}}/show">{{$user->name}}</a>
			@endif
		@endforeach
	</ul> -->
	<div id="users" class="row justify-content-center" style="padding-bottom: 85px; height:500px; overflow-y: auto;">
		@foreach($users as $user)
		@include('users.show')
		@endforeach
	</div>


	<div id="users_links" class="justify-content-end">
		<div class="btn btn-light float-left border p-2 mr-3">Showing <span class="font-weight-bold text-primary">{{$showing_users}}</span> of <span class="font-weight-bold text-primary">{{$num_of_users}}</span> Users</div>
		{{ $users->links() }}
	</div>
</div>
</div>
@endsection

