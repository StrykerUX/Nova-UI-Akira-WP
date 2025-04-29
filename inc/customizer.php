<?php
/**
 * Nova UI Akira Theme Customizer
 *
 * @package Nova_UI_Akira
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nova_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'nova_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'nova_customize_partial_blogdescription',
            )
        );
    }

    // Advanced Logo Options Section
    $wp_customize->add_section('nova_logo_options', array(
        'title'       => __('Advanced Logo Options', 'nova-ui-akira'),
        'description' => __('Upload different logos for light/dark mode and expanded/collapsed sidebar.', 'nova-ui-akira'),
        'priority'    => 25,
    ));

    // Light Mode - Expanded Logo
    $wp_customize->add_setting('nova_logo_light_expanded', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'nova_logo_light_expanded', array(
        'label'       => __('Light Mode - Expanded Logo', 'nova-ui-akira'),
        'description' => __('Upload a logo for light mode when sidebar is expanded. Recommended size: 200x50px', 'nova-ui-akira'),
        'section'     => 'nova_logo_options',
        'settings'    => 'nova_logo_light_expanded',
        'width'       => 200,
        'height'      => 50,
        'flex_width'  => true,
        'flex_height' => true,
    )));

    // Light Mode - Collapsed Logo
    $wp_customize->add_setting('nova_logo_light_collapsed', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'nova_logo_light_collapsed', array(
        'label'       => __('Light Mode - Collapsed Logo', 'nova-ui-akira'),
        'description' => __('Upload a smaller logo for light mode when sidebar is collapsed. Recommended size: 50x50px', 'nova-ui-akira'),
        'section'     => 'nova_logo_options',
        'settings'    => 'nova_logo_light_collapsed',
        'width'       => 50,
        'height'      => 50,
        'flex_width'  => true,
        'flex_height' => true,
    )));

    // Dark Mode - Expanded Logo
    $wp_customize->add_setting('nova_logo_dark_expanded', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'nova_logo_dark_expanded', array(
        'label'       => __('Dark Mode - Expanded Logo', 'nova-ui-akira'),
        'description' => __('Upload a logo for dark mode when sidebar is expanded. Recommended size: 200x50px', 'nova-ui-akira'),
        'section'     => 'nova_logo_options',
        'settings'    => 'nova_logo_dark_expanded',
        'width'       => 200,
        'height'      => 50,
        'flex_width'  => true,
        'flex_height' => true,
    )));

    // Dark Mode - Collapsed Logo
    $wp_customize->add_setting('nova_logo_dark_collapsed', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'nova_logo_dark_collapsed', array(
        'label'       => __('Dark Mode - Collapsed Logo', 'nova-ui-akira'),
        'description' => __('Upload a smaller logo for dark mode when sidebar is collapsed. Recommended size: 50x50px', 'nova-ui-akira'),
        'section'     => 'nova_logo_options',
        'settings'    => 'nova_logo_dark_collapsed',
        'width'       => 50,
        'height'      => 50,
        'flex_width'  => true,
        'flex_height' => true,
    )));

    // Show Logo in Topbar?
    $wp_customize->add_setting('nova_show_logo_topbar', array(
        'default'           => true,
        'sanitize_callback' => 'nova_sanitize_checkbox',
    ));

    $wp_customize->add_control('nova_show_logo_topbar', array(
        'type'     => 'checkbox',
        'label'    => __('Show Logo in Topbar', 'nova-ui-akira'),
        'description' => __('Enable to show the logo in the top navigation bar.', 'nova-ui-akira'),
        'section'  => 'nova_logo_options',
        'settings' => 'nova_show_logo_topbar',
    ));

    // Theme Colors Section
    $wp_customize->add_section('nova_colors', array(
        'title'    => __('Theme Colors', 'nova-ui-akira'),
        'priority' => 30,
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#6c57d8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => __('Primary Color', 'nova-ui-akira'),
        'section'  => 'nova_colors',
        'settings' => 'primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#6c757d',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => __('Secondary Color', 'nova-ui-akira'),
        'section'  => 'nova_colors',
        'settings' => 'secondary_color',
    )));

    // Layout Options Section
    $wp_customize->add_section('nova_layout', array(
        'title'    => __('Layout Options', 'nova-ui-akira'),
        'priority' => 40,
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'nova_sanitize_select',
    ));

    $wp_customize->add_control('sidebar_position', array(
        'type'    => 'select',
        'section'  => 'nova_layout',
        'label'    => __('Sidebar Position', 'nova-ui-akira'),
        'choices'  => array(
            'right' => __('Right', 'nova-ui-akira'),
            'left'  => __('Left', 'nova-ui-akira'),
            'none'  => __('No Sidebar', 'nova-ui-akira'),
        ),
    ));

    // Footer Options Section
    $wp_customize->add_section('nova_footer', array(
        'title'    => __('Footer Options', 'nova-ui-akira'),
        'priority' => 50,
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'type'    => 'textarea',
        'section'  => 'nova_footer',
        'label'    => __('Copyright Text', 'nova-ui-akira'),
        'description' => __('Replace the default copyright text in the footer. Leave blank to use the default.', 'nova-ui-akira'),
    ));
}
add_action('customize_register', 'nova_customize_register');

/**
 * Sanitize checkbox field
 */
function nova_sanitize_checkbox($input) {
    return ( ( isset( $input ) && true == $input ) ? true : false );
}

/**
 * Sanitize select field
 */
function nova_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function nova_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function nova_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nova_customize_preview_js() {
    wp_enqueue_script('nova-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), NOVA_VERSION, true);
}
add_action('customize_preview_init', 'nova_customize_preview_js');

/**
 * Output custom CSS for customizer options
 */
function nova_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#6c57d8');
    $secondary_color = get_theme_mod('secondary_color', '#6c757d');
    
    $custom_css = "";
    
    if ($primary_color !== '#6c57d8') {
        $custom_css .= "
            :root {
                --bs-primary: {$primary_color};
                --bs-primary-rgb: " . implode(',', nova_hex_to_rgb($primary_color)) . ";
            }
        ";
    }
    
    if ($secondary_color !== '#6c757d') {
        $custom_css .= "
            :root {
                --bs-secondary: {$secondary_color};
                --bs-secondary-rgb: " . implode(',', nova_hex_to_rgb($secondary_color)) . ";
            }
        ";
    }
    
    wp_add_inline_style('nova-theme', $custom_css);
}
add_action('wp_enqueue_scripts', 'nova_customizer_css');

/**
 * Helper function to convert hex color to RGB values
 */
function nova_hex_to_rgb($hex) {
    $hex = str_replace('#', '', $hex);
    
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    $rgb = array();
    $rgb[] = hexdec(substr($hex, 0, 2));
    $rgb[] = hexdec(substr($hex, 2, 2));
    $rgb[] = hexdec(substr($hex, 4, 2));
    
    return $rgb;
}

/**
 * Helper function to get the advanced logo HTML
 */
function nova_get_logo($location, $size) {
    $mode = 'light'; // Default to light mode
    if (is_callable('wp_get_global_styles') && wp_get_global_styles(array('prefrence' => 'dark')) === 'dark') {
        $mode = 'dark';
    }
    
    $html = '';
    $setting_name = 'nova_logo_' . $mode . '_' . $size;
    $logo_id = get_theme_mod($setting_name, '');
    
    if ($logo_id) {
        $logo_img = wp_get_attachment_image($logo_id, 'full', false, array(
            'class' => 'custom-logo custom-logo-' . $size,
            'alt' => get_bloginfo('name')
        ));
        $html = $logo_img;
    } else {
        // Fall back to text if no logo
        if ($size === 'expanded') {
            $html = '<span class="logo-text">' . get_bloginfo('name') . '</span>';
        } else {
            $html = '<span class="logo-sm text-center">' . esc_html(substr(get_bloginfo('name'), 0, 1)) . '</span>';
        }
    }
    
    return $html;
}
