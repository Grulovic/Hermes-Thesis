@foreach($childs as $child)
	@if(count($child->childs))
	<!-- ima -->
		<a href="#item-{{$parent_index}}-{{$loop->index}}" class="list-group-item" data-toggle="collapse" style="text-decoration: none; color:black;">
		  <i class="far fa-caret-square-down text-primary"></i> {{$child->name}}
		  	@if(isset(request()->categories))
			<input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$child->id}}); event.stopPropagation();" value="{{$child->id}}" {{(in_array($child->id, request()->categories)) ? "checked" : ""}}>
	        @else
			<input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$child->id}}); event.stopPropagation();" value="{{$child->id}}">
	        @endif
		</a>
		<div class="list-group collapse" id="item-{{$parent_index}}-{{$loop->index}}" style="text-decoration: none; color:black;">
		  @include('layouts.category_children',['childs' => $child->childs, 'parent_index' => $parent_index."-".$loop->index])
		</div>

	@else
  	<!-- nema -->
		<a href="#" class="list-group-item" style="text-decoration: none; color:black;">{{$child->name}}
			@if(isset(request()->categories))
			<input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$child->id}}); event.stopPropagation();" value="{{$child->id}}" {{(in_array($child->id, request()->categories)) ? "checked" : ""}}>
	        @else
			<input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$child->id}}); event.stopPropagation();" value="{{$child->id}}">
	        @endif
		</a>
	@endif
@endforeach