<?php
/**
 * Nova UI Akira Advanced Logo Functions
 *
 * @package Nova_UI_Akira
 */

/**
 * Get the HTML for the advanced logo
 * This handles light/dark modes and expanded/collapsed states
 *
 * @return string HTML for the logo
 */
function nova_get_advanced_logo() {
    $html = '<div class="logo-container">';
    
    // Light Mode Logos
    $html .= '<div class="logo-light">';
    
    // Light Expanded Logo
    $light_expanded_id = get_theme_mod('nova_logo_light_expanded', '');
    $light_expanded_logo = '';
    if ($light_expanded_id) {
        $light_expanded_logo = wp_get_attachment_image($light_expanded_id, 'full', false, array(
            'class' => 'custom-logo',
            'alt' => get_bloginfo('name'),
        ));
    }
    
    // Light Collapsed Logo
    $light_collapsed_id = get_theme_mod('nova_logo_light_collapsed', '');
    $light_collapsed_logo = '';
    if ($light_collapsed_id) {
        $light_collapsed_logo = wp_get_attachment_image($light_collapsed_id, 'full', false, array(
            'class' => 'custom-logo',
            'alt' => get_bloginfo('name'),
        ));
    }
    
    // Dark Mode Logos
    $html .= '<div class="logo-lg">';
    if ($light_expanded_logo) {
        $html .= $light_expanded_logo;
    } else {
        // Fallback if no custom logo
        $html .= '<span class="logo-text">' . get_bloginfo('name') . '</span>';
    }
    $html .= '</div>';
    
    $html .= '<div class="logo-sm">';
    if ($light_collapsed_logo) {
        $html .= $light_collapsed_logo;
    } else if ($light_expanded_logo) {
        // Use expanded logo as fallback
        $html .= $light_expanded_logo;
    } else {
        // Fallback to site initial if no logo
        $html .= '<span class="logo-sm text-center">' . esc_html(substr(get_bloginfo('name'), 0, 1)) . '</span>';
    }
    $html .= '</div>';
    
    $html .= '</div>'; // End light mode
    
    // Dark Mode Logos
    $html .= '<div class="logo-dark">';
    
    // Dark Expanded Logo
    $dark_expanded_id = get_theme_mod('nova_logo_dark_expanded', '');
    $dark_expanded_logo = '';
    if ($dark_expanded_id) {
        $dark_expanded_logo = wp_get_attachment_image($dark_expanded_id, 'full', false, array(
            'class' => 'custom-logo',
            'alt' => get_bloginfo('name'),
        ));
    }
    
    // Dark Collapsed Logo
    $dark_collapsed_id = get_theme_mod('nova_logo_dark_collapsed', '');
    $dark_collapsed_logo = '';
    if ($dark_collapsed_id) {
        $dark_collapsed_logo = wp_get_attachment_image($dark_collapsed_id, 'full', false, array(
            'class' => 'custom-logo',
            'alt' => get_bloginfo('name'),
        ));
    }
    
    $html .= '<div class="logo-lg">';
    if ($dark_expanded_logo) {
        $html .= $dark_expanded_logo;
    } else if ($light_expanded_logo) {
        // Fallback to light mode logo if no dark logo
        $html .= $light_expanded_logo;
    } else {
        // Fallback if no custom logo
        $html .= '<span class="logo-text">' . get_bloginfo('name') . '</span>';
    }
    $html .= '</div>';
    
    $html .= '<div class="logo-sm">';
    if ($dark_collapsed_logo) {
        $html .= $dark_collapsed_logo;
    } else if ($dark_expanded_logo) {
        // Use dark expanded logo as fallback
        $html .= $dark_expanded_logo;
    } else if ($light_collapsed_logo) {
        // Use light collapsed logo as fallback
        $html .= $light_collapsed_logo;
    } else if ($light_expanded_logo) {
        // Use light expanded logo as fallback
        $html .= $light_expanded_logo;
    } else {
        // Fallback to site initial if no logo
        $html .= '<span class="logo-sm text-center">' . esc_html(substr(get_bloginfo('name'), 0, 1)) . '</span>';
    }
    $html .= '</div>';
    
    $html .= '</div>'; // End dark mode
    
    $html .= '</div>'; // End logo container
    
    return $html;
}

/**
 * Enqueue logo-specific styles
 */
function nova_enqueue_logo_styles() {
    // Enqueue the custom logo styles
    wp_enqueue_style('nova-logo-styles', get_template_directory_uri() . '/assets/css/logo-styles.css', array(), NOVA_VERSION);
}
add_action('wp_enqueue_scripts', 'nova_enqueue_logo_styles');

/**
 * Register the logo functions file in the theme
 */
function nova_include_logo_functions() {
    // Include this file in functions.php
    if (!function_exists('nova_get_advanced_logo')) {
        require_once get_template_directory() . '/inc/logo-functions.php';
    }
}
