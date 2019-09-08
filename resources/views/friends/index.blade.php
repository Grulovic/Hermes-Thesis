@section('title', 'HERMES - Friends')

@extends('layouts.layout')

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/friends.js') }}"></script>
@endsection

@include('friends.second_navigation')

@section('content')

	<div class="row">

		<div class="col-lg-4">
			
			<div class="card mt-3 ml-lg-3">
				<div class="card-header"><h3>Friends:</h3></div>
				<div class="card-body">
					<ul class="list-group">
						@foreach($friends as $friend)
						<!-- <li><a href="/friends/{{$friend->friend->id}}">{{$friend->friend->name}}</a></li> -->
						<li class='show_friend list-group-item list-group-item-action {{($friend->status == "request")? "bg-secondary text-white" : ""}} 
							{{($friend->status == "rejected")? "bg-light text-black" : ""}} ' value="{{$friend->friend->id}}">
							{{$friend->friend->name}}

							@if($friend->status == "rejected")
								<span class="badge badge-warning">Request Sent</span>
							@elseif($friend->status == "request")
								<span class="badge badge-info">Request</span>
							@endif


							<span style="float: right;">
								@if($friend->status == "request")
									<button class="delete_friend btn btn-danger p-1 pl-2 float-right" value="{{$friend->id}}"><i class="fas fa-user-times"></i></button>
						           	 <button class="approve_friend btn btn-success p-1 pl-2 mr-2 float-right" value="{{$friend->id}}"><i class="fas fa-user-check"></i></button>
						           	 <!-- <button class="reject_friend btn btn-outline-danger p-1 mr-2 float-right" value="{{$friend->id}}"><i class="fas fa-user-times"></i></i></button> -->
					           	@elseif($friend->status == "approved" || $friend->status == "rejected")
                           	 		<button class="delete_friend btn btn-outline-danger p-1 pl-2 float-right" value="{{$friend->id}}"><i class="fas fa-user-times"></i></button>
							    @endif
		                    </span>
						</li>
						
						@endforeach
						
					</ul>
				</div>

				<div class="card-header border-top">
					<div class="simple-paginate float-right">{{$friends->links()}}</div>
					<div class="btn btn-sm border p-2 float-right" style="background-color: white;">
						Showing <span class="font-weight-bold text-primary">{{$showing_friends}}</span> 
						of <span class="font-weight-bold text-primary">{{$num_of_friends}}</span>
					</div>
					
				</div>
			</div>

			
		</div>

		<div id="show_page" class="col-lg-8">
			
		</div>

		
	</div>
@endsection

