/**
 * Ensure jQuery is loaded correctly for our theme
 */
function nova_jquery_setup() {
    // Asegurarse de que jquery se carga en el footer con dependencia jquery-core
    // Esto evita conflictos con otras versiones de jQuery
    if (!is_admin()) {
        wp_deregister_script('jquery-migrate');
        wp_register_script('jquery-migrate', includes_url('/js/jquery/jquery-migrate.min.js'), array('jquery-core'), null, true);
        wp_enqueue_script('jquery', false, array('jquery-core', 'jquery-migrate'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'nova_jquery_setup', 1);

<?php
/**
 * Theme functions and definitions
 *
 * @package Nova_UI_Akira
 */

/**
 * Ensure jQuery is loaded correctly for our theme
 */
function nova_jquery_setup() {
    // Asegurarse de que jquery se carga en el footer con dependencia jquery-core
    // Esto evita conflictos con otras versiones de jQuery
    if (!is_admin()) {
        wp_deregister_script('jquery-migrate');
        wp_register_script('jquery-migrate', includes_url('/js/jquery/jquery-migrate.min.js'), array('jquery-core'), null, true);
        wp_enqueue_script('jquery', false, array('jquery-core', 'jquery-migrate'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'nova_jquery_setup', 1);

// Define constants
define('NOVA_VERSION', '1.0.0');
define('NOVA_TEMPLATE_DIR', get_template_directory());
define('NOVA_TEMPLATE_URI', get_template_directory_uri());

/**
 * Setup theme
 */
function nova_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary'   => esc_html__('Primary Menu', 'nova-ui-akira'),
        'topbar'    => esc_html__('Topbar Menu', 'nova-ui-akira'),
        'footer'    => esc_html__('Footer Menu', 'nova-ui-akira'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add theme support for Custom Logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for editor styles
    add_theme_support('editor-styles');

    // Load default block styles
    add_theme_support('wp-block-styles');

    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'nova_setup');

/**
 * Enqueue scripts and styles
 */
function nova_scripts() {
    // Bootstrap CSS
    wp_enqueue_style('bootstrap', NOVA_TEMPLATE_URI . '/assets/css/bootstrap.min.css', array(), NOVA_VERSION);

    // Icon CSS
    wp_enqueue_style('tabler-icons', NOVA_TEMPLATE_URI . '/assets/css/tabler-icons.min.css', array(), NOVA_VERSION);
    
    // Theme CSS
    wp_enqueue_style('nova-app', NOVA_TEMPLATE_URI . '/assets/css/app.min.css', array('bootstrap'), NOVA_VERSION);
    wp_enqueue_style('nova-theme', NOVA_TEMPLATE_URI . '/assets/css/theme.min.css', array('nova-app'), NOVA_VERSION);
    
    // Main Theme Stylesheet
    wp_enqueue_style('nova-style', get_stylesheet_uri(), array(), NOVA_VERSION);

    // jQuery (ya registrado en nova_jquery_setup)

    // Lucide Icons
    wp_enqueue_script('lucide-icons', 'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js', array(), null, true);

    // Bootstrap Bundle (incluye Popper)
    wp_enqueue_script('bootstrap-bundle', NOVA_TEMPLATE_URI . '/assets/js/bootstrap.bundle.min.js', array('jquery'), NOVA_VERSION, true);

    // Simplebar
    wp_enqueue_script('simplebar', NOVA_TEMPLATE_URI . '/assets/js/simplebar.min.js', array('jquery'), NOVA_VERSION, true);

    // Theme JS
    wp_enqueue_script('nova-layout', NOVA_TEMPLATE_URI . '/assets/js/layout.js', array('jquery', 'bootstrap-bundle'), NOVA_VERSION, true);
    wp_enqueue_script('nova-theme', NOVA_TEMPLATE_URI . '/assets/js/theme.js', array('jquery', 'bootstrap-bundle'), NOVA_VERSION, true);

    // Main JS - Asegurarse de que depende de jQuery
    wp_enqueue_script('nova-app', NOVA_TEMPLATE_URI . '/assets/js/app.js', array('jquery', 'bootstrap-bundle', 'simplebar', 'lucide-icons', 'nova-layout', 'nova-theme'), NOVA_VERSION, true);

    // Comment Reply
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'nova_scripts');

/**
 * Register sidebars
 */
function nova_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'nova-ui-akira'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'nova-ui-akira'),
        'before_widget' => '<div id="%1$s" class="card mb-4 %2$s">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="card-header"><h5 class="card-title mb-0">',
        'after_title'   => '</h5></div><div class="card-body">',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'nova-ui-akira'),
        'id'            => 'footer-1',
        'description'   => esc_html__('First footer column.', 'nova-ui-akira'),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="text-uppercase mb-3">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'nova-ui-akira'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Second footer column.', 'nova-ui-akira'),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="text-uppercase mb-3">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'nova-ui-akira'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Third footer column.', 'nova-ui-akira'),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="text-uppercase mb-3">',
        'after_title'   => '</h5>',
    ));
}
add_action('widgets_init', 'nova_widgets_init');

/**
 * Custom template tags
 */
require NOVA_TEMPLATE_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress
 */
require NOVA_TEMPLATE_DIR . '/inc/template-functions.php';

/**
 * Customizer additions
 */
require NOVA_TEMPLATE_DIR . '/inc/customizer.php';

/**
 * Custom comment template
 */
require NOVA_TEMPLATE_DIR . '/inc/comment-template.php';

/**
 * Reading time calculation
 */
require NOVA_TEMPLATE_DIR . '/inc/reading-time.php';
