<?php

/**
 * Editor User Role
 *
 * Remove capabilities from Editor.
 *
 * Call the function when your plugin/theme is activated.
 */

function editor_set_capabilities() {
	// Get the role object.
	$editor = get_role( 'editor' );
	// A list of capabilities to remove from editors.
	$caps = array(
		'manage_categories',
		'moderate_comments',
		'delete_posts',
		'edit_others_posts',
		'edit_posts',
		'publish_posts',
		'publish_pages',
	);

	foreach ( $caps as $cap ) {
		// Remove the capability.
		$editor->add_cap( $cap );
	}
}
add_action( 'init', 'editor_set_capabilities' );
