jQuery(document).ready(function($){
    $('#eiserContactForm').on('submit', function(e){
        e.preventDefault();

        $('.alert').removeClass('alert');
        $('.alert-danger').removeClass('alert-danger');

        var form = $(this),
        name = form.find('#name').val(),
        email = form.find('#email').val(),
        message = form.find('#message').val(),
        ajaxurl = form.data('url');

        if( message === '' ){
            $('#message').parent('.form-group').addClass('alert alert-danger');
            return;
        }
        if( name === '' ){
            $('#name').parent('.form-group').addClass('alert alert-danger');
            return;
        }
        if( email === '' ){
            $('#email').parent('.form-group').addClass('alert alert-danger');
            return;
        }
        form.find('input, textarea, button').attr('disabled','disabled');
        $('.js-form-submission').addClass('js-show-feedback');

        $.ajax({
            url : ajaxurl,
            type : 'post',
            data : {
                name : name,
                email : email,
                message : message,
                action : 'eiser_save_user_contact_form',
            },
            error : function( response ){
                $('.js-form-submission').removeClass('js-show-feedback');
                $('.js-form-error').addClass('js-show-feedback');
                form.find('input, textarea, button').removeAttr('disabled');
            },
            success : function( response ){
                if(response == 0){
                    setTimeout(function(){
                        $('.js-form-submission').removeClass('js-show-feedback');
                        $('.js-form-error').addClass('js-show-feedback');
                        form.find('input, textarea, button').removeAttr('disabled');
                    }, 2000);
                }else{
                    setTimeout(function(){
                        $('.js-form-submission').removeClass('js-show-feedback');
                        $('.js-form-success').addClass('js-show-feedback');
                        form.find('input, textarea, button').removeAttr('disabled').val('');
                    }, 2000);
                    
                }
            }
        })
        //console.log("Form Submited");
    });
});