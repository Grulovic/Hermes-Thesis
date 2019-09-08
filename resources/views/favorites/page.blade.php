<div class="favorite card">
	<div class="card-header p-0" id="headingOne">
		<h2 class="mb-0">
			<button class="btn btn-link p-3 text-left" type="button" data-toggle="collapse" data-target="#user{{$loop->index}}" aria-expanded="true" aria-controls="user{{$loop->index}}" style="width: 85%;">
				<h4 class="p-0 m-0">{{$user->name}}</h4>
			</button>
			<button class="remove_favorite btn btn-outline-danger float-right m-2" style="width: 10%;" value="{{$user->favorite_id}}"><i class="fas fa-ban"></i></button>
		</h2>
	</div>
	<div id="user{{$loop->index}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
		<div class="w-100 h-75">
			<div class="user_switch" style="height:350px; ">
				@if($user->details->file_name!=null)
				<!-- <img src="{{url('uploads/'.$user->details->file_name)}}" class="user_image card-img-top" alt="..." style="height: 100%;"> -->
				<div class="user_image border-bottom" style='height: 350px; background-image: url("{{url('uploads/'.$user->details->file_name)}}"); background-repeat:no-repeat; background-size:cover; background-position: center; '>
				</div>
				@else
				<div class="user_image card-img-top text-center text-secondary bg-light" alt="..." style="height:350px; line-height: 350px; font-size: 200px; vertical-align: middle;"> <i class="fas fa-user-circle"></i></div>
				@endif

				<div class="card-img-top user_buttons p-3" style="height:350px; display: none;">
					<a class="btn btn-info btn-block" href="/users/{{$user->id}}/show/"><i class="fas fa-user"></i> Go To Profile</a>

					@if(!auth()->user()->hasFriend($user->id))
					<button class="add_friend btn btn-primary btn-block mt-2" value="{{$user->id}}"><i class="fas fa-user-plus"></i> Add Friend</button>
					@endif

					@if(auth()->user()->id != $user->id)
					<a class="btn btn-outline-primary btn-block" href="/conversations/{{$user->id}}/create/"><i class="fas fa-comment-dots"></i> Message User</a>
					@endif

					@if(auth()->user()->id == $user->id)
					<a href="/users/{{$user->id}}/edit" class="btn btn-warning btn-block"><i class="fas fa-user-cog"></i> Edit Profile</a>
					@endif
				</div>	
			</div>
		</div>
		<div class="w-100 h-25 float-left p-2 bg-white">
			<div class="card-text bg">
				<h5 class="w-25 float-left">Email:</h5>
				<p class="w-75 float-left"><a href="mailto:{{$user->email}}">{{$user->email}}</a></p>	
			</div>

			<div class="card-text w-100 ">
				<div class="w-25 float-left"><h5>Type:</h5></div>
				<div class="w-50 float-left">
					@if($user->type == "b")
					<i class="fas fa-briefcase"></i> Business
					@else
					<i class="fas fa-restroom"></i> Consumer
					@endif
				</div>
			</div>	
		</div>
	</div>
</div>