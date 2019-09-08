@section('second_navigation')
<form id="threads_search" action="/forum" method="GET">
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent2">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item mr-3">
        <a id="show_categories" class="btn btn-secondary text-white">Categories</a>
      </li>
      <li class="nav-item mr-3">
      	<div class="input-group">
         <input id="search_threads" class="form-control" type="text" name="search" placeholder="Search..." value="{{(isset(request()->search)) ? request()->search : ""}}" focus>
         <div class="input-group-append"><span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span></div>
       </div>
       <div id="search_display"></div>

     </li>

     <li class="nav-item">

      <div class="btn-group" role="group">
        <button id="show_all_threads" type="button" class="btn btn-primary {{request()->show=="threads" ? "active" : ""}} {{request()->show=="user" ? "active" : ""}} ">All Threads <input type="radio" name="show" {{request()->show=="all" ? "checked" : ""}} {{!isset(request()->show) ? "checked" : ""}} value="all" hidden></button>
        <button id="show_threads" type="button" class="btn btn-primary {{request()->show=="threads" ? "" : "active"}}">Threads <input type="radio" name="show"  value="threads" {{request()->show=="threads" ? "checked" : ""}} hidden></button>
        <button id="show_user_threads" type="button" class="btn btn-primary {{request()->show=="user" ? "" : "active"}}">User threads <input type="radio" name="show"  value="user" {{request()->show=="user" ? "checked" : ""}} hidden></button>
      </div>

    </li>

    

     <li class="nav-item">
        <!-- <input type="text" name="categories[]" value="99" hidden> -->
        <button type="submit" class="btn btn-primary font-weight-bold ml-3" value="Submit">SEARCH <i class="fas fa-search"></i></button>        
     </li>

  </ul>
  <div class="form-inline my-2 my-lg-0">
      <button class="create_new_thread btn btn-primary" value="/forum/create"><i class="fas fa-plus"></i> Create Thread</button>
    </div>
</div>
</nav>

<!-- <div id="thread_categories" class="text-black bg-light" style="width: 250px; height: 100%;"> -->
  <div id="categories" class="list-group list-group-flush col-lg-2 p-0 m-0 float-left bg-light text-black bg-light" style="width: 250px;">
    @include('layouts.categories')
  </div>
</form>
@endsection