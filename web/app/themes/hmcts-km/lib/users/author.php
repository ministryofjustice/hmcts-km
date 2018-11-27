<?php

/**
 * Author User Role
 *
 * Remove capabilities from Author.
 *
 * Call the function when your plugin/theme is activated.
 */

function author_set_capabilities()
{
    // Get the role object.
    $author = get_role('author');
    // A list of capabilities to remove from editors.
    $caps = array(
        'publish_posts',
        'publish_pages',
    );

    foreach ($caps as $cap) {
        // Remove the capability.
        $author->remove_cap($cap);
    }
}
add_action('init', 'author_set_capabilities');
