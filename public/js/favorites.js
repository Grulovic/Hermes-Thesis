$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).find(".remove_favorite").hide();

$(".favorite").hover(function() {
    $(this).find(".remove_favorite").show();
  }, function() {
    $(this).find(".remove_favorite").hide();
  }
);


