(function($){

  var email = $("#email");

  email.click(function() {

    email.focusout( function() {
      var users_email = $(this).val();
      var domain = users_email.substring(users_email.lastIndexOf("@") +1);
      var submit_button = $('#createusersub');

      var whitelist = [
        'hmcts.net',
        'justice.gov.uk',
        'digital.justice.gov.uk',
      ];

      if( jQuery.inArray(domain, whitelist) != '-1'){

        submit_button.attr('disabled', false);
        $('.error').remove();
        return false;

      }else{

        submit_button.attr('disabled', true);
        $('.wrap').prepend('<div class="error"><p><strong>ERROR</strong>: Not a valid email address</p></div>');
        return false;
        
      }

    });

  });


})(jQuery);
