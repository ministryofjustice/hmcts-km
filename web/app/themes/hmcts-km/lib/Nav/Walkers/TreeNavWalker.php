<?php

namespace Roots\Sage\Nav\Walkers;

use Walker_Nav_Menu;
use Roots\Sage\Utils;

/**
 * Method names in this class are not camel cased because WordPress requires us to use these specific names.
 * Therefore, the relevant PHP CodeSniffer rule is disabled for this file.
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */

class TreeNavWalker extends Walker_Nav_Menu
{
    private $cpt; // Boolean, is current post a custom post type
    private $archive; // Stores the archive page for current URL

    public function __construct()
    {
        add_filter('nav_menu_css_class', array($this, 'cssClasses'), 10, 2);
        add_filter('nav_menu_item_id', '__return_null');
        $cpt           = get_post_type();
        $this->cpt     = in_array($cpt, get_post_types(array('_builtin' => false)));
        $this->archive = get_post_type_archive_link($cpt);
        add_filter('wp_nav_menu_args', array($this, 'nav_menu_args'));
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $item_html = '';
        parent::start_el($item_html, $item, $depth, $args, $id);

        $link_classes = array();
        $link_classes[] = 'tree-link';
        $item_html = preg_replace('/<a (.*?)>/', '<a $1 class="' . implode(' ', $link_classes) . '">', $item_html);

        if ($item->is_dropdown) {
            $item_html = preg_replace('/<a (.*?)>/', '<a href="' . $item->url . '" class="toggle-children"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i></a><a $1>', $item_html);
        }

        $output .= $item_html;
    }

    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        $element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

        if ($element->is_dropdown) {
            $element->classes[] = 'has-children';
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    public function cssClasses($classes, $item)
    {
        $slug = sanitize_title($item->title);

        if ($this->cpt) {
            $classes = str_replace('current_page_parent', '', $classes);
        }

        $classes = str_replace('current-menu-item', 'active', $classes);
        if (in_array('active', $classes)) {
            $classes[] = 'has-active';
        }
        $classes = preg_replace('/(current(-menu-|[-_]page[-_])(parent|ancestor))/', 'has-active', $classes);
        $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

        $classes[] = 'menu-' . $slug;

        $classes = array_unique($classes);

        return array_filter($classes, 'Roots\\Sage\\Utils\\is_element_empty');
    }

  /**
   * Clean up wp_nav_menu_args
   *
   * Remove the container
   * Remove the id="" on nav menu items
   *
   * @param array $args
   * @return array
   */
    public function nav_menu_args($args = array())
    {
        $menu_class = isset($args['menu_class']) ? $args['menu_class'] : '';

        $menu_class .= ' tree tree-no-js';

        $args['menu_class'] = $menu_class;

        return $args;
    }
}
