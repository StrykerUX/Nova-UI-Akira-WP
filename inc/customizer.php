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