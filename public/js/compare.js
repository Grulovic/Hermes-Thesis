$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

function clear_compare(){
  $.ajax({
      type: "GET",
      url: '/session/compare',
      success: function() {
          $(".compare").empty();
          $(".compare").html('<h4 class="alert alert-info m-3" role="alert">The Compare List is empty...</h4>');
      },
      error:function(){
        alert("error clearing compare items");
      },
    });
}
// $('input').keyup(function() {
//   alert("qtys changed");
// });

var ascending = true;

var compare_sort = function (button){
  var sort_by = "compare_offer_" + $(button).val();
  
  var offers = $(".compare").children(".compare_offer");
  var sortList = Array.prototype.sort.bind(offers);

  sortList(function ( a, b ) {
      var aText = $(a).find("."+sort_by).html();
      var bText = $(b).find("."+sort_by).html();
   
      if ( aText < bText ) {
          return ascending ? -1 : 1;
      }

      if ( aText > bText ) {
          return ascending ? 1 : -1;
      }

      return 0;
  });

  $(".compare").append(offers);
}

$(document).on('click', '#compare_sort button', function(e) {
  e.stopPropagation();
  
  $('#compare_sort button').each(function(i, obj) {
    $(obj).removeClass("active").find("i").removeClass("fa-sort-down").removeClass("fa-sort-up").addClass("fa-sort");
  });
  
  if(ascending){
    $(this).addClass("active").find("i").removeClass("fa-sort").toggleClass("fa-sort-up");
  }else{
    $(this).addClass("active").find("i").removeClass("fa-sort").toggleClass("fa-sort-down");
  }
  
  compare_sort(this);

  ascending = !ascending;
  // $(this).find("i").removeClass("fa-sort").toggleClass("fa-sort-down").toggleClass("fa-sort-up");
  // $(this).find("i").removeClass("fa-sort").toggleClass("fa-sort-down");

});

function hide_compare(button){
  // alert('here');
  // $(button).parent().parent().toggle();
  $(button).parent().parent().dropdown('toggle');
}

$(document).on('click', '.add_to_compare', function(e) {
	e.preventDefault();
	
	var offer_id = $(this).val();

	$.ajax({
      type: "POST",
      url: '/session/compare',
      data: {offer_id:offer_id},
      success: function(results) {
      		// alert(results);      
      		// location.reload();		
          $(document).find("#offers_compare").empty();
          $(document).find("#offers_compare").html(results);
      },
      error:function(){
        alert("error sending offer to session compare");
      },
    });
});

function delete_compare_item(button){
	var offer_id = $(button).val();

	$.ajax({
      type: "DELETE",
      url: '/session/compare',
      data: {offer_id:offer_id},
      success: function(results) {
      	// alert(results);
        $(button).parent().parent().remove();

        if(  $(".compare").find(".compare_offer").length == 0){
            $(".compare").html('<h4 class="alert alert-info m-3" role="alert">The Compare list is empty...</h4>');
        }
        // alert("compare order submited");
      },
      error:function(){
        alert("error deleting compare item");
      },
    });
}