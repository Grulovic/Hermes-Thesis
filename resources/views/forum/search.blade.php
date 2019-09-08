@if($search_results->count())
<ul class="list-group">
	@foreach($search_results as $result)
		@if($result->user_id == auth()->user()->id)
			<a class="show_thread list-group-item text-dark p-1" style="background-color: #e5f0ff;" href="/forum/{{$result->id}}">{{ $result->name }}</a>
		@else
			<a class="show_thread list-group-item text-dark p-1 bg-light" href="/forum/{{$result->id}}">{{ $result->name }}</a>
		@endif
	@endforeach
</ul>
@else
<a class="list-group-item text-dark p-1 bg-warning">No results...</a>
@endif