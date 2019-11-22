<?php

/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
	'lib/assets.php',                // Scripts and stylesheets
  'lib/change-password.php',       // Frontend 'change password' functionality
	'lib/comments.php',              // Disable comments and pingbacks
	'lib/conditional-tag-check.php', // ConditionalTagCheck class
	'lib/config.php',                // Configuration
	'lib/emails.php',                // Restricts certain email domain registration
	'lib/extras.php',                // Custom functions
	'lib/gallery.php',               // Custom [gallery] modifications
	'lib/init.php',                  // Initial theme setup and constants
	'lib/login.php',                 // Changes to login functionality
	'lib/nav.php',                   // Custom nav modifications
	'lib/Nav/Walkers/ButtonNavWalker.php', // Button Nav Walker class
	'lib/Nav/Walkers/TreeNavWalker.php', // Tree Nav Walker class
	'lib/customer-guidance-metabox.php',        // Metabox to display internal notes for customer guidance
	'lib/security.php',
	'lib/taxonomies.php',            // Configure post taxonomies
	'lib/titles.php',                // Page titles
  'lib/uploads.php',               // Added to extend allowed file types in Media upload
	'lib/users/author.php',          // Custom User Role Settings
	'lib/users/editor.php',          // Custom User Role Settings
  'lib/utils.php',                 // Utility functions
	'lib/wrapper.php',               // Theme wrapper class
	'lib/welsh-metabox.php'          // Extra Metabox
];

foreach ( $sage_includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'sage' ), $file ), E_USER_ERROR );
	}

	require_once $filepath;
}
unset( $file, $filepath );
