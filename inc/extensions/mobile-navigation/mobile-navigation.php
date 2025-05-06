<?php
/**
 * Mobile Navigation Extension
 * 
 * Adds a responsive mobile navigation menu for Dashboard and Dashboard Overflow templates
 *
 * @package Nova_UI_Akira
 * @subpackage Extensions
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants for this extension
define('NOVA_MOBILE_NAV_DIR', trailingslashit(get_template_directory()) . 'inc/extensions/mobile-navigation');
define('NOVA_MOBILE_NAV_URI', trailingslashit(get_template_directory_uri()) . 'inc/extensions/mobile-navigation');

/**
 * Mobile Navigation Main Class
 */
class Nova_Mobile_Navigation {
    
    /**
     * Instance of this class
     */
    private static $instance = null;
    
    /**
     * Get single instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        // Register hooks and actions
        $this->init_hooks();
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Register new menu location
        add_action('after_setup_theme', array($this, 'register_mobile_menu'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        
        // Add mobile navigation to dashboard templates
        add_action('nova_after_dashboard_content', array($this, 'add_mobile_navigation'));
        add_action('nova_after_dashboard_overflow_content', array($this, 'add_mobile_navigation'));
        
        // Filter dashboard template content to remove header/sidebar/footer on mobile
        add_filter('template_include', array($this, 'template_loader'), 99);
    }
    
    /**
     * Register mobile menu location
     */
    public function register_mobile_menu() {
        register_nav_menus(array(
            'mobile_menu' => esc_html__('Mobile Menu', 'nova-ui-akira'),
            'mobile_icons' => esc_html__('Mobile Icons Menu', 'nova-ui-akira'),
        ));
    }
    
    /**
     * Enqueue mobile navigation assets
     */
    public function enqueue_assets() {
        // Only load on dashboard templates
        if (is_page_template('page-templates/template-dashboard.php') || 
            is_page_template('page-templates/template-dashboard-overflow.php')) {
            
            // CSS for mobile navigation
            wp_enqueue_style(
                'nova-mobile-navigation', 
                NOVA_MOBILE_NAV_URI . '/assets/css/mobile-navigation.css',
                array('nova-app'),
                NOVA_VERSION
            );
            
            // JS for mobile navigation
            wp_enqueue_script(
                'nova-mobile-navigation',
                NOVA_MOBILE_NAV_URI . '/assets/js/mobile-navigation.js',
                array('jquery'),
                NOVA_VERSION,
                true
            );
        }
    }
    
    /**
     * Template loader to modify dashboard templates
     */
    public function template_loader($template) {
        // Only for dashboard templates
        if (is_page_template('page-templates/template-dashboard.php') || 
            is_page_template('page-templates/template-dashboard-overflow.php')) {
            
            // Add body class for mobile navigation
            add_filter('body_class', function($classes) {
                $classes[] = 'has-mobile-navigation';
                return $classes;
            });
        }
        
        return $template;
    }
    
    /**
     * Add mobile navigation to dashboard templates
     */
    public function add_mobile_navigation() {
        // Only display on mobile viewports (handled by CSS)
        include NOVA_MOBILE_NAV_DIR . '/templates/mobile-navigation.php';
    }
}

// Initialize the mobile navigation
Nova_Mobile_Navigation::get_instance();

/**
 * Add action hooks to dashboard templates
 */
add_action('nova_after_dashboard_template', function() {
    // Add mobile navigation to Dashboard template
    do_action('nova_after_dashboard_content');
});

add_action('nova_after_dashboard_overflow_template', function() {
    // Add mobile navigation to Dashboard Overflow template
    do_action('nova_after_dashboard_overflow_content');
});
