      


$("#search_forum_category input" ).click(function() {
  var search = $('#thread_search').val();
  var categories = [];

  
  $('#search_forum_category input:checked').each(function(){
    categories.push($(this).val());
  });

  $.ajax({
    type: "POST",
    url: '/forum/search',
    data: {search: search, categories:categories},
    success: function(results) {
      $("#threads").empty();  
      $("#threads").html(results);  
    }
  });
});

$(document).on('keyup', '#thread_search', function(e) {
  var search = $('#thread_search').val();

  $.ajax({
    type: "POST",
    url: '/forum/search',
    data: {search: search},
    success: function(results) {
      $("#threads").empty();  
      $("#threads").html(results);  
    }
  });
});


// $(".user_thread").hide();

// $(document).on('click', '#show_user_threads', function(e) {
//   $('#show_all_threads').addClass('active');
//   $('#show_threads').addClass('active');
//   $('#show_user_threads').removeClass('active');

//   $("#show_page").empty();
//   $("#show_tertiary").empty();
//   $(".user_thread").show();
//   $(".thread").hide();  
// });

// $(document).on('click', '#show_all_threads', function(e) {
//   $('#show_all_threads').removeClass('active');
//   $('#show_threads').addClass('active');
//   $('#show_user_threads').addClass('active');

//   $("#show_page").empty();
//   $("#show_tertiary").empty();
//   $(".user_thread").show();
//   $(".thread").show();
// });

// $(document).on('click', '#show_threads', function(e) {
//   $('#show_all_threads').addClass('active');
//   $('#show_threads').removeClass('active');
//   $('#show_user_threads').addClass('active');

//   $("#show_page").empty();
//   $("#show_tertiary").empty();
//   $(".user_thread").hide();
//   $(".thread").show();
// });

$(document).on('click', '#show_all_threads', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $("#show_user_threads").addClass('active');
    $("#show_threads").addClass('active');

    $(this).find("input").prop("checked", true);
    $( "#threads_search" ).submit();

    // $("#threads .user_offer").show();
    // $("#threads .offer").show();
});

$(document).on('click', '#show_threads', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $("#show_user_threads").addClass('active');
    $("#show_all_threads").addClass('active');
    
    $(this).find("input").prop("checked", true);
    $( "#threads_search" ).submit();

    // $("#threads .user_offer").hide();
    // $("#threads .offer").show();
});

$(document).on('click', '#show_user_threads', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $("#show_all_threads").addClass('active');
    $("#show_threads").addClass('active');
    
    $(this).find("input").prop("checked", true);
    $( "#threads_search" ).submit();

    // $("#threads .offer").hide();
    // $("#threads .user_offer").show();
});


$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).on('click', '#threads .show_thread', function(e) {
  //alert("show thread");
  e.preventDefault();
  var url = $(this).attr("href");
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      $("#show_page").empty();
      // $("#show_tertiary").empty();
      $("#show_page").append(data);
      $(document).find('#replies').css('height',window.innerHeight-440);
    },
    error:function(){
      alert('error showing thread');
    },
  });
});

$(document).on('click', '.create_new_thread', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      $("#show_tertiary").empty();
      $("#show_page").empty();
      $("#show_page").append(data);
    },
    error:function(){
      alert('error showing create new thread');
    },
  });
});

// $(document).on('click', '.show_edit_thread', function(e) {
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


$(document).on('click', '#create_thread', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");
  var name = $('input[name^="name"]').val();
  var category_id = $('select[name^="category_id"]').val();
  var description = $('textarea[name^="description"]').val();
  
  // alert(name);

  $.ajax({
    type:'POST',
    url: url,
    data: {name:name, category_id:category_id, description:description},
    success:function(data){
      window.location.replace("/forum?show="+data);
    },
    error:function(){
      alert('error creating thread');
    },
  });
});


//variable latest diplayed message is on show right before it is presented
function getLatestReply(e) {
  //e.preventDefault();
  // alert("here");
  var url = $("#get_thread_url").attr("value");
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      // alert(data.reply_id + ">" + latest_displayed_reply);
      if(data.reply_id > latest_displayed_reply){
        $(document).find("#replies").append(data.reply_html);
        latest_displayed_reply = data.reply_id;
          // alert(data.reply_id + "=" + latest_displayed_reply);
        }        
      },
      error:function(){
        // alert('error getting message');
      },
    });
}
setInterval(getLatestReply, 1000);



$(document).on('click', '#send_reply', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");
  var text = $('input[name^="text"]').val();
  
  $.ajax({
    type:'POST',
    url: url,
    data: {text:text},
    success:function(data){
        getLatestReply(e);
        $("#input_messsage").val("");
          //$("#replies").append(data);
          //window.location.replace("/forum");
        },
        error:function(){
          alert('error sending reply');
        },
      });
});

$(document).on('click', '#delete_reply', function(e) {
  e.preventDefault();
  var url = $(this).attr("href");
  var button = this;
  $.ajax({
    type:'DELETE',
    url: url,
    success:function(data){
          // $(this).parent().parent().remove();
          $(button).parent().parent().parent().remove();
          //window.location.replace("/forum");
        },
        error:function(){
          alert('error deleting reply');
        },
      });
});

$(document).on('click', '#delete_thread', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");
  $.ajax({
    type:'DELETE',
    url: url,
    success:function(data){
      window.location.replace("/forum");
    },
    error:function(){
      alert('error deleting reply');
    },
  });
});

$(document).on('click', '#update_thread', function(e) {
  e.preventDefault();
  var url = $(this).attr("value");
  var name = $('input[name^="name"]').val();
  var category_id = $('select[name^="category_id"]').val();
  var description = $('textarea[name^="description"]').val();
  var thread_id = $("#current_thread_id").val();
  
  // alert(url+" "+name+" "+category_id+" "+description);

  $.ajax({
    type:'PATCH',
    url: url,
    data: {name:name, category_id:category_id, description:description},
    success:function(data){        
      window.location.replace("/forum?show="+thread_id);
    },
    error:function(){
      alert('error updating thread');
    },
  });
});

// $(document).on('click', '.user', function(e) {
//   // alert("show user");
//   e.preventDefault();
//   var url = $(this).attr("href");
//   $.ajax({
//     type:'GET',
//     url: url,
//     success:function(data){
//       $("#show_user").empty();
//       $("#show_user").append(data);
//     },
//     error:function(){
//       alert('error showing thread');
//     },
//   });
// });
$("#categories").hide();


$(document).on('click', '#show_categories', function(e) {
    // e.preventDefault();
    // $("#offer_categories").toggle();
    $("#categories").removeClass('d-none');
    $("#categories").slideToggle(250);
});



function check_category(checkbox, value){
    // alert(value);
    $(checkbox).prop('checked');    

    $( "#threads_search" ).submit();
    // // alert(checkbox.getAttribute("value"));

    // // $(checkbox).parent().next().find("input").hide();

    // var name = $('#search_offers').val();
    
    // var categories = [];
    // $(document).find("#categories input:checked").each(function(){
    //     // alert(this.getAttribute("value"));
    //     categories.push(this.getAttribute("value"));
    // });
    // console.log(categories);

    // $.ajax({
    //     type: "POST",
    //     url: '/offers/search',
    //     data: {name: name, categories:categories},
    //     success: function(results) {
    //         //$("#offers").html("");
    //         $("#offers").empty();
    //         $("#offers").html(results);  
    //         $(document).find(".offer_description").hide();
    //     },
    //     error:function(){
    //         alert('error searching');
    //     },
    // });
}