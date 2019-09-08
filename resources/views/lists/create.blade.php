<form method="POST" action="/lists">
	@csrf
	<div class="form-group">
		<h5>List Name:</h5>
		<input class="form-control" type="text" name="name" placeholder="List Name...">	
	</div>

	<div class="form-group">
		<h5>List Description:</h5>
		<!-- <input type="text" name="description" placeholder="List Description..."> -->
		<textarea class="form-control" name="description" placeholder="List Description..."></textarea>
				
	</div>
	
	<button class="btn btn-outline-primary btn-block" type="submit">Create</button>
</form>