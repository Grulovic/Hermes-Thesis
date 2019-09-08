<li value="{{$reply->id}}">
	<div class="card m-3">
		<div class="card-header">
			<a class="user" href="/users/{{$reply->user_id}}/show" >{{ $reply->user->name }}</a>
			<small class="float-right">{{ $reply->created_at }}</small>
		</div>
	
		<div class="card-body">
			{{ $reply->text }}
			
			@if($reply->user_id == auth()->user()->id)
				<a id="delete_reply" class="btn btn-outline-danger float-right" href="/forum/{{ $reply->id }}/replies">Delete</a>		
			@endif
		</div>
	</div>
</li>
