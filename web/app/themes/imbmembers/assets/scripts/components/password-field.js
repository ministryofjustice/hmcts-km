(function($) {
  $('.password-field').each(function(i, el) {
    var showTrigger = $('<span title="Show password" aria-label="Show password" class="trigger add-on input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-eye-open"></i></span>');
    var hideTrigger = $('<span title="Hide password" aria-label="Hide password" class="trigger add-on input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-eye-close"></i></span>');

    var input = $(el).find('input');
    $(el).append(showTrigger);

    $(el).on('click', '.trigger', function(e) {
      e.preventDefault();
      var trigger = function() { return $(el).find('.trigger'); };

      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        trigger().replaceWith(hideTrigger);
      }
      else {
        input.attr('type', 'password');
        trigger().replaceWith(showTrigger);
      }

      trigger().focus();
    });

    // Reset input to type 'password' on form submit
    $(el).parents('form').on('submit', function(e) {
      input.attr('type', 'password');
    });
  });
})(jQuery);
