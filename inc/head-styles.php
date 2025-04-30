<?php
/**
 * Inline styles added to the head
 * 
 * @package Nova_UI_Akira
 */

/**
 * Add critical inline styles to head
 */
function nova_inline_head_styles() {
    // Get theme mode from cookie or default to light
    $theme_mode = isset($_COOKIE['theme_mode']) && $_COOKIE['theme_mode'] === 'dark' ? 'dark' : 'light';
    
    // Get selection colors based on theme mode
    if ($theme_mode === 'dark') {
        $selection_bg = get_theme_mod('dark_selection_background', '#9161ff');
        $selection_text = get_theme_mod('dark_selection_text', '#17181e');
    } else {
        $selection_bg = get_theme_mod('light_selection_background', '#6500ff');
        $selection_text = get_theme_mod('light_selection_text', '#ffffff');
    }
    
    // Inline CSS for selection
    $inline_css = "
        /* Inline selection styles */
        ::selection {
            background-color: {$selection_bg} !important;
            color: {$selection_text} !important;
        }
        ::-moz-selection {
            background-color: {$selection_bg} !important;
            color: {$selection_text} !important;
        }
    ";
    
    echo '<style id="nova-inline-selection-styles">' . $inline_css . '</style>';
}
add_action('wp_head', 'nova_inline_head_styles', 5);
