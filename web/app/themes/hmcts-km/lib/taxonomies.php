<?php

/**
 * Configure post taxonomies across the site.
 */
namespace Roots\Sage\Comments;

/**
 * Unregister category and tag taxonomies.
 */
function unregister_categories_and_tags()
{
    register_taxonomy('category', []);
    register_taxonomy('post_tag', []);
}
add_action('init', __NAMESPACE__ . '\\unregister_categories_and_tags');
