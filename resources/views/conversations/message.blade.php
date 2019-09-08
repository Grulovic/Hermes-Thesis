<li class="message mb-2" value="{{$message->id}}">
	@if($message->text == "  Left conversation or got removed!  ")
	
		<div class="alert alert-danger mt-3 w-100 text-center p-0"><i class="fas fa-sign-out-alt"></i> <a href="/users/{{$message->user->id}}/show">{{$message->user->name}}</a> {{ $message->text }}</div>
	
	@elseif($message->text == "  Joined the conversation!  ")
		
		<div class="alert alert-success mt-2 text-center p-0"><i class="fas fa-user"></i> <a  href="/users/{{$message->user->id}}/show">{{$message->user->name}}</a>
			{{ $message->text }}</div>
	@elseif($message->text == "  Deleted the message!  ")
		<div class="alert alert-danger mt-3 w-100 text-center p-0"><i class="fas fa-comment-slash"></i> <a href="/users/{{$message->user->id}}/show">{{$message->user->name}}</a> {{ $message->text }}</div>

	@else	

		@if(auth()->user()->id == $message->user_id)
			<div class="card w-50 ml-auto bg-user">
			<div class="message_info text-secondary pb-0 mb-0 bg-user-darker">
				<span class="ml-3 pb-1 mb-0 float-left">{{ $message->created_at }}</span>
				<button class="delete_message btn btn-outline-danger btn-sm float-right pb-0 mb-0" value="{{$message->id}}">
					<i class="fas fa-comment-slash"></i></button>
			</div>
		@else
			<a class="user" href="/users/{{$message->user_id}}/show" data-toggle="tooltip" data-placement="top" title="{{$message->user->name}}">
				@if($message->previous_user_id != $message->user_id || $message->previous_user_id == null)
					@if($message->user->details->file_name != null)
						<!-- <a href="#" data-toggle="tooltip" data-placement="top" title="{{$message->user->name}}"> -->
							<img class="m-0 p-0 ml-1 mr-1 float-left border" src="{{url('uploads/'.$message->user->details->file_name)}}" style='height: 45px; width: 45px; border-radius: 50%; object-fit: cover;'>
						<!-- </a> -->
					@else
					<!-- <a href="#" data-toggle="tooltip" data-placement="top" title="{{$message->user->name}}"> -->
						<div class="m-0 p-0 ml-1 mr-1 float-left" style="height: 45px; width: 45px;"><i class="fas fa-user-circle p-0 m-0" style="font-size: 45px;"></i></div>
					<!-- </a> -->
					@endif
				@else
					<div class="m-0 p-0 ml-1 mr-1 float-left" style="height: 45px; width: 45px;"></div>
				@endif
			</a>
			<div class="card w-50">
				<div class="message_info text-secondary pb-0 mb-0 bg-light">
					<a class="pl-3" href="/users/{{$message->user->id}}/show">{{ $message->user->name }}</a>
					<span class="ml-3 pb-1 mb-0 float-right pr-3">{{ $message->created_at }}</span>
				</div>
		@endif

			<div class="card-text m-2">
				
				{{ $message->text }}
			</div>
			
		</div>

	@endif
</li>