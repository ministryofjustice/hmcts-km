<?php

namespace Roots\Sage\Nav\Walkers;

use Walker_Nav_Menu;

/**
 * Method names in this class are not camel cased because WordPress requires us to use these specific names.
 * Therefore, the relevant PHP CodeSniffer rule is disabled for this file.
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */

class ButtonNavWalker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $html = '';
        parent::start_el($html, $item, $depth, $args, $id);
        $html = preg_replace('/<\/?li.*?>/i', '', $html);

        $link_classes = array();
        $link_classes[] = 'btn btn-default';
        $html = preg_replace('/<a (.*?)>/', '<a $1 class="' . implode(' ', $link_classes) . '">', $html);

        $output .= $html;
    }

    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $html = '';
        parent::end_el($html, $item, $depth, $args);
        $html = preg_replace('/<\/?li.*?>/i', '', $html);
        $output .= $html;
    }

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        return;
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        return;
    }
}
