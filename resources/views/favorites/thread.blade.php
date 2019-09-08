<div class="favorite card">
	<div class="card-header p-0" id="headingOne">
		<h2 class="mb-0">
			<button class="btn btn-link p-3 text-left" type="button" data-toggle="collapse" data-target="#thread{{$loop->index}}" aria-expanded="true" aria-controls="thread{{$loop->index}}" style="width: 85%;">
				<h4 class="p-0 m-0">{{$thread->name}}</h4>
			</button>
			<button class="remove_favorite btn btn-outline-danger float-right m-2" style="width: 10%;" value="{{$thread->favorite_id}}"><i class="fas fa-ban"></i></button>
		</h2>
	</div>
	<div id="thread{{$loop->index}}" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample">
			<a href="/forum?show={{ $thread->id }}" class="thread show_thread list-group-item list-group-item-action flex-column align-items-start" style="word-wrap: break-word;">

		    <div class="d-flex w-100 justify-content-between">
		      <h5 class="mb-1">{{ $thread->name }}</h5>
		      <small>{{ $thread->created_at }}</small>
		    </div>

		    <small class="text-muted">Category: {{ $thread->category->name }}</small>
		  	<small class="btn btn-primary float-right">Replies <span class="badge badge-light">{{ $thread->replies->count()}}</span></small>

		    <p class="mb-1" style="max-width: 65%;">{{$thread->description}}</p>
		</a>				        
	</div>
</div>