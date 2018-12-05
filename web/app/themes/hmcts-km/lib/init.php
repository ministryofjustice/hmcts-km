<?php

namespace Roots\Sage\Init;

use Roots\Sage\Assets;
use Roots\Sage\Users\UserRoles;

/**
 * Theme setup
 */
function setup()
{
  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
    load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'quick_links' => __('Quick Links', 'sage')
    ]);

  // Add post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');
    add_image_size('thumbnail', 200, 200, true);
    add_image_size('thumbnail-2x', 400, 400, true);

  // Add HTML5 markup for captions
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list']);

  // Tell the TinyMCE editor to use a custom stylesheet
    add_editor_style(Assets\asset_path('styles/editor-style.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');
