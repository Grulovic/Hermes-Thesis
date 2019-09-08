@section('second_navigation')
<form action="/friends" method="GET">

	<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse p-0" id="navbarSupportedContent2">
			<ul class="navbar-nav">
				<li class="nav-item mr-2">
					<div class="input-group">
						@if(isset(request()->name))
						<input id="search_users" class="form-control" type="text" name="name" placeholder="Search..." value="{{request()->name}}">
						@else
						<input id="search_users" class="form-control" type="text" name="name" placeholder="Search...">
						@endif
						<div class="input-group-append"><span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span></div>
					</div>
					<div id="search_display"></div>

				</li>

				<li class="nav-item">
					<button type="submit" class="btn btn-primary font-weight-bold ml-3" value="Submit">SEARCH <i class="fas fa-search"></i></button>        
				</li>
			</ul>
		</div>
	</nav>
</form>
@endsection