<?php

namespace Roots\Sage\Utils;

use DateTime;

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function get_search_form() {
	$form = '';
	locate_template( '/templates/searchform.php', true, false );
	return $form;
}
add_filter( 'get_search_form', __NAMESPACE__ . '\\get_search_form' );

/**
 * Make a URL relative
 */
function root_relative_url( $input ) {
	preg_match( '|https?://([^/]+)(/.*)|i', $input, $matches );
	if ( ! isset( $matches[1] ) || ! isset( $matches[2] ) ) {
		return $input;
	} elseif ( ( $matches[1] === $_SERVER['SERVER_NAME'] ) || $matches[1] === $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] ) {
		return wp_make_link_relative( $input );
	} else {
		return $input;
	}
}

/**
 * Compare URL against relative URL
 */
function url_compare( $url, $rel ) {
	$url = trailingslashit( $url );
	$rel = trailingslashit( $rel );
	if ( ( strcasecmp( $url, $rel ) === 0 ) || root_relative_url( $url ) == $rel ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if element is empty
 */
function is_element_empty( $element ) {
	$element = trim( $element );
	return ! empty( $element );
}

/**
 * Human-friendly date string:
 * "about 2 hours ago"
 * "on 15/02/2015"
 *
 * @param DateTime $date
 * @return string
 */
function human_date( $date ) {
	$friendly_cutoff = new DateTime( '-1 month' );

	if ( $date < $friendly_cutoff ) {
		return $date->format( get_option( 'date_format' ) );
	} else {
		return human_time_diff( $date->getTimestamp() ) . ' ago';
	}
}

/**
 * Detect if we're running under WP-CLI.
 *
 * @return boolean
 */
function is_wp_cli() {
	return defined( 'WP_CLI' ) && WP_CLI;
}
