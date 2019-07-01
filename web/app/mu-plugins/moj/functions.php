<?php

namespace moj;

/**
 * This function ensures that the ACF json file will now be saved
 * in a theme agnostic location, allowing ACF structures to be shared between
 * themes which may be beneficial in a multi-site scenario.
 *
 * https://www.advancedcustomfields.com/resources/local-json/
 */
function acf_json_save_point($path)
{
    // update path
    $path = WPMU_PLUGIN_DIR . '/moj/acf-json';

    return $path;
}

add_filter('acf/settings/save_json', __NAMESPACE__ . '\\acf_json_save_point', 99);

/**
 * ACF schema now loaded from /mu-plugins/moj/acf-json
 *
 * See acf_json_save_point for rationale.
 * @param $paths
 * @return array
 */
function acf_json_load_point($paths)
{
    // remove original path
    unset($paths[0]);

    // append path
    $paths[] = WPMU_PLUGIN_DIR . '/moj/acf-json';

    return $paths;
}

add_filter('acf/settings/load_json', __NAMESPACE__ . '\\acf_json_load_point', 99);
