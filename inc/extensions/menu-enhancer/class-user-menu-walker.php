<?php
/**
 * User Menu Walker Class
 * 
 * Custom walker class for the user dropdown menu
 * 
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * User Menu Walker Class
 */
class Nova_User_Menu_Walker extends Walker_Nav_Menu {
    
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
        
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Add active class if menu item is current
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
            $classes[] = 'fw-semibold';
        }
        
        // Add custom classes for specific menu items
        if (strpos(strtolower($item->title), 'sign out') !== false || 
            strpos(strtolower($item->title), 'logout') !== false) {
            $classes[] = 'active';
            $classes[] = 'fw-semibold';
            $classes[] = 'text-danger';
        }
        
        // Check if divider
        $is_divider = in_array('menu-divider', $classes);
        
        if ($is_divider) {
            $output .= $indent . '<div class="dropdown-divider"></div>' . $n;
            return;
        }
        
        // Check if header
        $is_header = in_array('menu-header', $classes);
        
        if ($is_header) {
            $output .= $indent . '<div class="dropdown-header noti-title"><h6 class="text-overflow m-0">' . esc_html($item->title) . '</h6></div>' . $n;
            return;
        }
        
        // For normal menu items
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="dropdown-item ' . esc_attr($class_names) . '"' : ' class="dropdown-item"';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        // Get icon if set in menu item metadata
        $icon = '';
        if (!empty($item->icon)) {
            $icon = '<i class="' . esc_attr($item->icon) . ' me-1 fs-17 align-middle"></i>';
        } else {
            // Default icons based on title text for common user menu items
            if (strpos(strtolower($item->title), 'account') !== false) {
                $icon = '<i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>';
            } elseif (strpos(strtolower($item->title), 'dashboard') !== false || strpos(strtolower($item->title), 'admin') !== false) {
                $icon = '<i class="ti ti-settings me-1 fs-17 align-middle"></i>';
            } elseif (strpos(strtolower($item->title), 'sign out') !== false || strpos(strtolower($item->title), 'logout') !== false) {
                $icon = '<i class="ti ti-logout me-1 fs-17 align-middle"></i>';
            } elseif (strpos(strtolower($item->title), 'profile') !== false) {
                $icon = '<i class="ti ti-user me-1 fs-17 align-middle"></i>';
            }
        }
        
        $item_output = $args->before;
        $item_output .= '<a' . $class_names . $attributes . '>';
        $item_output .= $icon;
        $item_output .= $args->link_before . '<span class="align-middle">' . apply_filters('the_title', $item->title, $item->ID) . '</span>' . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= $indent . $item_output . $n;
    }
}
