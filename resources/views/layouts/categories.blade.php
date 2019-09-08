<div class="list-group list-group-root" style="">
  @foreach($categories as $category)
    @if(count($category->childs))
        <!-- ima -->
      <a href="#item-{{$loop->index}}" class="list-group-item text-black" data-toggle="collapse" style="text-decoration: none; color:black;">
        <i class="far fa-caret-square-down text-primary"></i> {{$category->name}}

        @if(isset(request()->categories))
        <input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$category->id}}); event.stopPropagation();" value="{{$category->id}}" {{(in_array($category->id, request()->categories)) ? "checked" : ""}}>
        @else
        <input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$category->id}}); event.stopPropagation();" value="{{$category->id}}">
        @endif

      </a>
      

      <div class="list-group collapse" id="item-{{$loop->index}}" style="text-decoration: none; color:black;">
        @include('layouts.category_children',['childs' => $category->childs, 'parent_index' => $loop->index])
      </div>
        
    @else
        <!-- nema -->
        <a href="#" class="list-group-item" style="text-decoration: none; color:black;">{{$category->name}}
          @if(isset(request()->categories))
          <input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$category->id}}); event.stopPropagation();" value="{{$category->id}}" {{(in_array($category->id, request()->categories)) ? "checked" : ""}}>
          @else
          <input class="float-right mt-1" type="checkbox" name="categories[]" onclick="check_category(this,{{$category->id}}); event.stopPropagation();" value="{{$category->id}}">
          @endif
        </a>
    @endif
  @endforeach
  <a id="hide_offer_categories" href="#" class="p-0 m-0 bg-secondary text-white text-center" style="text-decoration: none; color:black;"><i class="fas fa-caret-up"></i></a>
</div>