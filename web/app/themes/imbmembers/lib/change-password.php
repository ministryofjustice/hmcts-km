<?php

namespace Roots\Sage\ChangePassword;

use \WP_Query;

/**
 * Get the 'Change Password' page
 * This is determined as the page which uses the 'change-password.php' template.
 *
 * @return \WP_Post
 */
function get_page()
{
    $query = new WP_Query([
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'change-password.php',
        'posts_per_page' => 1,
    ]);
    return $query->post;
}

/**
 * Check if this request should process a form submission.
 * If so, pass data on to the process_form() method.
 */
function handle_form_submit()
{
    global $form;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $post_type = get_post_type();
    $template = get_post_meta(get_the_ID(), '_wp_page_template', true);

    if ($post_type == 'page' && $template == 'change-password.php') {
        $form = process_form($_POST);
    }
}
add_action('template_redirect', __NAMESPACE__ . '\\handle_form_submit');

/**
 * Validate and process the 'change password' form data.
 *
 * @param array $data Submitted form data
 * @return array Results of the password change in the format:
 *               ['success' => (bool), 'errors' => ['field_name' => 'Error message']]
 */
function process_form($data)
{
    $success = true;
    $errors = [];

    $user = wp_get_current_user();

    if (!wp_verify_nonce($data['password_nonce'], 'change-password')) {
        $success = false;
    }

    if (!wp_check_password($data['password'], $user->user_pass)) {
        $success = false;
        $errors['password'] = 'Incorrect password. Please try again.';
        $errors['password'] .= sprintf('<p>If you\'ve forgotten your password, you can <a href="%s">reset it here</a>.</p>', wp_lostpassword_url());
    }

    if (mb_strlen($data['new_password']) < 1) {
        $success = false;
        $errors['new_password'] = 'This cannot be empty';
    }

    if ($success) {
        // Update user password
        wp_set_password($data['new_password'], $user->ID);

        // Reauthenticate the user
        wp_set_auth_cookie($user->ID);
        wp_set_current_user($user->ID);
        do_action('wp_login', $user->user_login, $user);
    }

    return compact('success', 'errors');
}
