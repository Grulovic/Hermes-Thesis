<a class="show_conversation list-group-item list-group-item-action
{{($participation->conversation->user_id == auth()->user()->id) ? "bg-user" : ""}}
" href="/conversations/{{ $participation->conversation_id }}"  style="direction: ltr;">
@if($participation->conversation->name == null)
	@foreach($participation->conversation->participants as $participant)
		@if($participant->user->name != auth()->user()->name)
			@if($participant->user->type == "b")
				<i class="fas fa-briefcase"></i>
			@else
				<i class="fas fa-user"></i>
			@endif

			{{ $participant->user->name }}
			@if($loop->remaining >= 1 && sizeof($participation->conversation->participants)!=2)
			,
			@endif
		@endif
	@endforeach
@else
{{$participation->conversation->name}}
@endif
	<span style="float: right;">
            <button class="leave_conversation btn 
            {{($participation->conversation->user_id == auth()->user()->id) ? "bg-danger text-white" : "btn-outline-danger"}}
             p-0" value="/conversations/{{ $participation->id }}/participant"><i class="fas fa-comment-slash pl-1"></i></button>
    </span>

    <span class="badge badge-primary badge-pill">{{ $participation->conversation->messages->count() }}</span>
</a>