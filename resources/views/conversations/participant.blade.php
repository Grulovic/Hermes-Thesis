<li class="list-group-item p-2 bg-light">
	<a class="user" href="/users/{{$participant->user_id}}/show" style="font-size: 25px;">

		@if($participant->user->details->file_name != null)
			<img class="m-0 p-0 ml-1 mr-1 float-left border" src="{{url('uploads/'.$participant->user->details->file_name)}}" style='height: 45px; width: 45px; border-radius: 50%; object-fit: cover;'>
		@else
			<div class="m-0 p-0 ml-1 mr-1 float-left" style="height: 45px; width: 45px;"><i class="fas fa-user-circle p-0 m-0" style="font-size: 45px;"></i></div>
		@endif
	{{$participant->user->name}}</a>

	@if($conversation->user_id == auth()->user()->id)
	<a class="delete_participant btn btn-outline-danger float-right" href="/conversations/{{ $participant->id }}/participant">Delete</a>
	@endif
</li>