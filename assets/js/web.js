function emailClick(email) {
    $('#emailInput').html('<input type="email" class="form-control" value="'+email+'" name="emailClick" required />');
    $('#emailClick').replaceWith('<input type="submit" class="btn btn-primary" style="width: 100%;margin-top: 5px;" value="Mainīt" />');
}

$(document).ready(function(){
    $('#site > form').on('change', '#banner', function(e){
        e.preventDefault();
        var myParent = $(this).parent();
        var filname= $('input[type=file]').val()
        if(filname){         
            $('.form').ajaxSubmit({
                beforeSubmit: function(){
                    $('.progress-bar').width('0%');
                },
                uploadProgress: function(event, position, total, percentComplete){
                    $('.progress').show();
                    $('.progress-bar').width(percentComplete+'%');
                    $('.progress-bar').html(percentComplete+'%');
                },
                success: function showResponse(responseText, statusText, xhr, $form){},
                resetForm: false
            });
        }
        return false;
    });
});
