$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (let i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    let html;
                    html = '<a class="removeImgBtn" href="#">';
                        html += '<img class="imgPrev" src="'+event.target.result+'" alt="Preview images">';
                        html += '<span>Click to delete</span>';
                        html += '<input type="hidden" name="img_index" value="'+input.files[i].name+'">'
                    html += '</a>';
                    $(html).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    function removeFile(fileName){
        var attachments = document.getElementById("prodimg").files; // <-- reference your file input here
        var fileBuffer = new DataTransfer();
        // append the file list to an array iteratively
        for (let i = 0; i < attachments.length; i++) {
            // Exclude file in specified index
            if (fileName != attachments[i].name){
                fileBuffer.items.add(attachments[i]);
                // console.log(attachments[i]);
            }
        }
        
        // Assign buffer to file input
        document.getElementById("prodimg").files = fileBuffer.files; // <-- according to your file input reference
    }

    $('input[type=file]').on('change', function() {
        $('.imgPrev').remove();
        imagesPreview(this, 'div.preview');
    });

    $("body").delegate(".removeImgBtn", "click", function (e) {
        e.preventDefault();
        $(this).hide();
        let deleted_el = $(this).children('input[name="img_index"]').val();
        removeFile(deleted_el);
        $(this).children('.imgfordel').val($(this).children('div').text());
    });

});
