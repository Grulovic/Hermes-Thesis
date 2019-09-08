@section('title', 'HERMES - Forum')

@extends('layouts.layout')

@include('forum.second_navigation')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/forum.js') }}"></script>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-4">
		<div id="search_display"></div>

		<div class="card mt-3 ml-lg-3">
			<div class="card-header"><h3>Threads:</h3></div>
			<div id="threads" class="card-body p-2" style="height: 730px; overflow-y: auto;" >
				@foreach ($threads as $thread)
					@include('forum.thread')
				@endforeach
			</div>
						
			<div class="card-header border-top">
				<div class="btn btn-sm border p-2 float-left" style="background-color: white;">
					Showing <span class="font-weight-bold text-primary">{{$showing_offers}}</span> 
					of <span class="font-weight-bold text-primary">{{$num_of_offers}}</span>
				</div>
				<div class="simple-paginate float-right">{{$threads->links()}}</div>
			</div>
		</div>
		
	</div>

	<div class="col-lg-8">
		<div id="show_page">
			@if($show_thread != null)
			<?php
				$thread = $show_thread;
			?>
				@include('forum.show')
			@endif
		</div>
	</div>

	<!-- <div class="col-sm-3">
		<div id="show_tertiary">
			
		</div>
		<div id="show_user">
			
		</div>
	</div> -->
</div>
@endsection

@include('errors')