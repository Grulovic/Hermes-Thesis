@section('title', 'HERMES - Requests')

@extends('layouts.layout')

@include('requests.second_navigation')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/requests.js') }}"></script>
@endsection

@section('content')
<div class="row">
	
	<div class="col-sm-4">

		<div class="card mt-3 ml-lg-3">
			<div class="card-header">
				<h1>Requests: </h1>
			</div>

			<div id="requests" class="card-body" style="height: 730px; overflow-y: auto;">
				<div class="list-group">
					@foreach ($requests as $request)
					@include('requests.request')
					@endforeach
				</div>	
			</div>
			<div class="card-header border-top">
				<div class="btn btn-sm border p-2 float-left" style="background-color: white;">
					Showing <span class="font-weight-bold text-primary">{{$showing_requests}}</span> 
					of <span class="font-weight-bold text-primary">{{$num_of_requests}}</span>
				</div>
				<div class="simple-paginate float-right">{{$requests->links()}}</div>
			</div>
		</div>

		
	</div>

<div id="show_page" class="col-sm-8">
	@if($show_request != null)
	<?php
	$request = $show_request;
	?>
	@include('requests.show')
	@endif
</div>

<!-- <div class="col-lg-3">
	<div id="show_tertiary">
		
	</div>
	<div id="show_user">
		
	</div>
</div> -->
</div>
@endsection