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

    // Main Theme Colors Section
    $wp_customize->add_section('nova_colors', array(
        'title'    => __('Theme Colors', 'nova-ui-akira'),
        'priority' => 30,
        'description' => __('Global color settings that apply to both light and dark modes.', 'nova-ui-akira'),
    ));

    // Light Mode Colors Section
    $wp_customize->add_section('nova_colors_light', array(
        'title'    => __('Light Mode Colors', 'nova-ui-akira'),
        'description' => __('Color settings specific to Light Mode.', 'nova-ui-akira'),
        'priority' => 31,
        'panel'    => 'nova_theme_colors',
    ));

    // Dark Mode Colors Section
    $wp_customize->add_section('nova_colors_dark', array(
        'title'    => __('Dark Mode Colors', 'nova-ui-akira'),
        'description' => __('Color settings specific to Dark Mode.', 'nova-ui-akira'),
        'priority' => 32,
        'panel'    => 'nova_theme_colors',
    ));

    // Add panel for theme colors
    $wp_customize->add_panel('nova_theme_colors', array(
        'title'    => __('Theme Colors', 'nova-ui-akira'),
        'priority' => 30,
    ));

    // Add sections to the panel
    $wp_customize->add_section('nova_colors_light', array(
        'title'    => __('Light Mode Colors', 'nova-ui-akira'),
        'description' => __('Color settings specific to Light Mode.', 'nova-ui-akira'),
        'priority' => 31,
        'panel'    => 'nova_theme_colors',
    ));

    $wp_customize->add_section('nova_colors_dark', array(
        'title'    => __('Dark Mode Colors', 'nova-ui-akira'),
        'description' => __('Color settings specific to Dark Mode.', 'nova-ui-akira'),
        'priority' => 32,
        'panel'    => 'nova_theme_colors',
    ));

    // LIGHT MODE COLORS
    // 1. Primary Color (Light Mode)
    $wp_customize->add_setting('light_primary_color', array(
        'default'           => '#313a46',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_primary_color', array(
        'label'    => __('Primary Color', 'nova-ui-akira'),
        'description' => __('Main brand color used for primary elements.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_primary_color',
    )));

    // 2. Secondary/Accent Color (Light Mode)
    $wp_customize->add_setting('light_secondary_color', array(
        'default'           => '#669776',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_secondary_color', array(
        'label'    => __('Secondary/Accent Color', 'nova-ui-akira'),
        'description' => __('Used for interactive elements and highlights.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_secondary_color',
    )));

    // 3. Link Color (Light Mode)
    $wp_customize->add_setting('light_link_color', array(
        'default'           => '#669776',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_link_color', array(
        'label'    => __('Link Color', 'nova-ui-akira'),
        'description' => __('Color for text links.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_link_color',
    )));

    // 4. Link Hover Color (Light Mode)
    $wp_customize->add_setting('light_link_hover_color', array(
        'default'           => '#ed6060',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_link_hover_color', array(
        'label'    => __('Link Hover Color', 'nova-ui-akira'),
        'description' => __('Color for links when hovered.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_link_hover_color',
    )));

    // 5. Menu Active Color (Light Mode)
    $wp_customize->add_setting('light_menu_active_color', array(
        'default'           => '#669776',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_menu_active_color', array(
        'label'    => __('Menu Active Item Color', 'nova-ui-akira'),
        'description' => __('Color for active menu items.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_menu_active_color',
    )));

    // 6. Menu Hover Color (Light Mode)
    $wp_customize->add_setting('light_menu_hover_color', array(
        'default'           => '#669776',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_menu_hover_color', array(
        'label'    => __('Menu Hover Color', 'nova-ui-akira'),
        'description' => __('Color for menu items when hovered.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_menu_hover_color',
    )));

    // 7. Background Color (Light Mode)
    $wp_customize->add_setting('light_background_color', array(
        'default'           => '#fffbf4',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_background_color', array(
        'label'    => __('Background Color', 'nova-ui-akira'),
        'description' => __('Main background color for light mode.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_background_color',
    )));

    // 8. Text Color (Light Mode)
    $wp_customize->add_setting('light_text_color', array(
        'default'           => '#4c4c5c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_text_color', array(
        'label'    => __('Text Color', 'nova-ui-akira'),
        'description' => __('Main text color for light mode.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_text_color',
    )));

    // 9. Selection Background Color (Light Mode)
    $wp_customize->add_setting('light_selection_background', array(
        'default'           => '#669776',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_selection_background', array(
        'label'    => __('Text Selection Background', 'nova-ui-akira'),
        'description' => __('Background color when text is selected.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_selection_background',
    )));

    // 10. Selection Text Color (Light Mode)
    $wp_customize->add_setting('light_selection_text', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'light_selection_text', array(
        'label'    => __('Text Selection Color', 'nova-ui-akira'),
        'description' => __('Text color when text is selected.', 'nova-ui-akira'),
        'section'  => 'nova_colors_light',
        'settings' => 'light_selection_text',
    )));

    // DARK MODE COLORS
    // 1. Primary Color (Dark Mode)
    $wp_customize->add_setting('dark_primary_color', array(
        'default'           => '#838990',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_primary_color', array(
        'label'    => __('Primary Color', 'nova-ui-akira'),
        'description' => __('Main brand color used for primary elements.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_primary_color',
    )));

    // 2. Secondary/Accent Color (Dark Mode)
    $wp_customize->add_setting('dark_secondary_color', array(
        'default'           => '#a3c1ad',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_secondary_color', array(
        'label'    => __('Secondary/Accent Color', 'nova-ui-akira'),
        'description' => __('Used for interactive elements and highlights.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_secondary_color',
    )));

    // 3. Link Color (Dark Mode)
    $wp_customize->add_setting('dark_link_color', array(
        'default'           => '#838990',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_link_color', array(
        'label'    => __('Link Color', 'nova-ui-akira'),
        'description' => __('Color for text links.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_link_color',
    )));

    // 4. Link Hover Color (Dark Mode)
    $wp_customize->add_setting('dark_link_hover_color', array(
        'default'           => '#969ba1',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_link_hover_color', array(
        'label'    => __('Link Hover Color', 'nova-ui-akira'),
        'description' => __('Color for links when hovered.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_link_hover_color',
    )));

    // 5. Menu Active Color (Dark Mode)
    $wp_customize->add_setting('dark_menu_active_color', array(
        'default'           => '#e2eeff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_menu_active_color', array(
        'label'    => __('Menu Active Item Color', 'nova-ui-akira'),
        'description' => __('Color for active menu items.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_menu_active_color',
    )));

    // 6. Menu Hover Color (Dark Mode)
    $wp_customize->add_setting('dark_menu_hover_color', array(
        'default'           => '#e2eeff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_menu_hover_color', array(
        'label'    => __('Menu Hover Color', 'nova-ui-akira'),
        'description' => __('Color for menu items when hovered.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_menu_hover_color',
    )));

    // 7. Background Color (Dark Mode)
    $wp_customize->add_setting('dark_background_color', array(
        'default'           => '#17181e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_background_color', array(
        'label'    => __('Background Color', 'nova-ui-akira'),
        'description' => __('Main background color for dark mode.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_background_color',
    )));

    // 8. Text Color (Dark Mode)
    $wp_customize->add_setting('dark_text_color', array(
        'default'           => '#aab8c5',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_text_color', array(
        'label'    => __('Text Color', 'nova-ui-akira'),
        'description' => __('Main text color for dark mode.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_text_color',
    )));

    // 9. Selection Background Color (Dark Mode)
    $wp_customize->add_setting('dark_selection_background', array(
        'default'           => '#a3c1ad',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_selection_background', array(
        'label'    => __('Text Selection Background', 'nova-ui-akira'),
        'description' => __('Background color when text is selected.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_selection_background',
    )));

    // 10. Selection Text Color (Dark Mode)
    $wp_customize->add_setting('dark_selection_text', array(
        'default'           => '#17181e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dark_selection_text', array(
        'label'    => __('Text Selection Color', 'nova-ui-akira'),
        'description' => __('Text color when text is selected.', 'nova-ui-akira'),
        'section'  => 'nova_colors_dark',
        'settings' => 'dark_selection_text',
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
    // Get the theme mode (light or dark)
    $theme_mode = 'light'; // Default to light mode
    
    // Check if a cookie or session variable exists to determine mode
    if (isset($_COOKIE['theme_mode']) && $_COOKIE['theme_mode'] === 'dark') {
        $theme_mode = 'dark';
    }
    
    // Light Mode Colors
    $light_primary_color = get_theme_mod('light_primary_color', '#313a46');
    $light_secondary_color = get_theme_mod('light_secondary_color', '#669776');
    $light_link_color = get_theme_mod('light_link_color', '#669776');
    $light_link_hover_color = get_theme_mod('light_link_hover_color', '#ed6060');
    $light_menu_active_color = get_theme_mod('light_menu_active_color', '#669776');
    $light_menu_hover_color = get_theme_mod('light_menu_hover_color', '#669776');
    $light_background_color = get_theme_mod('light_background_color', '#fffbf4');
    $light_text_color = get_theme_mod('light_text_color', '#4c4c5c');
    $light_selection_background = get_theme_mod('light_selection_background', '#669776');
    $light_selection_text = get_theme_mod('light_selection_text', '#ffffff');
    
    // Dark Mode Colors
    $dark_primary_color = get_theme_mod('dark_primary_color', '#838990');
    $dark_secondary_color = get_theme_mod('dark_secondary_color', '#a3c1ad');
    $dark_link_color = get_theme_mod('dark_link_color', '#838990');
    $dark_link_hover_color = get_theme_mod('dark_link_hover_color', '#969ba1');
    $dark_menu_active_color = get_theme_mod('dark_menu_active_color', '#e2eeff');
    $dark_menu_hover_color = get_theme_mod('dark_menu_hover_color', '#e2eeff');
    $dark_background_color = get_theme_mod('dark_background_color', '#17181e');
    $dark_text_color = get_theme_mod('dark_text_color', '#aab8c5');
    $dark_selection_background = get_theme_mod('dark_selection_background', '#a3c1ad');
    $dark_selection_text = get_theme_mod('dark_selection_text', '#17181e');
    
    // Create CSS
    $custom_css = "
        /* Light Mode Variables */
        :root {
            --bs-primary: {$light_primary_color};
            --bs-secondary: {$light_secondary_color};
            --bs-primary-rgb: " . implode(',', nova_hex_to_rgb($light_primary_color)) . ";
            --bs-secondary-rgb: " . implode(',', nova_hex_to_rgb($light_secondary_color)) . ";
            --bs-link-color: {$light_link_color};
            --bs-link-hover-color: {$light_link_hover_color};
            --bs-link-color-rgb: " . implode(',', nova_hex_to_rgb($light_link_color)) . ";
            --bs-link-hover-color-rgb: " . implode(',', nova_hex_to_rgb($light_link_hover_color)) . ";
            --bs-body-color: {$light_text_color};
            --bs-body-bg: {$light_background_color};
            --bs-body-color-rgb: " . implode(',', nova_hex_to_rgb($light_text_color)) . ";
            --bs-body-bg-rgb: " . implode(',', nova_hex_to_rgb($light_background_color)) . ";
        }
        
        /* Menu customization - Light Mode */
        :root[data-menu-color=light] {
            --bs-menu-item-hover-color: {$light_menu_hover_color};
            --bs-menu-item-active-color: {$light_menu_active_color};
        }
        
        /* Text selection - Light Mode */
        :root[data-bs-theme=light] ::selection {
            background-color: {$light_selection_background};
            color: {$light_selection_text};
        }
        
        /* Dark Mode Variables */
        :root[data-bs-theme=dark] {
            --bs-primary: {$dark_primary_color};
            --bs-secondary: {$dark_secondary_color};
            --bs-primary-rgb: " . implode(',', nova_hex_to_rgb($dark_primary_color)) . ";
            --bs-secondary-rgb: " . implode(',', nova_hex_to_rgb($dark_secondary_color)) . ";
            --bs-link-color: {$dark_link_color};
            --bs-link-hover-color: {$dark_link_hover_color};
            --bs-link-color-rgb: " . implode(',', nova_hex_to_rgb($dark_link_color)) . ";
            --bs-link-hover-color-rgb: " . implode(',', nova_hex_to_rgb($dark_link_hover_color)) . ";
            --bs-body-color: {$dark_text_color};
            --bs-body-bg: {$dark_background_color};
            --bs-body-color-rgb: " . implode(',', nova_hex_to_rgb($dark_text_color)) . ";
            --bs-body-bg-rgb: " . implode(',', nova_hex_to_rgb($dark_background_color)) . ";
        }
        
        /* Menu customization - Dark Mode */
        :root[data-bs-theme=dark][data-menu-color=light],
        :root[data-bs-theme=dark][data-menu-color=dark] {
            --bs-menu-item-hover-color: {$dark_menu_hover_color};
            --bs-menu-item-active-color: {$dark_menu_active_color};
        }
        
        /* Text selection - Dark Mode */
        :root[data-bs-theme=dark] ::selection {
            background-color: {$dark_selection_background};
            color: {$dark_selection_text};
        }
    ";
    
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
