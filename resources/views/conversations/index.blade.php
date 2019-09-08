@section('title', 'HERMES - Conversations')

@extends('layouts.layout')

@include('conversations.second_navigation')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/conversations.js') }}"></script>
@endsection

@section('content')
<div class="row">

	<div class="col-lg-4">
		<div class="card mt-3 ml-lg-3 pr-0">
			<div class="card-header">
				<h4>Conversations: <button id="show_create" class="btn btn-primary float-right"><i class="fas fa-comment-medical"></i></button></h4>
				
			</div>
			<div class="card-body p-0">
				<ul id="conversations" class="conversations list-group">
					<div style="max-height: 730px; overflow-y: auto; direction: rtl;">
				@foreach ($participations as $participation)
					@include('conversations.conversation')
				@endforeach
				</div>
				</ul>
			</div>

			<div class="card-header border-top">
				<div class="btn btn-sm border p-2 float-left" style="background-color: white;">
					Showing <span class="font-weight-bold text-primary">{{$showing_participations}}</span> 
					of <span class="font-weight-bold text-primary">{{$num_of_participations}}</span>
				</div>
				<div class="simple-paginate float-right">{{$participations->links()}}</div>
			</div>

		</div>
			

		
		
	</div>

	<div class="col-lg-8 ">
		<div id="show_page">
			@if($conversation != null)
				@include('conversations.show')
			@endif
		</div>
	</div>

<!-- 	<div class="col-sm-3">
		<div id="show_tertiary">
			
		</div>
		<div id="show_user">
			
		</div>
	</div> -->
</div>
@endsection