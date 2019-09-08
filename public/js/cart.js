$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

function clear_cart(){
  $.ajax({
      type: "GET",
      url: '/session/cart',
      success: function() {
          $(".cart").empty();
          $(".cart").html('<h4 class="alert alert-info m-3" role="alert">The Cart is empty...</h4>');
      },
      error:function(){
        alert("error clearing cart items");
      },
    });
}
// $('input').keyup(function() {
//   alert("qtys changed");
// });

function hide_cart(button){
  // $(button).parent().parent().hide();
  $(button).parent().parent().dropdown('toggle');
}

$(document).on('click', '.add_to_cart', function(e) {
	e.preventDefault();
	
	var offer_id = $(this).val();

	$.ajax({
      type: "POST",
      url: '/session/cart',
      data: {offer_id:offer_id},
      success: function(results) {

        $(document).find("#offers_cart").empty();
        $(document).find("#offers_cart").html(results);
      		// alert(results);      
      		// location.reload();
      },
      error:function(){
        alert("error sending offer to session cart");
      },
    });
});

function cart_order(button){
	var form = $(button).parent();

	var offers = [];
	$(form).find('input[name^="offers"]').each(function() {
		offers.push($(this).val());
	});

	var qtys = [];
	$(form).find('input[name^="qtys"]').each(function() {
		qtys.push($(this).val());
	});

	var payment = $(form).find('select[name^="payment"]').val();

	console.log(offers);
	console.log(qtys);
	console.log(payment);

	$.ajax({
      type: "POST",
      url: '/orders/cart',
      data: {offers:offers, qtys:qtys, payment:payment},
      success: function(results) {
      	// alert(results);
        // $(button).parent().parent().remove();
        // alert("cart order submited");
        // return false;
        window.location.href = "/orders?show="+results;
      },
      error:function(){
        alert("error sending cart order");
      },
    });
}

function delete_cart_item(button){
  event.preventDefault();

	var offer_id = $(button).val();

	$.ajax({
      type: "DELETE",
      url: '/session/cart',
      data: {offer_id:offer_id},
      success: function(results) {
      	// alert(results);
        if($(button).parent().parent().parent().find(".cart_offer").length == 1){
          $(button).parent().parent().parent().parent().remove();
        }else{
          $(button).parent().parent().remove();
        }

        if(  $(".cart").find(".cart_offer").length == 0){
            $(".cart").html('<h4 class="alert alert-info m-3" role="alert">The Cart is empty...</h4>');
        }
        // $(button).parent().parent().remove();
        // alert("cart order submited");
        // return false;
      },
      error:function(){
        alert("error deleting cart item");
      },
    });
}