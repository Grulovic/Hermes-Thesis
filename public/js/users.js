$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).on('click', '#delete_avatar', function(e) {
  alert("deleting avatar");

  e.preventDefault();
  var user_id = $(this).val();

  $.ajax({
    type:'DELETE',
    url: '/users/'+user_id+"/avatar",
    success:function(data){
      alert("here");
          // $(this).parent().remove();
          window.location.replace("/users/"+user_id+"/edit");
        },
        error:function(){
          alert('error deleting avatar');
        },
      });
});

$(document).on('click', '.delete_friend', function(e) {
  // alert("deleting friend");

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

$(document).find('.user_switch').hover(function() {
  $(this).find('.user_image').hide();
  $(this).find('.user_buttons').show();
}, function() {
  $(this).find('.user_image').show();
  $(this).find('.user_buttons').hide();
});

// $(document).on('click', '.show_offer', function(e) {
//   // alert("show offer");
//   e.preventDefault();
//   var url = $(this).attr("href");

//   window.location.replace(url);
// });