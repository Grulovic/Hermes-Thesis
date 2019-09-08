$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.offer_add_list button', function(e) {

    var button = $(this);
    var url = $(this).parent().attr('action');

    var offer_id = $(this).parent().find(".offer_value").attr("value");

    // alert(url+"........"+offer_id);

    $.ajax({
        type:'POST',
        url: url,
        data: {offer_id:offer_id},
        success:function(){
        // alert("added to list");
          button.append('<i class="float-right pt-1 fas fa-check"></i>');
        },
        error:function(){
          alert('error puttin in list');
        },
      });
});

$(document).on('click', '.show_make_order', function(e) {
  e.preventDefault();
  var url = $(this).attr("href"); 
  $.ajax({
    type:'GET',
    url: url,
    success:function(data){
      $("#make_order").empty();
      $("#make_order").append(data);
    },
    error:function(){
      alert('error showing thread');
    },
  });
});

function show_range(current_range){
    $("#show_range").html("$" + current_range);
}


// $( "#slider-range" ).slider({
//   range: true,
//   min: 0,
//   max: 500,
//   values: [ 75, 300 ],
//   slide: function( event, ui ) {
//     $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
//   }
// });
// $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );

window.onload = function() {
  document.getElementById("search_offers").focus();
};

// $(document).on('click', 'input', function() {
//     $(this).prop('checked');       
// });

$(document).on('click', '#hide_offer_categories', function() {
    $(document).find("#categories").slideToggle(250);
});

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

    // $( "#offers_search" ).submit();

    
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

$(document).on('click', '#categories .list-group-item', function(e) {
    $('.far, .fas', this).toggleClass('far').toggleClass('fas');
});

function readURL(input) {
    if (input.files && input.files[0]) {
        $('.carousel-inner').empty();

        for (i = 0; i < input.files.length; i++) {
            var source = URL.createObjectURL(event.target.files[i]);

            if(i==0){
                $('.carousel-inner').append('<div class="carousel-item active" ><img class="d-block " src="' + source +'" style="max-height: 300px; margin-left: auto; margin-right: auto;"></div>');
            }else{
                $('.carousel-inner').append('<div class="carousel-item" ><img class="d-block " src="' + source +'" style="max-height: 300px; margin-left: auto; margin-right: auto;"></div>');
            }
        }
    }
}

$("#offer_image").change(function(){
    $("#upload_images").empty();
    readURL(this);
    var upload_images = this.files;

    for(var i=0; i< this.files.length; i++){
        var file = this.files[i];

        $("#upload_images").append('<div class="upload_image card m-2 p-1 bg-light"><div class="text-left"><i class="fas fa-file-image float-left mt-1 mr-2"></i>' + file.name +'</div></div>');
    }

    $("#upload_images").show();
});


$("#upload_images").hide();



$('input , textarea').keyup(function() {
    var input = $(this).val();
    var input_name = $(this).attr("name");

    // alert(input + " " + input_name);

    if(input==""){
        $("#offer_preview_"+input_name).html("Offer Preview " + input_name);
    }else{
        $("#offer_preview_"+input_name).html(input);    
    }

});

$( "select" ).change(function() {
    var input = $(this).children("option:selected").html();
    var input_name = $(this).attr("name");

    // alert(input + " " + input_name);

    if(input==""){
        $("#offer_preview_"+input_name).html("Offer Preview " + input_name);
    }else{
        $("#offer_preview_"+input_name).html(input);    
    }
});

// $('.offer_description').hide();


// $(".offer_image_description").hover(
//     function() {
//         $(this).find(".offer_image").hide();
//         $(this).find(".offer_description").show();
//         $(this).toggleClass('bg-light');
//     }, function() {
//         $(this).find(".offer_description").hide();
//         $(this).find(".offer_image").show();
//         $(this).toggleClass('bg-light');
//     }
//     );

$(document).on('click', '#show_all_offers', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $("#show_user_offers").addClass('active');
    $("#show_offers").addClass('active');

    $(this).find("input").prop("checked", true);
    $( "#offers_search" ).submit();

    // $("#offers .user_offer").show();
    // $("#offers .offer").show();
});

$(document).on('click', '#show_offers', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $("#show_user_offers").addClass('active');
    $("#show_all_offers").addClass('active');
    
    $(this).find("input").prop("checked", true);
    $( "#offers_search" ).submit();

    // $("#offers .user_offer").hide();
    // $("#offers .offer").show();
});

$(document).on('click', '#show_user_offers', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $("#show_all_offers").addClass('active');
    $("#show_offers").addClass('active');
    
    $(this).find("input").prop("checked", true);
    $( "#offers_search" ).submit();

    // $("#offers .offer").hide();
    // $("#offers .user_offer").show();
});





// $("#search_offers").keyup(function() {
    
//     var name = $('#search_offers').val();
    
//     var categories = [];
//     $(document).find("#categories input:checked").each(function(){
//         // alert(this.getAttribute("value"));
//         categories.push(this.getAttribute("value"));
//     });
//     console.log(categories);

//     $.ajax({
//         type: "POST",
//         url: '/offers/search',
//         data: {name: name, categories:categories},
//         success: function(results) {
//             //$("#offers").html("");
//             $("#offers").empty();
//             $("#offers").html(results);  
//             $(document).find(".offer_description").hide();
//             $(document).find(".offer_add_buttons").hide();
//         },
//         error:function(){
//             alert('error searching');
//         },
//     });
// });