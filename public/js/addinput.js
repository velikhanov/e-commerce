var i;
if($('#icount').length){
  i = $('#icount').val();;
}else{
  i = 0;
};
$("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="properties['+i+'][key]" class="form-control m-input ml-3" placeholder="Key" autocomplete="off">';
        html += '<input type="text" name="properties['+i+'][value]" class="form-control m-input ml-3" placeholder="Value" autocomplete="off">';
        html += '<div class="input-group-append ml-3">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Delete</button>';
        html += '</div>';
        html += '</div>';

        i++;

        $('#newRow').append(html);
    });
// remove row
$(document).on('click', '#removeRow', function () {
    $(this).closest('#inputFormRow').remove();
//     for (var i = 0; i< $('input[name=properties]').length; i++){
//       $('input[name=properties]').attr('name', 'properties['+i+'][key]');
//       $('input[name=properties]').attr('name', 'properties['+i+'][value]');
//
// });
    var i = 0;
    $(".input-group").each(function(i) {
      i++;
    $(this).find('input').attr('name', 'properties['+i+'][key]');
    $(this).find('input').attr('name', 'properties['+i+'][value]');
  });
});
    //
