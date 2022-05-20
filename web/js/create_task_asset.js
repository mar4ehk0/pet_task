$(document).ready(function()
{
    $('#createtaskform-is_remote').on('change', function() {
        if (this.checked) {
            $('.field-createtaskform-location').hide();
        } else {
            $('.field-createtaskform-location').show();
        }
    });
    $('#createtaskform-files').on('change',function(){
        let fileName = $(this).val();
        fileName = fileName.replace(/C:\\fakepath\\/, '');
        $(this).next('.custom-file-label').html(fileName);
    })
});