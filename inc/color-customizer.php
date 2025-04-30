<?php
/**
 * Nova UI Akira Color Customizer
 * 
 * @package Nova_UI_Akira
 */

/**
 * Register the advanced color customization options
 */
function nova_color_customizer_register($wp_customize) {
    // Theme Colors Section already exists in the main customizer.php
    
    // Update Primary Color - Make it the main brand color
    $wp_customize->get_control('primary_color')->label = __('Primary Brand Color', 'nova-ui-akira');
    $wp_customize->get_control('primary_color')->description = __('Main brand color used for accents, links, and primary buttons.', 'nova-ui-akira');
    
    // Update Secondary Color - Make it the secondary brand color
    $wp_customize->get_control('secondary_color')->label = __('Secondary Brand Color', 'nova-ui-akira');
    $wp_customize->get_control('secondary_color')->description = __('Secondary color used for alternate UI elements.', 'nova-ui-akira');
    
    // Add Accent Color - For hover states, highlights, and interactive elements
    $wp_customize->add_setting('accent_color', array(
        'default'           => '#7949f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'       => __('Accent Color', 'nova-ui-akira'),
        'description' => __('Used for hover states, highlights, and interactive elements like the menu icon.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'accent_color',
    )));

    // Light Mode Colors
    $wp_customize->add_setting('light_background', array(
        'default'           => '#fffbf4',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_background', array(
        'label'       => __('Light Mode - Background', 'nova-ui-akira'),
        'description' => __('Main background color in light mode.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'light_background',
    )));
    
    $wp_customize->add_setting('light_text', array(
        'default'           => '#4c4c5c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_text', array(
        'label'       => __('Light Mode - Text Color', 'nova-ui-akira'),
        'description' => __('Main text color in light mode.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'light_text',
    )));
    
    // Dark Mode Colors
    $wp_customize->add_setting('dark_background', array(
        'default'           => '#17181e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_background', array(
        'label'       => __('Dark Mode - Background', 'nova-ui-akira'),
        'description' => __('Main background color in dark mode.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'dark_background',
    )));
    
    $wp_customize->add_setting('dark_text', array(
        'default'           => '#aab8c5',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_text', array(
        'label'       => __('Dark Mode - Text Color', 'nova-ui-akira'),
        'description' => __('Main text color in dark mode.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'dark_text',
    )));
    
    // Menu & Navigation Colors
    $wp_customize->add_setting('menu_hover_color', array(
        'default'           => '#7949f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'menu_hover_color', array(
        'label'       => __('Menu Hover Color', 'nova-ui-akira'),
        'description' => __('Color for menu items when hovered.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'menu_hover_color',
    )));
    
    // Button colors
    $wp_customize->add_setting('button_background', array(
        'default'           => '#313a46',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'button_background', array(
        'label'       => __('Button Background', 'nova-ui-akira'),
        'description' => __('Background color for primary buttons.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'button_background',
    )));
    
    $wp_customize->add_setting('button_text', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'button_text', array(
        'label'       => __('Button Text', 'nova-ui-akira'),
        'description' => __('Text color for primary buttons.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'button_text',
    )));
    
    // Add color scheme presets
    $wp_customize->add_setting('color_scheme', array(
        'default'           => 'default',
        'sanitize_callback' => 'nova_sanitize_select',
    ));
    
    $wp_customize->add_control('color_scheme', array(
        'type'        => 'select',
        'label'       => __('Color Scheme Preset', 'nova-ui-akira'),
        'description' => __('Choose a predefined color scheme, or customize individual colors.', 'nova-ui-akira'),
        'section'     => 'nova_colors',
        'settings'    => 'color_scheme',
        'choices'     => array(
            'default'    => __('Default', 'nova-ui-akira'),
            'modern-blue' => __('Modern Blue', 'nova-ui-akira'),
            'elegant-green' => __('Elegant Green', 'nova-ui-akira'),
            'vibrant-purple' => __('Vibrant Purple', 'nova-ui-akira'),
            'warm-orange' => __('Warm Orange', 'nova-ui-akira'),
            'cool-gray' => __('Cool Gray', 'nova-ui-akira'),
            'custom' => __('Custom Colors', 'nova-ui-akira'),
        ),
        'priority'    => 1, // Place at the top of the section
    ));
}
add_action('customize_register', 'nova_color_customizer_register', 20); // Run after the main customizer

/**
 * Generate custom CSS based on color customizer settings
 */
function nova_color_customizer_css() {
    // Get the customized color values
    $primary_color = get_theme_mod('primary_color', '#313a46');
    $secondary_color = get_theme_mod('secondary_color', '#669776');
    $accent_color = get_theme_mod('accent_color', '#7949f6');
    $light_background = get_theme_mod('light_background', '#fffbf4');
    $light_text = get_theme_mod('light_text', '#4c4c5c');
    $dark_background = get_theme_mod('dark_background', '#17181e');
    $dark_text = get_theme_mod('dark_text', '#aab8c5');
    $menu_hover_color = get_theme_mod('menu_hover_color', '#7949f6');
    $button_background = get_theme_mod('button_background', '#313a46');
    $button_text = get_theme_mod('button_text', '#ffffff');
    
    // Convert hex colors to RGB for rgba() usage
    $primary_rgb = nova_hex_to_rgb($primary_color);
    $secondary_rgb = nova_hex_to_rgb($secondary_color);
    $accent_rgb = nova_hex_to_rgb($accent_color);
    
    $custom_css = "
        /* Custom Colors */
        :root {
            /* Brand Colors */
            --bs-primary: {$primary_color};
            --bs-primary-rgb: " . implode(',', $primary_rgb) . ";
            --bs-secondary: {$secondary_color};
            --bs-secondary-rgb: " . implode(',', $secondary_rgb) . ";
            --bs-accent: {$accent_color};
            --bs-accent-rgb: " . implode(',', $accent_rgb) . ";
            
            /* Light mode variables */
            --bs-body-color: {$light_text};
            --bs-body-color-rgb: " . implode(',', nova_hex_to_rgb($light_text)) . ";
            --bs-body-bg: {$light_background};
            --bs-body-bg-rgb: " . implode(',', nova_hex_to_rgb($light_background)) . ";
            
            /* Menu hover color */
            --bs-menu-item-hover-color: {$menu_hover_color};
            --bs-menu-item-hover-bg: rgba(" . implode(',', nova_hex_to_rgb($menu_hover_color)) . ", 0.1);
            --bs-menu-item-active-color: {$menu_hover_color};
            --bs-menu-item-active-bg: rgba(" . implode(',', nova_hex_to_rgb($menu_hover_color)) . ", 0.1);
            
            /* Button styles */
            --bs-btn-bg: {$button_background};
            --bs-btn-color: {$button_text};
            
            /* Link colors */
            --bs-link-color: {$accent_color};
            --bs-link-color-rgb: " . implode(',', nova_hex_to_rgb($accent_color)) . ";
            --bs-link-hover-color: " . nova_adjust_brightness($accent_color, -15) . ";
            --bs-link-hover-color-rgb: " . implode(',', nova_hex_to_rgb(nova_adjust_brightness($accent_color, -15))) . ";
        }
        
        /* Dark mode overrides */
        [data-bs-theme=dark] {
            --bs-body-color: {$dark_text};
            --bs-body-color-rgb: " . implode(',', nova_hex_to_rgb($dark_text)) . ";
            --bs-body-bg: {$dark_background};
            --bs-body-bg-rgb: " . implode(',', nova_hex_to_rgb($dark_background)) . ";
        }
        
        /* Custom element styles */
        .btn-primary {
            --bs-btn-color: {$button_text};
            --bs-btn-bg: {$button_background};
            --bs-btn-border-color: {$button_background};
            --bs-btn-hover-color: {$button_text};
            --bs-btn-hover-bg: " . nova_adjust_brightness($button_background, -10) . ";
            --bs-btn-hover-border-color: " . nova_adjust_brightness($button_background, -10) . ";
        }
        
        /* Custom icons colors */
        .icon-dual-primary {
            color: {$primary_color};
            fill: rgba(" . implode(',', $primary_rgb) . ", 0.2);
        }
        
        .icon-dual-secondary {
            color: {$secondary_color};
            fill: rgba(" . implode(',', $secondary_rgb) . ", 0.2);
        }
        
        .icon-dual-accent {
            color: {$accent_color};
            fill: rgba(" . implode(',', $accent_rgb) . ", 0.2);
        }
        
        /* Menu item hover effects */
        .side-nav-item:hover, .side-nav-item:focus, .side-nav-item.active {
            color: {$menu_hover_color};
        }
        
        .side-nav-link:hover, .side-nav-link:focus, .side-nav-link:active {
            color: {$menu_hover_color};
        }
        
        /* Icon hover effects - apply accent color to all icons on hover */
        .btn-icon:hover i,
        .topbar-link:hover i,
        .menu-icon:hover i,
        .side-nav-link:hover i,
        .app-topbar .btn-icon:hover i,
        .app-topbar .btn-outline-primary:hover i,
        #light-dark-mode:hover i,
        .sidenav-toggle-button:hover i,
        .user-dropdown-toggle:hover i,
        .topbar-item .dropdown-toggle:hover i,
        button:hover i,
        a:hover i,
        .nav-link:hover i {
            color: {$accent_color} !important;
        }
        
        /* Make sure button text color stays correct */
        .btn-primary:hover i {
            color: {$button_text} !important;
        }
    ";
    
    // Add the custom CSS to the theme
    wp_add_inline_style('nova-theme', $custom_css);
}
add_action('wp_enqueue_scripts', 'nova_color_customizer_css', 20); // Run after the main styles

/**
 * Helper function to adjust color brightness
 *
 * @param string $hex Hex color code
 * @param int $steps Steps to darken or lighten (negative values darken, positive lighten)
 * @return string Adjusted color as hex
 */
function nova_adjust_brightness($hex, $steps) {
    // Remove # if present
    $hex = ltrim($hex, '#');
    
    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Adjust brightness
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    // Convert back to hex
    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}

/**
 * Add customizer JavaScript for color scheme presets
 */
function nova_color_scheme_customizer_script() {
    wp_enqueue_script(
        'nova-color-scheme-customizer',
        get_template_directory_uri() . '/assets/js/color-scheme-customizer.js',
        array('jquery', 'customize-controls'),
        NOVA_VERSION,
        true
    );
    
    // Pass color schemes to JavaScript
    $color_schemes = array(
        'default' => array(
            'primary_color' => '#313a46',
            'secondary_color' => '#669776',
            'accent_color' => '#7949f6',
            'light_background' => '#fffbf4',
            'light_text' => '#4c4c5c',
            'dark_background' => '#17181e',
            'dark_text' => '#aab8c5',
            'menu_hover_color' => '#7949f6',
            'button_background' => '#313a46',
            'button_text' => '#ffffff',
        ),
        'modern-blue' => array(
            'primary_color' => '#1976d2',
            'secondary_color' => '#64b5f6',
            'accent_color' => '#2196f3',
            'light_background' => '#f9fbfd',
            'light_text' => '#37474f',
            'dark_background' => '#1c2938',
            'dark_text' => '#b0bec5',
            'menu_hover_color' => '#2196f3',
            'button_background' => '#1976d2',
            'button_text' => '#ffffff',
        ),
        'elegant-green' => array(
            'primary_color' => '#2e7d32',
            'secondary_color' => '#81c784',
            'accent_color' => '#4caf50',
            'light_background' => '#f9fdf9',
            'light_text' => '#37474f',
            'dark_background' => '#1b2a1c',
            'dark_text' => '#aed4b3',
            'menu_hover_color' => '#4caf50',
            'button_background' => '#2e7d32',
            'button_text' => '#ffffff',
        ),
        'vibrant-purple' => array(
            'primary_color' => '#6a1b9a',
            'secondary_color' => '#ab47bc',
            'accent_color' => '#9c27b0',
            'light_background' => '#faf8fd',
            'light_text' => '#37474f',
            'dark_background' => '#241229',
            'dark_text' => '#d1c4e9',
            'menu_hover_color' => '#9c27b0',
            'button_background' => '#6a1b9a',
            'button_text' => '#ffffff',
        ),
        'warm-orange' => array(
            'primary_color' => '#e65100',
            'secondary_color' => '#ff9800',
            'accent_color' => '#ff5722',
            'light_background' => '#fffaf7',
            'light_text' => '#37474f',
            'dark_background' => '#2e1d13',
            'dark_text' => '#ffe0b2',
            'menu_hover_color' => '#ff5722',
            'button_background' => '#e65100',
            'button_text' => '#ffffff',
        ),
        'cool-gray' => array(
            'primary_color' => '#455a64',
            'secondary_color' => '#78909c',
            'accent_color' => '#607d8b',
            'light_background' => '#f7fafb',
            'light_text' => '#37474f',
            'dark_background' => '#1c2428',
            'dark_text' => '#b0bec5',
            'menu_hover_color' => '#607d8b',
            'button_background' => '#455a64',
            'button_text' => '#ffffff',
        ),
    );
    
    wp_localize_script('nova-color-scheme-customizer', 'novaColorSchemes', $color_schemes);
}
add_action('customize_controls_enqueue_scripts', 'nova_color_scheme_customizer_script');

/**
 * Add JavaScript for live preview of customizer changes
 */
function nova_color_customizer_live_preview() {
    wp_enqueue_script(
        'nova-color-customizer-preview',
        get_template_directory_uri() . '/assets/js/color-customizer-preview.js',
        array('jquery', 'customize-preview'),
        NOVA_VERSION,
        true
    );
}
add_action('customize_preview_init', 'nova_color_customizer_live_preview');
