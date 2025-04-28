<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Nova_UI_Akira
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function nova_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'nova_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function nova_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'nova_pingback_header');

/**
 * Change the excerpt length
 */
function nova_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'nova_excerpt_length');

/**
 * Change the excerpt more string
 */
function nova_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'nova_excerpt_more');

/**
 * Add custom menu classes
 */
function nova_add_menu_class($classes, $item, $args) {
    if (property_exists($args, 'theme_location') && $args->theme_location === 'primary') {
        $classes[] = 'nav-item';
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'nova_add_menu_class', 10, 3);

/**
 * Add custom link attributes
 */
function nova_add_link_atts($atts, $item, $args) {
    if (property_exists($args, 'theme_location') && $args->theme_location === 'primary') {
        $atts['class'] = 'nav-link';
    }
    
    return $atts;
}
add_filter('nav_menu_link_attributes', 'nova_add_link_atts', 10, 3);