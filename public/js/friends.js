$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).on('click', '.approve_friend', function(e) {
  var friend_id = $(this).val();
  var status = "approved";

    $.ajax({
      type:'PATCH',
      url: '/friends/'+friend_id,
      data: {status:status},
      success:function(data){
        // alert(data);
        window.location.replace("/friends");
      },
      error:function(){
        alert('error approving request');
      },
    });
});

// $(document).on('click', '.reject_friend', function(e) {
//   var friend_id = $(this).val();
//   var status = "rejected";

//     $.ajax({
//       type:'PATCH',
//       url: '/friends/'+friend_id,
//       data: {status:status},
//       success:function(data){
//         // alert(data);
//         window.location.replace("/friends");
//       },
//       error:function(){
//         alert('error rejecting request');
//       },
//     });
// });


$(document).on('click', '.delete_friend', function(e) {
  // alert("deleting list");

  e.preventDefault();
  var friend_id = $(this).val();

  $.ajax({
    type:'DELETE',
    url: '/friends/'+friend_id,
    success:function(data){
      // alert(data);
          // $(this).parent().remove();
          window.location.replace("/friends");
        },
        error:function(){
          alert('error deleting friend');
        },
      });
});

$(document).on('click', '.show_friend', function(e) {
  
  var friend_id = $(this).val();

  $.ajax({
    type:'GET',
    url: '/friends/'+friend_id,
    success:function(data){
      $("#show_tertiary").empty();
      $("#show_page").empty();
      $("#show_page").append(data);
      $(document).find(".offer_add_buttons").hide();
      $(document).find(".offer_description").hide();
    },
    error:function(){
      // alert('error showing friend');
    },
  });
});
