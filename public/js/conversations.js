$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// alert(latest_displayed_message);
// var chat_height = $(window).height() - 250;
// $(document).find("#messages").attr("style" , "list-style: none; overflow-y: scroll; height:"+chat_height+"px" );
$(document).find(".leave_conversation").hide();

$(document).find("#messages li").each(function(){
        $(this).find('.message_info').hide();
      });

$(".show_conversation").hover(function() {
    $(this).find(".leave_conversation").show();
  }, function() {
    $(this).find(".leave_conversation").hide();
  }
);


$(document).on('click', '#messages li', function() {
  $(this).find(".message_info").slideToggle();
});
// $(document).find("#messages li").find(".card").hover(
//     function() {
//       $(this).find(".card-text").next().slideDown();
//     }, function() {
//       $(this).find(".card-text").next().slideUp();
//     }
//   );
$(document).on('keyup', '#edit_search', function(e) {
  e.preventDefault();
  var name = $(this).val();
  if (name == "") {
    $("#search_display").html("");
  }else {
    $.ajax({
      type: "POST",
      url: '/conversations/edit/search',
      data: {name: name},
      success: function(results) {
        $("#new_participants_search_display").html(results);   
      },
      error:function(){
        alert('error edit searching');
      },
    });
  }
});

$(document).on('keyup', '#create_search', function(e) {
  var name = $(this).val();
  if (name == "") {
    $("#search_display").html("");
  }
  else {
    $.ajax({
      type: "POST",
      url: '/conversations/create/search',
      data: {name: name},
      success: function(results) {
        $("#create_search_display").html(results);  
      },
      error:function(){
        alert('error create searching');
      },
    });
  }
});

$(document).on('click', '.show_conversation', function(e) {
  e.preventDefault();
  var url = $(this).attr("href");
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      $("#show_page").empty();
      $("#show_tertiary").empty();
      $("#show_page").append(data);
      
      $(document).find("#messages li").each(function(){
        $(this).find('.message_info').hide();
      });

      $(document).find('#messages').css('height',window.innerHeight-320);
    },
    error:function(){
      // alert('error showing conversation');
    },
  });
});

$(document).on('click', '#show_create', function(e) {
  e.preventDefault();
  var url = '/conversations/create';
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      $("#show_tertiary").empty();
      $("#show_page").empty();
      $("#show_page").append(data);
    },
    error:function(){
      alert('error showing conversation');
    },
  });
});

$(document).on('click', '.leave_conversation', function(e) {
	// alert("delete_participation");
	e.preventDefault();
	var url = $(this).attr("value");
	// alert(url);

  $.ajax({
    type:'DELETE',
    url: url,
    success:function(data){
       	// alert(data);
         window.location.replace("/conversations");
       },
       error:function(){
         alert('error deleting participation');
       },
     });
});

$(document).on('click', '.delete_added_participant', function(e) {
  e.preventDefault();
  $(this).parent().remove();
});

$(document).on('click', '#create_conversation', function(e) {
  //alert("adding participant");
  e.preventDefault();
  var url = $(this).attr("value");
  var name = $('input[name^="name"]').val();
  // alert(name);

  var participants = [];
  $('input[name^="participants"]').each(function() {
    participants.push($(this).val());
  });
  
  if(name!=""){
    $.ajax({
      type:'POST',
      url: url,
      data: {participants:participants, name:name},
      success:function(data){
            alert(data);
            window.location.replace("/conversations");
          },
          error:function(){
            alert('error sending participant message');
          },
        });  
  }else{
      $.ajax({
      type:'POST',
      url: url,
      data: {participants:participants},
      success:function(data){
            alert(data);
            window.location.replace("/conversations");
          },
          error:function(){
            alert('error sending participant message');
          },
        });  
  }
});

$(document).on('click', '.delete_participant', function(e) {
  // alert("delete_participant");
  e.preventDefault();
  var url = $(this).attr("href");
  //var button = this;
  // alert(url);
  var conversation_id = $("#current_conversation_id").val();

  $.ajax({
    type:'DELETE',
    url: url,
    success:function(data){
        // alert(data);
        // $(button).parent().remove();
        window.location.replace("/conversations?show="+conversation_id);
      },
      error:function(){
        alert('error deleting participant');
      },
    });
});

$(document).on('click', '.add_participant', function(e) {
  // alert("add_participant");
  e.preventDefault();

  var conversation_id = $('input[name^="current_conversation_id"]').val();
  var user_id = $(this).attr("href");
  var url = "/conversations/"+conversation_id+"/participant";
  // alert(conversation_id);
  // alert(user_id);
  $.ajax({
    type:'POST',
    url: url,
    data: {conversation_id:conversation_id, user_id:user_id},
    success:function(data){
          // alert(data);
          window.location.replace("/conversations?show="+conversation_id);
        },
        error:function(){
          alert('error adding participant');
        },
      });
});


$(document).on('click', '.create_add_participant', function(e) {
  e.preventDefault();
  var user_id = $(this).attr("href");
  var user_name = $(this).html();
  var exists = false;

  $('input[name^="participants"]').each(function() {
    if($(this).val() == user_id){
      if(exists != true){
        exists = true;  
      }
    }
  });

  if(!exists){
    $('#added_participants').append('<li class="added_participant list-group-item pb-4 pt-3"><input name="participants[]" value="'+ user_id +'" hidden/>'+user_name+'<a class="delete_added_participant btn btn-outline-danger float-right" href="">Delete</a></li>');    
  }else{
    alert("User is already added");
  }
});

//when input clicked

$(document).on('click', '#input_messsage', function(e) {
//clear the inputed value
$("#input_messsage").val("");
});

 //variable latest diplayed message is on show right before it is presented
 function getLatestMessage(e) {
  // alert("here");
// e.preventDefault();
var url = $("#get_message_url").attr("value");
// alert("before" + latest_displayed_message);
var latest_displayed_message = $( "#messages li" ).last().attr('value');

$.ajax({
  type:'GET',
  url: url,
  success:function(data){
          // alert(data.message_id + ">" + latest_displayed_message);
          if(data.message_id > latest_displayed_message){
        // alert(data.message_id + "!=" + latest_displayed_message);
          //alert(data.message_html);
          $("#messages").append(data.message_html);
          $("#messages").find(".card-text").next().hide()
          $('#messages').scrollTop($('#messages')[0].scrollHeight);
          // alert("new message" + data.message_id);
          latest_displayed_message = data.message_id;
          // alert("after" + latest_displayed_message);
          $(document).find("#messages li").each(function(){
            $(this).find('.message_info').hide();
          });
        }
        // alert("same posted");
      },
      error:function(){
        //alert('error getting message');
      },
    });
}
setInterval(getLatestMessage, 1000);

$(document).on('click', '#send_message', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");
  var message = $("#input_messsage").val();

  $.ajax({
    type:'POST',
    url: url,
    data: {message:message},
    success:function(data){
      // alert(data);
      $("#input_messsage").val("");
      $("#messages").append(data);
      $(document).find("#messages li").each(function(){
        $(this).find('.message_info').hide();
      });
      $('#messages').scrollTop($('#messages')[0].scrollHeight);
    },
    error:function(){
      alert('error sending message');
    },
  });
});

$(document).on('click', '.delete_message', function() {
  var message_id = $(this).val();
  var conversation_id = $('input[name^="current_conversation_id"]').val();
  // alert(message_id);

  $.ajax({
  type:'DELETE',
  url: '/conversations/' + message_id + '/destroy',
  success:function(data){
      // alert(data);
      // window.location.replace("/conversations");
      
      // $(this).parent().parent().html(data);
      // $(this).parent().parent().remove();

      // $(document).find("#messages li").each(function(){
        // $(this).find('.message_info').hide();
      // });
      window.location.replace("/conversations?show="+conversation_id);
    },
    error:function(){
      alert('error deleting message');
    },
  });
});



// $(document).on('click', '.show_edit_conversation', function(e) {
//   e.preventDefault();
//   var url = $(this).attr("href");
//     //alert(url);

//     $.ajax({
//       type:'GET',
//       url: url,
//       success:function(data){
//         $("#show_tertiary").empty();
//         $("#show_tertiary").append(data);
//       },
//       error:function(){
//         alert('error showing edit conversation');
//       },
//     });
//   });


$(document).on('click', '.delete_conversation', function(e) {
// alert("delete_conversation");
e.preventDefault();
var url = $(this).attr("href");
    // alert(url);

    $.ajax({
      type:'DELETE',
      url: url,
      success:function(data){
          // alert(data);
          window.location.replace("/conversations");
        },
        error:function(){
          alert('error deleting conversation');
        },
      });
  });