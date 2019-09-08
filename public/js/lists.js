$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).on('click', '.delete_list', function(e) {
  // alert("deleting list");

  e.preventDefault();
  var list_id = $(this).val();

  $.ajax({
    type:'DELETE',
    url: '/lists/'+list_id,
    success:function(data){
          // $(this).parent().remove();
          window.location.replace("/lists");
        },
        error:function(){
          alert('error deleting list');
        },
      });
});

$(document).on('click', '.show_list', function(e) {
  var list_id = $(this).val();

  $.ajax({
    type:'GET',
    url: '/lists/'+list_id,
    success:function(data){
      $("#show_tertiary").empty();
      $("#show_page").empty();
      $("#show_page").append(data);
    },
    error:function(){
      // alert('error showing list');
    },
  });
});

// $(document).on('click', '#create_list', function(e) {
//   $.ajax({
//     type:'GET',
//     url: '/lists/create',
//     success:function(data){
//       $("#show_tertiary").empty();
//       $("#show_tertiary").append(data);
//     },
//     error:function(){
//       alert('error showing creating list');
//     },
//   });
// });

$(document).on('click', '.delete_list_item', function(e) {
  // alert("deleting item");
  e.preventDefault();
  var url = $(this).val();
  var list_id = $('input[name^="list_id"]').val();

  // alert(list_id);
  // alert(url);

  // $.ajax({
  //   type:'DELETE',
  //   // url: '/lists/'+item_id+'/item',
  //   url: url,
  //   success:function(data){
  //         // $(this).parent().remove();
  //         window.location.replace("/lists/"+list_id);
  //       },
  //       error:function(){
  //         alert('error deleting list item');
  //       },
  //     });
});