<div class="card mt-3">
	<div class="card-header">
		<h1>Create a New Conversation: </h1>
	</div>

	<div class="card-body">
		<form>
			<div class="form-group">
				<h5>Conversation Name:</h5>
				<input id="name" class="form-control form-control-lg" type="text" name="name" placeholder="Enter Conversation Name (Optional)..."/>
			</div>
			
			<h5>Add participant:</h5>
			<div class="input-group">
				<input id="create_search" class="form-control form-control-lg" type="text" name="search" placeholder="Add user...">
			    <div class="input-group-append"><span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span></div>
			</div>
			<div id="create_search_display"></div>

			<div id="added_participants" class="mt-3 mb-3">
				<input name="participants[]" value="-1" hidden/>
			</div>

			<div class="form-group">
				<button id="create_conversation" class="btn btn-primary btn-lg btn-block" value="/conversations"><i class="fas fa-plus"></i> Create Conversation</button>
			</div>
		</form>	

		@include('errors')	
	</div>
	
</div>