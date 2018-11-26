<?php
function validemail_enqueue($hook) {
    // Only add to the user-new.php admin page
    if ('user-new.php' !== $hook) {
        return;
    }
    wp_enqueue_script('valid_email', get_template_directory_uri(__FILE__) . '/assets/scripts/validemail.js', '', '', 'true');
}

add_action('admin_enqueue_scripts', 'validemail_enqueue');
