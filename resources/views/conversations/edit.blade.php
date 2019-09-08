<div class="card">
<!-- <div class="card mt-3"> -->
	@if($conversation->user_id == auth()->user()->id)
	<div class="card-header">
		<h3 class="float-left">Edit Participants:</h3>		

		<div class="w-50 input-group float-right">
			<input id="edit_search" class="form-control" type="text" name="search" placeholder="Add user...">
		    <div class="input-group-append"><span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span></div>
		</div>
			<div id="search_display"></div>
	</div>
	@endif
	
	<div class="card-body">
		<div class="w-50 float-left">
			<h5>Current participants:</h5>
			<div class="list-group">
				@foreach($participants as $participant)

					@if(auth()->user()->id != $participant->user_id)
						@include('conversations.participant')
					@endif

				@endforeach	
			</div>	
		</div>
		
		<div class="w-25 pt-0 mt-0 float-right" id="new_participants_search_display">
			
		</div>

	</div>
</div>



@include('errors')