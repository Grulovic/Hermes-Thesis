@if(auth()->user()->id == $thread->user_id)
<a href="/forum/{{ $thread->id }}" class="user_thread show_thread list-group-item list-group-item-action flex-column align-items-start" style="background-color: #e5f0ff; word-wrap: break-word;">
@else
	<a href="/forum/{{ $thread->id }}" class="thread show_thread list-group-item list-group-item-action flex-column align-items-start" style="word-wrap: break-word;">
@endif

    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">{{ $thread->name }}</h5>
      <small>{{ $thread->created_at }}</small>
    </div>

    <small class="text-muted">Category: {{ $thread->category->name }}</small>
  	<small class="btn btn-primary float-right">Replies <span class="badge badge-light">{{ $thread->replies->count()}}</span></small>

    <p class="mb-1" style="max-width: 65%;">{{$thread->description}}</p>
</a>