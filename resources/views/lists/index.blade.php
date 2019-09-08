@section('title', 'HERMES - Lists')

@extends('layouts.layout')

@include('lists.second_navigation')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/lists.js') }}"></script>
@endsection

@section('content')
	
	<div class="row">

		<div class="col-lg-4">
			
			<div class="card mt-3 ml-lg-3">
				<div class="card-header"><h3>
					Lists:
					<a class="btn btn-outline-primary btn-sm float-right mt-1" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
					<i class="fas fa-notes-medical"></i> Create New List
				  </a>
				</h3></div>

				<div class="collapse border-bottom bg-light p-3" id="collapseExample">
				  	@include('lists.create')
				</div>
				
				<div class="card-body">
					<ul class="list-group">
						@foreach($lists as $list)
							<li class="show_list list-group-item list-group-item-action" value="{{$list->id}}">
								{{$list->name}}
								<span style="float: right;">
			                            <button class="delete_list btn btn-outline-danger p-0" value="{{$list->id}}"><i class="fas fa-times pl-1"></i></button>
			                    </span>
							</li>
						@endforeach
						<!-- href="/lists/create" -->
						<!-- <a id="create_list" href="#" style="text-decoration: none;"><li class="list-group-item active">Create New List</li></a> -->
					</ul>
				</div>
			</div>

			<div id="show_tertiary">
				
			</div>
			
			<div id="show_user">
				
			</div>
		</div>

		<div class="col-lg-8">
			<div id="show_page">
				
			</div>
		</div>

		
	</div>

@endsection