<div class="card mt-3 mr-lg-3">
  	<div class="card-header">
		<h1>
			@if($conversation->name == null)
				@foreach($conversation->participants as $participant)
					@if($participant->user->name != auth()->user()->name)
						{{ $participant->user->name }}
						@if($loop->remaining >= 1 && sizeof($conversation->participants)!=2)
						,
						@endif
					@endif

				@endforeach
			@else
			{{$conversation->name}}
			@endif
			
			@if($conversation->user_id == auth()->user()->id)		
			<span class="float-right">
				<a class="delete_conversation btn btn-outline-danger btn-sm" href="/conversations/{{ $conversation->id }}"><i class="fas fa-trash-alt"></i> Delete Conversation</a>		
				<!-- <a class="show_edit_conversation btn btn-outline-primary btn-sm" href="/conversations/{{ $conversation->id }}/edit"><i class="fas fa-edit"></i> Edit Participants</a> -->

				<a class="btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
					<i class="fas fa-edit"></i> Edit Participants
				  </a>
			</span>
			@else
			<a class="float-right mt-3 btn btn-outline-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Show Participants</a>
			@endif
		</h1>

		<input id="current_conversation_id" name="current_conversation_id" value="{{$conversation->id}}" hidden>
	</div>

	<div class="collapse" id="collapseExample">
	  	@if($participants != null)
	  		@include('conversations.edit')
	  	@endif
	</div>


	<div id="messages" class="p-3" style="overflow-y: scroll; height:750px; list-style: none;">
		<li value="-1"><li>
	@if($conversation->messages->count())
		<br>
			@foreach($messages as $key => $message)
				@include('conversations.message')
			@endforeach
	@endif
	</div>

</div>

<div class="list-group-item bg-light pt-3 mr-3">
	<form style="position: relative; margin-top: 35px;">
		<div class="input-group" style="position: absolute; bottom: 0; left: 0;">
		    <input id="input_messsage"  class="form-control" type="text" name="text" placeholder="Message..." required>
		    <div class="input-group-btn">
		      <button id="send_message" class="btn btn-primary ml-auto font-weight-bold" value="/conversations/{{ $conversation->id }}/message"><i class="fas fa-paper-plane"></i>SEND</button>
		    </div>
		  </div>
	</form>
</div>

@include('errors')
<input type="text" id="get_message_url" value="/conversations/{{ $conversation->id }}/getmessage" hidden>