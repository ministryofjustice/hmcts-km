<?php

/**
 * Editor User Role
 *
 * Remove capabilities from Editor.
 *
 * Call the function when your plugin/theme is activated.
 */

function editor_set_capabilities()
{
    // Get the role object.
    $editor = get_role('editor');
    // A list of capabilities to remove from editors.
    $caps = array(
        'manage_categories',
        'moderate_comments',
        'delete_posts',
        'edit_others_posts',
        'edit_posts',
        'publish_posts',
        'publish_pages',
        'delete_users',
        'create_users',
        'edit_users',
        'remove_users',
        'add_users',
        'promote_users',
        'list_users',
    );

    foreach ($caps as $cap) {
        // Remove the capability.
        $editor->add_cap($cap);
    }
}
add_action('init', 'editor_set_capabilities');

// Allow editors to only see appearance menu
$role_object = get_role('editor');
$role_object->add_cap('edit_theme_options');

function hide_menu()
{

    // Hide theme selection page
    remove_submenu_page('themes.php', 'themes.php');

    // Hide widgets page
    remove_submenu_page('themes.php', 'widgets.php');

    // Hide customize page
    global $submenu;
    unset($submenu['themes.php'][6]);
}

add_action('admin_head', 'hide_menu');
