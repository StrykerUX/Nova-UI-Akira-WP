<?php
/**
 * Topbar Icons Walker Class
 * 
 * Custom walker class for the topbar icons menu
 * 
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Topbar Icons Walker Class
 */
class Nova_Topbar_Icons_Walker extends Walker_Nav_Menu {
    
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        // We don't handle submenus in topbar icons
        return;
    }
    
    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = array()) {
        // We don't handle submenus in topbar icons
        return;
    }
    
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        
        // Get the icon from menu item metadata or fallback to a default
        $icon = !empty($item->icon) ? $item->icon : 'ti ti-circle';
        
        // Output the item as a button with just the icon
        $output .= $indent . '<div class="topbar-item d-none d-sm-flex">' . $n;
        $output .= $t . '<a href="' . esc_url($item->url) . '" class="topbar-link btn btn-outline-primary btn-icon" ' . 
                   'type="button" title="' . esc_attr($item->title) . '">' . $n;
        $output .= $t . $t . '<i class="' . esc_attr($icon) . ' fs-22"></i>' . $n;
        $output .= $t . '</a>' . $n;
        $output .= '</div>' . $n;
    }
    
    /**
     * Ends the element output.
     */
    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        // We already closed the element in start_el
        return;
    }
}
