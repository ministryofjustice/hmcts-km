<?php

namespace Roots\Sage\Assets;

/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/dist/styles/main.css
 *
 * Enqueue scripts in the following order:
 * 1. Latest jQuery via Google CDN (if enabled in config.php)
 * 2. /theme/dist/scripts/modernizr.min.js
 * 3. /theme/dist/scripts/main.min.js
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */

/**
 * This function uses Laravel Mix, in particular, the mix-manifest.json file.
 * The manifest file is converted to an array and distributed using keys described as $handles
 *
 * @param $handle
 * @return bool|string
 */
function moj_get_asset($handle)
{
    $get_assets = file_get_contents(get_template_directory() . '/dist/mix-manifest.json', false);
    $manifest = json_decode($get_assets, true);

    $assets = array(
        'style' => '/dist' . $manifest['/styles/main.css'],
        'editor-style' => '/dist' . $manifest['/styles/editor-style.css'],
        'js' => '/dist' . $manifest['/scripts/main.min.js'],
        'jj-gtm' => '/dist' . $manifest['/scripts/jj-gtm.js'],
        'js-modernizer' => '/dist' . $manifest['/scripts/modernizr.min.js'],
        'js-g-jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',
        'js-jquery' => '/dist' . $manifest['/scripts/jquery.min.js'],

    );

    if (strpos($assets[$handle], '//') === 0) {
        return $assets[$handle];
    }

    // create the file system path for the file requested.
    $file_system_path = get_template_directory() . strstr($assets[$handle], '?', true);

    if (file_exists($file_system_path)) {
        return get_template_directory_uri() . $assets[$handle];
    }

    return false;
}

function assets()
{
    wp_enqueue_style('sage_css', moj_get_asset('style'), false, null);

  /**
   * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
   * jQuery & Modernizr load in the footer per HTML5 Boilerplate's recommendation: http://goo.gl/nMGR7P
   * If a plugin enqueues jQuery-dependent scripts in the head, jQuery will load in the head to meet the plugin's dependencies
   * To explicitly load jQuery in the head, change the last wp_enqueue_script parameter to false
   */
    if (!is_admin() && current_theme_supports('jquery-cdn')) {
        wp_deregister_script('jquery');

        wp_register_script('jquery', moj_get_asset('js-g-jquery'), [], null, true);

        add_filter('script_loader_src', __NAMESPACE__ . '\\jquery_local_fallback', 10, 2);
    }

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('modernizr', moj_get_asset('js-modernizer'), [], null, true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('sage_js', moj_get_asset('js'), [], null, true);
    wp_enqueue_script('jj-gtm', moj_get_asset('jj-gtm'), array('jquery'));

    wp_localize_script('sage_js', 'SageJS', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);


/**
 * Enqueue a script in the WordPress admin
 *
 * @param int $hook Hook suffix
 */
function enqueue_admin_script()
{
    // Track backend editors - they have asked for it to better understand editor behaviour
    wp_enqueue_script('jj-gtm', moj_get_asset('jj-gtm'), array('jquery'));
}

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_admin_script', 10);


// http://wordpress.stackexchange.com/a/12450
function jquery_local_fallback($src, $handle = null)
{
    static $add_jquery_fallback = false;

    if ($add_jquery_fallback) {
        echo '<script>window.jQuery || document.write(\'<script src="' . $add_jquery_fallback . '"><\/script>\')</script>' . "\n";
        $add_jquery_fallback = false;
    }

    if ($handle === 'jquery') {
        $add_jquery_fallback = apply_filters('script_loader_src', moj_get_asset('js-jquery'), 'jquery-fallback');
    }

    return $src;
}
add_action('wp_head', __NAMESPACE__ . '\\jquery_local_fallback');
