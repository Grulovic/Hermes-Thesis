<div class="cart_wrap dropdown droptop">
  <a id="cart" class="dropdown-toggle fa bg-warning" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"  aria-expanded="false">
    &#xf07a;
  </a>
  <div class="dropdown-menu pt-0 pb-0" aria-labelledby="navbarDropdown" style="margin-right:45px; margin-bottom: 10px; ">
    <h3 class="card-header p-3">Shopping Cart:
      <button id="hide_cart" class="btn btn-outline-danger float-right ml-2" onclick="event.stopPropagation(); hide_cart(this)"><i class="fas fa-window-minimize"></i></button>
      <button id="clear_cart" class="btn btn-outline-danger float-right" onclick="event.stopPropagation(); clear_cart(this)"><i class="fas fa-broom"></i> Clear</button>
    </h3>

    <div class="cart" style="overflow-y: auto; width:500px; max-height: 700px;">
      @if($cart_offers != null)
      @foreach($cart_users as $user)
        <div class="card m-2 mb-4">
        <div class="card-header bg-warning text-black"><a href="/users/{{$user->id}}/show" style="color:black;"><h5>{{$user->name}}</h5></a></div>    
        <form class="cart_offers card-body pt-0 pb-0">
          <?php
          $total_price = 0;
          ?>
          @foreach($cart_offers as $offer)
            @if($offer->user_id == $user->id)
            <div class="cart_offer form-group row border-bottom pt-2 mb-0">
              <p class="w-50 pl-2"><a href="/offers/{{$offer->id}}">{{$offer->name}}</a></p><input  name="offers[]" value="{{$offer->id}}" hidden>
              <div class="w-50">
                <button class="delete_cart_item btn btn-danger float-right btn-sm mr-2" onclick="event.stopPropagation(); delete_cart_item(this);" value="{{$offer->id}}"><i class="fas fa-times"></i></button>
                <input class="form-control form-control-sm float-right mr-2" type="number" name="qtys[]" placeholder="Quantity..." style="width:100px;" value="1">
                <div class="float-right mt-1">${{$offer->price}}<span class="mr-2"> <i class="fas fa-times"></i> </span> </div>
              </div>
            </div>
            <?php
              $total_price += $offer->price;
            ?>
            @endif
          @endforeach
          <div class="form-group row border-bottom pt-2 mb-0 bg-light">
            <label class="cart_total_price ml-3 w-100" style="font-size: 20px;">
              <span class="float-left">Total Price:</span>
              <span class="float-right mr-5 pr-2">$
                <?php
                echo $total_price;
                ?>
              </span>
            </label>   
          </div>
          <label class="float-left mr-2 mt-2" style="font-size: 20px;">Payment:</label>  
              <select class="form-control form-control-sm float-left mt-2" name="payment" style="width: 100px;">
                <option value="card">Card</option>
                <option value="cash">Cash</option>
                <option value="paypal">Paypal</option>
              </select>
          <button class="btn btn-primary float-right m-2" onclick="cart_order(this);" style="width: 100px;">Order</button>
        </form>
        </div>
      @endforeach
      @else
      <h4 class="alert alert-info m-3" role="alert">The Cart is empty...</h4>
      @endif
    </div>
  </div>
</div>