function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $($.parseHTML('<img>')).addClass('ml-3 imgPrev').attr('src', e.target.result).appendTo('.preview');
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$('.removeImgBtn').on('click', function(e) {
  e.preventDefault();
  $(this).hide();
  $(this).children('input').val($(this).children('div').text());
});

$("input[type=file]").change(function() {
  $('.imgPrev').remove();
  readURL(this);
});
