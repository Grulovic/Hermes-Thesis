@if($search_results->count())
<ul class="list-group">
	@foreach($search_results as $result)
		@if($result->id != auth()->user()->id)
			<a class="create_add_participant list-group-item text-dark p-1 bg-light" href="{{$result->id}}">{{ $result->name }}</a>
		@endif
	@endforeach
</ul>
@else
<a class="list-group-item text-dark p-1 bg-warning">No results...</a>
@endif