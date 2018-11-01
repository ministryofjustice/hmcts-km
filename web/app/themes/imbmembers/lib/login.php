<?php

/**
 * Tweaks to wp-login pages
 */
namespace Roots\Sage\Login;

use Roots\Sage\Utils;

/**
 * Custom scripts and styles for login pages
 */
function login_head()
{
    ?>
  <style>
    /* Login header logo */
    #login h1 a, .login h1 a {
      text-indent: 0;
      background-image: none;
      width: auto;
      height: auto;
      color: #000;
      font-weight: bold;
    }

    /* Hide 'back to blog' link */
    #backtoblog {
      display: none;
    }
  </style>

  <script>
    jQuery(document).ready(function($) {
      // Set 'email' text input type to 'email'
      var user_login = $('#user_login');
      if (user_login.length > 0 && user_login.attr('type') == 'text') {
        user_login.attr('type', 'email');
        user_login.parents('form').attr('novalidate', true);
      }
    });
  </script>
    <?php
}
add_action('login_head', __NAMESPACE__ . '\\login_head');

/**
 * Add jQuery to login pages
 */
function enqueue_jquery()
{
    wp_enqueue_script('jquery');
}
add_action('login_enqueue_scripts', __NAMESPACE__ . '\\enqueue_jquery');

/**
 * Rename form fields
 * This is done to replace references to 'username' with 'email address'.
 */
function login_form()
{
    add_filter('gettext', __NAMESPACE__ . '\\login_form_gettext', 20, 3);
}
add_action('login_form_login', __NAMESPACE__ . '\\login_form');
add_action('login_form_register', __NAMESPACE__ . '\\login_form');
add_action('login_form_lostpassword', __NAMESPACE__ . '\\login_form');
add_action('login_form_retrievepassword', __NAMESPACE__ . '\\login_form');

function login_form_gettext($translated_text, $text, $domain)
{
    switch ($translated_text) {
        case 'Email':
            $translated_text = 'Email Address';
            break;

        case 'Username or Email':
            $translated_text = 'Email Address';
            break;

        case '<strong>ERROR</strong>: Enter a username or email address.':
            $translated_text = '<strong>ERROR</strong>: Enter an email address.';
            break;

        case 'Please enter your username or email address. You will receive a link to create a new password via email.':
            $translated_text = 'Please enter your email address. You will receive a link to create a new password via email.';
            break;
    }

    return $translated_text;
}

/**
 * Change the header link.
 *
 * @return string|void
 */
function login_header_link()
{
    return home_url();
}
add_filter('login_headerurl', __NAMESPACE__ . '\\login_header_link');

function login_header_link_title()
{
    return '';
}
add_filter('login_headertitle', __NAMESPACE__ . '\\login_header_link_title');

/**
 * Require users to be logged in before seeing the site
 * Redirect to login screen if they're not authenticated
 */
function require_login()
{
    if (is_login_required() && !is_user_logged_in()) {
        $redirectAfterLogin = $_SERVER['REQUEST_URI'];
        $redirectTo = wp_login_url($redirectAfterLogin);
        header('Location: ' . $redirectTo);
        exit();
    }
}
add_action('init', __NAMESPACE__ . '\\require_login');

/**
 * Should the user be authenticated to see this page?
 *
 * @return boolean
 */
function is_login_required()
{
    return !(Utils\is_wp_cli() || is_login_page());
}

/**
 * Convenience method to determine if we're on a login page.
 *
 * @return bool
 */
function is_login_page()
{
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}
