$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// var search_orders = function(){
//   // var status = $(this).text();
//   var search = $("#search_orders").val();
//   var statuses = [];
//   var payments = [];

//   $('#search_order_options button').each(function(){
//     if(!$(this).hasClass("active")){
//      //alert($(this).text());
//      statuses.push($(this).text().toLowerCase());
//    }
//  });
//   $('#search_order_payment input:checked').each(function(){
//     //:checkbox:not(:checked)
//     // alert($(this).val());
//     payments.push($(this).val());
//   });

//   // alert(console.log(status));
//   // alert(console.log(payments));

//   $.ajax({
//     type: "POST",
//     url: '/orders/search',
//     data: {name:search, statuses: statuses, payments:payments},
//     success: function(results) {
//           //$("#offers").html("");
//           $("#orders").empty();
//           $("#orders").html(results);  
//         },
//         error:function(){
//           alert('error searching status + payment');
//         },
//       });
// }

$( "#search_order_options button").click(function(){
  $(this).toggleClass('active shadow-sm text-dark text-white inner-shadow');
  $(this).next().prop('checked');

  // $(this).next().prop('checked');

});

// $(document).on('keyup', '#search_orders', function(e) {
//   search_orders();
// });

// $( "#search_order_options button, #search_order_payment input" ).click(function() {
//   search_orders();
// });

$(document).on('click', '.show_order', function(e) {
  //alert("show thread");
  e.preventDefault();
  var url = $(this).attr("href");

  $(document).find(".show_order").removeClass("inner-shadow-order").removeClass("bg-user-darker").addClass("bg-user");
  $(this).toggleClass("inner-shadow-order").addClass("bg-user-darker").removeClass("bg-user");
  
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      $("#show_page").empty();
      $("#show_tertiary").empty();
      $("#show_page").append(data);
    },
    error:function(){
      alert('error showing thread');
    },
  });
});

// $(document).on('click', '.show_edit_order', function(e) {
//   e.preventDefault();
//   var url = $(this).attr("href");
//   $.ajax({
//     type:'GET',
//     url: url,
//     success:function(data){
//       $("#show_tertiary").empty();
//       $("#show_tertiary").append(data);
//     },
//     error:function(){
//       alert('error showing conversation');
//     },
//   });
// });

$(document).on('click', '#cancel_order', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");
  $.ajax({
    type:'DELETE',
    url: url,
    success:function(data){
      window.location.replace("/orders");
    },
    error:function(){
      alert('error deleting order');
    },
  });
});

$(document).on('click', '#update_order', function(e) {
  var url = $(this).attr("value");
  
  e.preventDefault();

  var offers = [];
  $("#update_order_form").find('input[name^="offers"]').each(function() {
    offers.push($(this).val());
  });

  var qtys = [];
  $("#update_order_form").find('input[name^="qtys"]').each(function() {
    qtys.push($(this).val());
  });

  var payment = $("#update_order_form").find('select[name^="payment"]').val();
  
  // console.log(offers);
  // console.log(qtys);
  // console.log(payment);

  $.ajax({
    type:'PATCH',
    url: url,
    data: {offers:offers, qtys:qtys, payment:payment},
    success:function(data){
      // alert(data);
      window.location.replace("/orders?show="+data);
    },
    error:function(){
      alert('error updating order');
    },
  });
});

