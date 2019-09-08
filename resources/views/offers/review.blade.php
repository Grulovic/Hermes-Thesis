@if(auth()->user()->id == $review->user_id)
	<div class="card mb-3" style="background-color: #e5f0ff">
@else
	<div class="card mb-3" style="background-color: #ffe393">
@endif
	<div class="card-header">
	<a href="/users/{{$review->user_id}}/show" style="font-size:23px;">
		@if($review->user->details->file_name != null)
        	<img class="m-0 p-0 ml-0 mr-1 float-left border" src="{{url('uploads/'.$review->user->details->file_name)}}" style='height: 40px; width: 40px; border-radius: 50%; object-fit: cover;'>
		@else
        	<div class="m-0 p-0 ml-0 mr-1 float-left" style="height: 40px; width: 40px;"><i class="fas fa-user-circle p-0 m-0" style="font-size: 40px;"></i></div>
      	@endif
		{{$review->user->name}}
	</a>
		

		<small class="float-right">{{$review->updated_at}}</small>
	</div>
	<div class="card-body">
		
			<h5>
			<span class="float-left">
				Comment:	
			</span>
				
			<span class="float-right">
				
				Rating ({{$review->rating}}):

				@for ($i = 0; $i < $review->rating; $i++)
				<i class="fas fa-star"></i>
				@endfor
				
			</span>
			</h5>

		<div class="mt-4">{{$review->description}}</div>
		@if($review->user_id == auth()->user()->id)
		<form method="POST" action="/offers/{{ $review->id }}/reviews" style="float:right;">
			@method('DELETE')
			@csrf 
			<button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i> Delete Review</button>		
		</form>
		@endif
	</div>
</div>