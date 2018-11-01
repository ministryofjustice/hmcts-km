<?php

/**
 * Disable commenting functionality across the site.
 *
 * To display comments form on page:
 *   comments_template('/templates/comments.php');
 */
namespace Roots\Sage\Comments;

/**
 * Remove 'Comments' from the admin menu
 */
function admin_menu_remove_comments()
{
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', __NAMESPACE__ . '\\admin_menu_remove_comments');

/**
 * Remove comments support for 'post' and 'page' post types.
 */
function init_remove_comments()
{
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}
add_action('init', __NAMESPACE__ . '\\init_remove_comments', 100);

/**
 * Remove comments from the admin bar
 */
function admin_bar_remove_comments()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', __NAMESPACE__ . '\\admin_bar_remove_comments');

/**
 * Disable comments and pingbacks for all posts
 */
add_filter('comments_open', '__return_false');
add_filter('pings_open', '__return_false');

/**
 * Remove comments and discussion meta boxes from the editor interface
 */
function remove_comments_meta_boxes()
{
    remove_meta_box('commentstatusdiv', 'post', 'normal');
    remove_meta_box('commentsdiv', 'post', 'normal');
}
add_action('admin_menu', __NAMESPACE__ . '\\remove_comments_meta_boxes');
