<?php
/**
 * Mobile Menu Walker Class
 * 
 * Custom walker for the bottom mobile menu items
 * 
 * @package Nova_UI_Akira
 * @subpackage Mobile_Menu
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Mobile Menu Walker Class
 */
class Nova_Mobile_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * Start the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Get the icon from menu item metadata or fallback to a default
        $icon = '';
        if (isset($item->icon) && !empty($item->icon)) {
            $icon = $item->icon;
        } elseif (function_exists('get_post_meta')) {
            $icon_meta = get_post_meta($item->ID, '_nova_menu_item_icon', true);
            if (!empty($icon_meta)) {
                $icon = $icon_meta;
            }
        }
        
        // If no icon is set, use a default based on title
        if (empty($icon)) {
            switch (strtolower($item->title)) {
                case 'home':
                    $icon = 'ti ti-home';
                    break;
                case 'ai assistants':
                    $icon = 'ti ti-robot';
                    break;
                case 'quick links':
                    $icon = 'ti ti-bolt';
                    break;
                default:
                    $icon = 'ti ti-chevron-right';
                    break;
            }
        }
        
        // Check if current
        $is_current = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes);
        $active_class = $is_current ? ' active' : '';
        
        // Output the item
        $output .= $indent . '<a href="' . esc_url($item->url) . '" class="mobile-nav-item' . $active_class . '">' . $n;
        $output .= $indent . $t . '<i class="' . esc_attr($icon) . '"></i>' . $n;
        $output .= $indent . $t . '<span>' . esc_html($item->title) . '</span>' . $n;
        $output .= $indent . '</a>' . $n;
    }
    
    /**
     * Ends the element output.
     */
    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        // Element already closed in start_el
        return;
    }
    
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        // We don't handle submenus in mobile bottom menu
        return;
    }
    
    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = array()) {
        // We don't handle submenus in mobile bottom menu
        return;
    }
}
