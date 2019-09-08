<a class="text-dark" href="/users/{{$user->id}}/show" style="text-decoration: none;">
<div class="card mt-3 mr-3" style="cursor: pointer; width: 19.5rem; height: 34rem;">
	<div class="card-header">
		<h1 style=" width: 100%; overflow:hidden; white-space:nowrap; text-overflow: ellipsis;">
			{{$user->name}}
		</h1>
	</div>

	<div class="user_switch" style="height:350px; ">
		@if($user->details->file_name!=null)
		<!-- <img src="{{url('uploads/'.$user->details->file_name)}}" class="user_image card-img-top" alt="..." style="height: 100%;"> -->
		<div class="user_image border-bottom" style='height: 350px; width: 19.5rem; background-image: url("{{url('uploads/'.$user->details->file_name)}}"); background-repeat:no-repeat; background-size:cover; background-position: center; '>
      	</div>
		@else
		<div class="user_image card-img-top text-center text-secondary bg-light" alt="..." style="height:350px; line-height: 350px; font-size: 200px; vertical-align: middle;"> <i class="fas fa-user-circle"></i></div>
		@endif
	  	
	  	<div class="card-img-top user_buttons p-3" style="height:350px; display: none;">
			<a class="btn btn-info btn-block" href="/users/{{$user->id}}/show/"><i class="fas fa-user"></i> Go To Profile</a>

			@if(auth()->user()->id != $user->id)
				@if(!auth()->user()->hasFriend($user->id))
					<button class="add_friend btn btn-primary btn-block mt-2" value="{{$user->id}}"><i class="fas fa-user-plus"></i> Add Friend</button>
				@else
					<button class="delete_friend btn btn-danger btn-block mt-2" value="{{auth()->user()->areFriends($user->id)}}"><i class="fas fa-trash-alt"></i> Remove Friend</button>
				@endif
			@endif

			@if(auth()->user()->id != $user->id)

        		@if($user->type == "b")
					<a class="message_user btn btn-primary btn-block" href="/conversations/{{$user->id}}/create/"><i class="fas fa-comment-dots"></i> Message User</a>
				@elseif(auth()->user()->areFriends($user->id))
					<a class="message_user btn btn-primary btn-block" href="/conversations/{{$user->id}}/create/"><i class="fas fa-comment-dots"></i> Message User</a>
				@endif
				<button class="add_user_to_favorites btn {{$user->inFavorite()?'btn-danger':'btn-warning'}} btn-block" value="{{$user->id}}"><i class="fas fa-star"></i> {{$user->inFavorite()?' Remove':' Add'}} Favorite</button>

			@endif

			@if(auth()->user()->id == $user->id)
			<a href="/users/{{$user->id}}/edit" class="btn btn-warning btn-block"><i class="fas fa-user-cog"></i> Edit Profile</a>
			@endif
		</div>	
	</div>
	

	<div class="card-body">
		<div class="card-text">
			<h5 class="w-25 float-left">Email:</h5>
			<p class="w-75 float-left"><a href="mailto:{{$user->email}}">{{$user->email}}</a></p>	
		</div>

		<div class="card-text w-100 ">
			<div class="w-25 float-left"><h5>Type:</h5></div>
			<div class="w-50 float-left">
				@if($user->type == "b")
					<i class="fas fa-briefcase"></i> Business ({{sizeof($user->offers)}})
				@else
					<i class="fas fa-user"></i> Consumer
				@endif
			</div>
		</div>		
	</div>

	
</div>
</a>