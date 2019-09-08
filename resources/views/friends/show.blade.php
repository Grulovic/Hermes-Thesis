@if(auth()->user()->areFriends($user->id))
	<div class="float-left w-25">
		@include('users.show')
	</div>

	{{--<!-- <div class="w-75 float-left " style="max-height: 34rem;">
		<div class="card mt-3 ml-3 mr-3">
		<h1 class="card-header">Together Conversations:</h1>
		<div class="card-body h-100" style="max-height: 29.3rem; overflow-y: auto;">
			<ul class="list-group">
			@foreach ($threads as $thread)
				
			@endforeach
			</ul>
		</div>
		</div>
	</div> -->--}}

	@if(sizeof($threads) > 0)
	<div class="float-right" style="height: 34rem; width: 67%;">
		<div class="card mt-3 ml-lg-3 mr-lg-3">
		<h1 class="card-header">Threads:</h1>
		<div class="card-body" style="height: 29.3rem; overflow-y: auto;">
			<ul class="list-group">
			@foreach ($threads as $thread)
				{{--@include('forum.thread')--}}
				@if(auth()->user()->id == $thread->user_id)
				<a href="/forum?show={{ $thread->id }}" class="user_thread show_thread list-group-item list-group-item-action flex-column align-items-start" style="background-color: #e5f0ff; word-wrap: break-word;">
				@else
					<a href="/forum?show={{ $thread->id }}" class="thread show_thread list-group-item list-group-item-action flex-column align-items-start" style="word-wrap: break-word;">
				@endif

				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">{{ $thread->name }}</h5>
				      <small>{{ $thread->created_at }}</small>
				    </div>

				    <small class="text-muted">Category: {{ $thread->category->name }}</small>
				  	<small class="btn btn-primary float-right">Replies <span class="badge badge-light">{{ $thread->replies->count()}}</span></small>

				    <p class="mb-1" style="max-width: 65%;">{{$thread->description}}</p>
				</a>
			@endforeach
			</ul>
		</div>
		</div>
	</div>
	@endif 

	@if(sizeof($offers) > 0)
	<div class="w-100 float-left " style="max-height: 34rem;">
		<div class="card mt-3 mr-lg-3">
			<div class="card-header">
				<h1>Offers:</h1>
			</div>
			<div class="card-body overflow-auto	p-0 m-0">
				<div class="d-lg-flex align-items-stretch" style="overflow-x: auto; overflow-y: hidden;">
					@foreach($offers as $offer)
						@include('offers.offer')
					@endforeach
				</div>
			</div>
		</div>
	</div>
	@endif

	@section('scripts')
		<script type="text/javascript" src="{{ asset('js/friends.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/offers.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/cart.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/compare.js') }}"></script>
	@endsection
@endif