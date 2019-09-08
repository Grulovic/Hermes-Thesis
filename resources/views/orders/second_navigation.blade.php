@section('second_navigation')
      <form action="/orders" method="GET">

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom pb-0">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent2">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item mr-3">
      	<div class="input-group">
			@if(isset(request()->name))
			<input id="search_orders" class="form-control" type="text" name="name" placeholder="Search..." value="{{request()->name}}">
			@else
			<input id="search_orders" class="form-control" type="text" name="name" placeholder="Search...">
			@endif
		    <div class="input-group-append"><span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span></div>
		</div>
			<div id="search_display"></div>

      </li>
      <li class="nav-item">
			@if(isset(request()->statuses))
			<label class="btn btn-primary">Ordered <input type="checkbox" name="statuses[]" value="ordered" {{(in_array("ordered" , request()->statuses)) ? "checked" : ""}}></label>
			<label class="btn btn-secondary">Hold <input type="checkbox" name="statuses[]" value="hold" {{(in_array("hold" , request()->statuses)) ? "checked" : ""}}></label>
			<label class="btn btn-info">Processing <input type="checkbox" name="statuses[]" value="processing" {{(in_array("processing" , request()->statuses)) ? "checked" : ""}}></label>
			<label class="btn btn-success">Complete <input type="checkbox" name="statuses[]" value="complete" {{(in_array("complete" , request()->statuses)) ? "checked" : ""}}></label>
			<label class="btn btn-warning">Closed <input type="checkbox" name="statuses[]" value="closed" {{(in_array("closed" , request()->statuses)) ? "checked" : ""}}></label>
			<label class="btn btn-danger">Canceled <input type="checkbox" name="statuses[]"  value="canceled" {{(in_array("canceled" , request()->statuses)) ? "checked" : ""}}></label>
	        @else
				<label class="btn btn-primary">Ordered <input type="checkbox" name="statuses[]" value="ordered" checked=""></label>
				<label class="btn btn-secondary">Hold <input type="checkbox" name="statuses[]" value="hold" checked=""></label>
				<label class="btn btn-info">Processing <input type="checkbox" name="statuses[]" value="processing" checked=""></label>
				<label class="btn btn-success">Complete <input type="checkbox" name="statuses[]" value="complete" checked=""></label>
				<label class="btn btn-warning">Closed <input type="checkbox" name="statuses[]" value="closed" checked=""></label>
				<label class="btn btn-danger">Canceled <input type="checkbox" name="statuses[]"  value="canceled" checked=""></label>
	        @endif
      </li>
      
      <li id="search_order_payment" class="nav-item dropdown ml-3">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Payment Type
        </a>
		<div class="dropdown-menu">
			  <div class="form-check" style="width: 175px;">
				@if(isset(request()->payments))
		      	<input name="payments[]" type="checkbox" class="form-check-input ml-1" id="dropdownCheck1" value="cash" {{(in_array("cash" , request()->payments)) ? "checked" : ""}}>
		      	@else
		      	<input name="payments[]" type="checkbox" class="form-check-input ml-1" id="dropdownCheck1" value="cash" checked>
		      	@endif
		      	<label class="form-check-label ml-4 w-100" for="dropdownCheck1">Cash</label>
			  </div>
			  <div class="dropdown-divider"></div>
			  <div class="form-check" style="width: 175px;">
			  	@if(isset(request()->payments))
		      	<input name="payments[]" type="checkbox" class="form-check-input ml-1" id="dropdownCheck2" value="card" {{(in_array("card" , request()->payments)) ? "checked" : ""}}>
			  	@else
		      	<input name="payments[]" type="checkbox" class="form-check-input ml-1" id="dropdownCheck2" value="card" checked>
		      	@endif
		      	<label class="form-check-label ml-4 w-100" for="dropdownCheck2">Card</label>
			  </div>
			  <div class="dropdown-divider"></div>
			  <div class="form-check" style="width: 175px;">
			  	@if(isset(request()->payments))
		      	<input name="payments[]" type="checkbox" class="form-check-input ml-1" id="dropdownCheck3" value="paypal" {{(in_array("paypal" , request()->payments)) ? "checked" : ""}}>
			  	@else
		      	<input name="payments[]" type="checkbox" class="form-check-input ml-1" id="dropdownCheck3" value="paypal" checked>
		      	@endif
		      	<label class="form-check-label ml-4 w-100" for="dropdownCheck3">Paypal</label>
			  </div>
		  </div>        
      </li>

      <li class="nav-item">
        <button type="submit" class="btn btn-primary font-weight-bold ml-3" value="Submit">SEARCH <i class="fas fa-search"></i></button>        
      </li>

    </ul>
  </div>
</nav>
</form>
@endsection