<div id="show_thread" class="card mt-3 mr-3">
	<div class="card-header ">
		<h1>{{ $thread->name }}</h1>
		<div><em>Category: {{$thread->category->name}}</em></div>
		<input id="current_thread_id" type="text" name="thread_id" hidden="" value="{{$thread->id}}">
		@if($thread->user_id == auth()->user()->id)
		<!-- <a class="show_edit_thread btn btn-outline-primary float-right" href="/forum/{{ $thread->id }}/edit">Edit Thread</a> -->
		<a class="btn btn-outline-primary float-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
					<i class="fas fa-edit"></i> Edit Thread
				  </a>
		@else
		<button class="add_thread_to_favorites btn {{$thread->inFavorite()?'btn-danger':'btn-warning'}} float-right ml-1" value="{{$thread->id}}" style="color:;"><i class="fas fa-star"></i></button>
		


		<a class="btn btn-outline-primary float-right" href="/users/{{$thread->user_id}}/show">Creator: {{$thread->user->name}}</a>
		@endif
		
		<div>{{$thread->description}}</div>
	</div>

	<div class="card-header text-white bg-primary">
		<h4>Replies: </h4>
	</div>

	<div class="collapse" id="collapseExample">
	  	@if($thread)
	  		@include('forum.edit')
	  	@endif
	</div>
	
	<div id="replies" style="overflow-y: scroll; list-style: none;">
		<li value="-1"></li>
		@foreach ($thread->replies as $reply)
			@include('forum.reply')
		@endforeach
	</div>

	<input type="text" id="get_thread_url" value="/forum/{{ $thread->id }}/getreply" hidden>

	<div class="list-group-item bg-light pt-3">
		<form style="position: relative; margin-top: 35px;">
		<div class="input-group" style="position: absolute; bottom: 0; left: 0;">
			<meta name="csrf-token" content="{{ Session::token() }}"> 
		    
		    <input id="input_messsage"  class="form-control" type="text" name="text" placeholder="Reply..." required>
		    
		    <div class="input-group-btn">
		      <button id="send_reply" class="btn btn-primary ml-auto font-weight-bold" value="/forum/{{ $thread->id }}/replies"><i class="fas fa-paper-plane"></i>REPLY</button>
		    
		    </div>
		</div>
		</form>
	</div>

	<script type="text/javascript">
		var latest_displayed_reply = $( "#replies li" ).last().attr('value');

		var chat_height = $(window).height() - 350;
		$("#replies").attr("style" , "list-style: none; overflow-y: scroll; max-height:"+chat_height+"px" );
	</script>
</div>
@include('errors')