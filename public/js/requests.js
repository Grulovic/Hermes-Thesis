$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// var search_requests = function(){
//   // var status = $(this).text();
//   var search = $("#search_requests").val();
//   var statuses = [];
//   var payments = [];

//   $('#search_request_options button').each(function(){
//     if(!$(this).hasClass("active")){
//      //alert($(this).text());
//      statuses.push($(this).text().toLowerCase());
//    }
//  });
//   $('#search_request_payment input:checked').each(function(){
//     //:checkbox:not(:checked)
//     // alert($(this).val());
//     payments.push($(this).val());
//   });

//   console.log(search);
//   console.log(statuses);
//   console.log(payments);

//   $.ajax({
//     type: "POST",
//     url: '/requests/search',
//     data: {name:search, statuses: statuses, payments:payments},
//     success: function(results) {
//           //$("#offers").html("");
//           $("#requests").empty();
//           $("#requests").html(results);  
//         },
//         error:function(){
//           alert('error searching requests');
//         },
//       });
// }

// $( "#search_request_options button").click(function(){
//   $(this).toggleClass('active shadow-sm text-dark text-white inner-shadow');
// });

// $(document).on('keyup', '#search_requests', function(e) {
//   search_requests();
// });

// $( "#search_request_options button, #search_request_payment input" ).click(function() {
//   search_requests();
// });

$(document).on('click', '.show_request', function(e) {
  //alert("show thread");
  e.preventDefault();
  var url = $(this).attr("href");
  
  $(document).find(".show_request").removeClass("inner-shadow-order").removeClass("bg-user-darker").addClass("bg-user");
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

$(document).on('click', '.show_edit_request', function(e) {
  e.preventDefault();
  var url = $(this).attr("href");
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      $("#show_tertiary").empty();
      $("#show_tertiary").append(data);
    },
    error:function(){
      alert('error showing conversation');
    },
  });
});

$(document).on('click', '#update_request', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");

  var shipping_date = $('input[name^="shipping_date"]').val();
  var delivery_date = $('input[name^="delivery_date"]').val();
  var status = $('select[name^="status"]').val();
  
  // alert(url+" "+shipping_date+" "+delivery_date+" "+status);
  
  $.ajax({
    type:'PATCH',
    url: url,
    data: {shipping_date:shipping_date, delivery_date:delivery_date, status:status},
    success:function(data){        
      window.location.replace("/requests?show="+data);
    },
    error:function(){
      alert('error updating request');
    },
  });
});