$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$( document ).ready(function() {

    $(document).find('#orders').css('height',window.innerHeight-320);
    $(document).find('#requests').css('height',window.innerHeight-320);
    $(document).find('#threads').css('height',window.innerHeight-320);
    $(document).find('#conversations').css('height',window.innerHeight-320);
    $(document).find('#replies').css('height',window.innerHeight-320);
    $(document).find('#offers').css('height',window.innerHeight-118);
    $(document).find('#users').css('height',window.innerHeight-118);
    $(document).find('#replies').css('height',window.innerHeight-440);
    $(document).find('#welcome_image').css('height',window.innerHeight-60);
    $(document).find('#pdf').html('height',window.innerHeight-200);

    // $(document).find('#customers_chart').parent().css('height',window.innerHeight-200);
    // $(document).find('#customers_chart').css('height',window.innerHeight-200);
    
    // $(document).find('#offers_chart').parent().css('height',window.innerHeight-938);
    // $(document).find('#offers_chart').css('height',window.innerHeight-938);
    
    // $(document).find('#months_chart').parent().css('height',window.innerHeight-938);
    // $(document).find('#months_chart').css('height',window.innerHeight-938);
    
    // $(document).find('#myChart').parent().css('height',window.innerHeight-200);
    // $(document).find('#myChart').css('height',window.innerHeight-200);
    
});

var manually_hidden = false;
$("#menu-toggle").click(function(e) {
      // $(document).on('click', '#messages li', function(e) {
      // e.preventDefault();
      // alert("here");
      $("#wrapper").toggleClass("toggled");
      // $("#sidebar-wrapper").slideToggle();
      manually_hidden = !manually_hidden;
    });

$('.navigation a').each(function(i, obj) {
  if(window.location.href.indexOf($(obj).attr("href")) > -1 ) {
    $(obj).addClass("active").addClass("navigation-active").removeClass("bg-light").addClass("hermes-grad");  
  }
});

$(".navigation a").hover(function() {
  $(this).addClass("navigation-active");

}, function() {
  if(!$(this).hasClass("active")){
    $(this).removeClass("navigation-active");        
  }
});

$(document).on('click', '.add_friend', function(e) {
  var user_id = $(this).val();

  $.ajax({
    type:'POST',
    url: '/friends',
    data: {user_id:user_id},
    success:function(data){

    },
    error:function(){
      alert('error sending friend request');
    },
  });

});


    // $(document).find('[data-toggle="tooltip"]').tooltip({ placement: 'top' });   


    // if( $( window ).width() > 600) {
    //   $(window).scroll(function () {
    //     if(!manually_hidden){
    //       //alert("Scroll top: " + $(window).scrollTop() + ", Body height: " + $('#hide_menu').offset().top );
    //       if ($(window).scrollTop() < $('#hide_menu').offset().top) {
    //         //alert($(window).scrollTop() + "<" + $('#hide_menu').offset().top );
    //         $("#wrapper").removeClass("toggled");        
    //       }
    //       if ($(window).scrollTop() > $('#hide_menu').offset().top) {
    //         //alert($(window).scrollTop() + ">" + $('#hide_menu').offset().top );
    //         $("#wrapper").addClass("toggled");  
    //       }
    //     }
    //   });

    // }
     // $('.dropdown-menu option, .dropdown-menu select, .dropdown-menu button delete_cart_item').click(function(e) {
     //    event.stopPropagation();
     //  });








$(document).on('click', '.add_offer_to_favorites', function(e) {
  // alert("deleting list");

  e.preventDefault();
  var button = $(this);
  var item_id = $(this).val();
  var type = 'offer';

  
  $.ajax({
    type:'POST',
    url: '/favorites',
    data:{ item_id:item_id, type:type },
    success:function(data){
      
      button.toggleClass("btn-primary").toggleClass("btn-danger");
          // window.location.replace("/favorites");
        },
        error:function(){
          alert('error adding offer to favorite');
        },
      });
});

     $(document).on('click', '.add_user_to_favorites', function(e) {
  // alert("deleting list");

  e.preventDefault();
  var button = $(this);

  var item_id = $(this).val();
  var type = 'page';

  $.ajax({
    type:'POST',
    url: '/favorites',
    data:{ item_id:item_id, type:type },
    success:function(data){
      button.toggleClass("btn-warning").toggleClass("btn-danger");

      // $(this).toggleClass("btn-primary").toggleClass("btn-danger");
          // window.location.replace("/favorites");
        },
        error:function(){
          alert('error adding user to favorite');
        },
      });
});
      
$(document).on('click', '.add_thread_to_favorites', function(e) {
  // alert("deleting list");

  e.preventDefault();
  var button = $(this);

  var item_id = $(this).val();
  var type = 'thread';

  $.ajax({
    type:'POST',
    url: '/favorites',
    data:{ item_id:item_id, type:type },
    success:function(data){

      button.toggleClass("btn-warning").toggleClass("btn-danger");
          // window.location.replace("/favorites");
        },
        error:function(){
          alert('error adding thread to favorite');
        },
      });
});


$(document).on('click', '.message_user', function(e) {

  e.preventDefault();
  var url = $(this).attr("href");

  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      window.location.replace("/conversations?show="+data);
    },
    error:function(){
      alert('error messaging message');
    },
  });
});

$(document).on('click', '.remove_favorite', function(e) {
  // alert("deleting list");

  e.preventDefault();
  var favorite_id = $(this).val();

  $.ajax({
    type:'DELETE',
    url: '/favorites/'+favorite_id,
    success:function(data){
          // $(this).parent().remove();
          window.location.replace("/favorites");
        },
        error:function(){
          alert('error deleting favorite');
        },
      });
});


$(document).find(".offer_add_buttons").hide();
$(document).find(".offer_description").hide();

$(document).find(".offer, .user_offer").hover(function() {

    $(this).find(".offer_add_buttons").show();
    $(this).find(".offer_header").hide();

    $(this).find(".offer_description").show();

  }, function() {
    $(this).find(".offer_add_buttons").hide();
    $(this).find(".offer_header").show();

    $(this).find(".offer_description").hide();

  }
);

$(document).find(".offer_image_description").hover(
    function() {
        $(this).find(".offer_description").show();
    }, function() {
        $(this).find(".offer_description").hide();
    }
);
