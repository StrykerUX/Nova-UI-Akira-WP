<?php
/**
 * Menu Enhancer Extension
 *
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('NOVA_MENU_ENHANCER_DIR', dirname(__FILE__));
define('NOVA_MENU_ENHANCER_URL', get_template_directory_uri() . '/inc/extensions/menu-enhancer');

/**
 * Main Menu Enhancer Class
 */
class Nova_Menu_Enhancer {
    
    /**
     * Instance of this class
     */
    private static $instance = null;
    
    /**
     * Return an instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        // Load required files
        $this->load_files();
        
        // Initialize components
        $this->init_components();
        
        // Register assets
        add_action('wp_enqueue_scripts', array($this, 'register_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'register_admin_assets'));
    }
    
    /**
     * Load required files
     */
    private function load_files() {
        // Load main classes
        require_once NOVA_MENU_ENHANCER_DIR . '/class-menu-icons.php';
        
        // Load admin files on admin pages only
        if (is_admin()) {
            require_once NOVA_MENU_ENHANCER_DIR . '/admin/admin.php';
        }
    }
    
    /**
     * Initialize components
     */
    private function init_components() {
        // Initialize Menu Icons
        Nova_Menu_Icons::get_instance();
    }
    
    /**
     * Register frontend assets
     */
    public function register_frontend_assets() {
        // CSS
        wp_enqueue_style('nova-menu-enhancer', NOVA_MENU_ENHANCER_URL . '/assets/css/menu-enhancer.css', array(), NOVA_VERSION);
        
        // Load Lucide fix before the theme's main JavaScript
        wp_enqueue_script('nova-lucide-fix', NOVA_MENU_ENHANCER_URL . '/assets/js/lucide-fix.js', array(), NOVA_VERSION, false);
    }
    
    /**
     * Register admin assets
     */
    public function register_admin_assets($hook) {
        // Only load on nav-menus.php page
        if ('nav-menus.php' !== $hook) {
            return;
        }
        
        // CSS
        wp_enqueue_style('nova-menu-enhancer-admin', NOVA_MENU_ENHANCER_URL . '/assets/css/menu-enhancer-admin.css', array(), NOVA_VERSION);
        
        // JS
        wp_enqueue_script('nova-menu-enhancer-admin', NOVA_MENU_ENHANCER_URL . '/assets/js/menu-enhancer-admin.js', array('jquery'), NOVA_VERSION, true);
    }
}

// Initialize the menu enhancer
Nova_Menu_Enhancer::get_instance();
