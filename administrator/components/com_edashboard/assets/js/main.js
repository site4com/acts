/**
 * Created by Cuong Nguyen on 10/5/2015.
 */

jQuery(document).ready(function ($){
    jQuery('#attrib-attachments').append('<a href="javascript:void(0);" id="addCF">Add</a>');
    jQuery('#addCF').click(function() {
        var html = '<div class="control-group">' +
                        '<div class="contol-label">' +
                        '</div>' +
                        '<div class="controls">' +
                            '<input type="file" name="jform[filenames][]" id="jform_filenames" aria-invalid="false">' +
                            '<a href="javascript:void(0);" class="remCF">Delete</a>' +
                        '</div>' +
                    '</div>';
        jQuery('#addCF').before(html);
    });
    $("#attrib-attachments").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });;
});
