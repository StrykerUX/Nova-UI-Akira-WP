<?php
/**
 * Mobile Menu Extension
 *
 * Adds a responsive mobile menu at the bottom of the screen for small devices.
 *
 * @package Nova_UI_Akira
 * @subpackage Mobile_Menu
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('NOVA_MOBILE_MENU_DIR', dirname(__FILE__));
define('NOVA_MOBILE_MENU_URL', get_template_directory_uri() . '/inc/extensions/mobile-menu');

/**
 * Main Mobile Menu Class
 */
class Nova_Mobile_Menu {
    
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
        
        // Register menu locations
        add_action('after_setup_theme', array($this, 'register_mobile_menu_locations'));
        
        // Register assets
        add_action('wp_enqueue_scripts', array($this, 'register_assets'));
        
        // Add mobile menu to footer
        add_action('wp_footer', array($this, 'render_mobile_menu'));
        
        // Create default menus
        add_action('after_setup_theme', array($this, 'create_default_menus'));
        
        // Add customizer options
        add_action('customize_register', array($this, 'customize_register'));
    }
    
    /**
     * Load required files
     */
    private function load_files() {
        // Load the walker classes
        require_once NOVA_MOBILE_MENU_DIR . '/class-mobile-menu-walker.php';
        require_once NOVA_MOBILE_MENU_DIR . '/class-more-menu-walker.php';
    }
    
    /**
     * Register menu locations
     */
    public function register_mobile_menu_locations() {
        register_nav_menu('mobile_bottom_menu', esc_html__('Mobile Bottom Menu', 'nova-ui-akira'));
        register_nav_menu('mobile_more_menu', esc_html__('Mobile More Menu', 'nova-ui-akira'));
    }
    
    /**
     * Register assets
     */
    public function register_assets() {
        // CSS
        wp_enqueue_style('nova-mobile-menu', NOVA_MOBILE_MENU_URL . '/css/mobile-menu.css', array('nova-style'), NOVA_VERSION);
        
        // JavaScript
        wp_enqueue_script('nova-mobile-menu', NOVA_MOBILE_MENU_URL . '/js/mobile-menu.js', array('jquery'), NOVA_VERSION, true);
    }
    

    
    /**
     * Render mobile menu in footer
     */
    public function render_mobile_menu() {
        // Only render if mobile menu is enabled
        if (get_theme_mod('nova_enable_mobile_menu', true) !== true) {
            return;
        }
        
        // Mobile Bottom Navigation
        echo '<nav class="mobile-bottom-nav d-md-none">';
        echo '<div class="mobile-bottom-nav-items">';
        
        // Display WordPress menu if available
        if (has_nav_menu('mobile_bottom_menu')) {
            wp_nav_menu(array(
                'theme_location' => 'mobile_bottom_menu',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'depth'          => 1,
                'walker'         => new Nova_Mobile_Menu_Walker(),
            ));
        } else {
            // Default items if no menu assigned
            echo '<a href="' . esc_url(home_url('/')) . '" class="mobile-nav-item active">';
            echo '<i class="ti ti-home"></i>';
            echo '<span>' . esc_html__('Home', 'nova-ui-akira') . '</span>';
            echo '</a>';
            
            echo '<a href="#" class="mobile-nav-item">';
            echo '<i class="ti ti-robot"></i>';
            echo '<span>' . esc_html__('AI Assistants', 'nova-ui-akira') . '</span>';
            echo '</a>';
            
            echo '<a href="#" class="mobile-nav-item">';
            echo '<i class="ti ti-bolt"></i>';
            echo '<span>' . esc_html__('Quick Links', 'nova-ui-akira') . '</span>';
            echo '</a>';
        }
        
        // More menu toggle always present
        echo '<a href="#" class="mobile-nav-item" id="more-menu-toggle">';
        echo '<i class="ti ti-dots-vertical"></i>';
        echo '<span>' . esc_html__('More', 'nova-ui-akira') . '</span>';
        echo '</a>';
        
        echo '</div>'; // .mobile-bottom-nav-items
        echo '</nav>';
        
        // More Menu Fullscreen Overlay
        echo '<div class="mobile-more-menu">';
        echo '<div class="mobile-more-menu-header">';
        echo '<h5>' . esc_html__('More Options', 'nova-ui-akira') . '</h5>';
        echo '<button class="close-more-menu btn btn-icon"><i class="ti ti-x"></i></button>';
        echo '</div>';
        echo '<div class="mobile-more-menu-content">';
        
        // Display WordPress menu if available
        if (has_nav_menu('mobile_more_menu')) {
            wp_nav_menu(array(
                'theme_location' => 'mobile_more_menu',
                'container'      => false,
                'items_wrap'     => '<div class="more-menu-items">%3$s</div>',
                'depth'          => 1,
                'walker'         => new Nova_More_Menu_Walker(),
            ));
        } else {
            // Default items if no menu assigned
            echo '<a href="#" class="more-menu-item">';
            echo '<i class="ti ti-tools"></i>';
            echo '<span>' . esc_html__('Other Tools', 'nova-ui-akira') . '</span>';
            echo '</a>';
            
            echo '<a href="#" class="more-menu-item">';
            echo '<i class="ti ti-help-circle"></i>';
            echo '<span>' . esc_html__('Support', 'nova-ui-akira') . '</span>';
            echo '</a>';
            
            echo '<a href="#" class="more-menu-item">';
            echo '<i class="ti ti-credit-card"></i>';
            echo '<span>' . esc_html__('My Subscription', 'nova-ui-akira') . '</span>';
            echo '</a>';
            
            echo '<a href="#" class="more-menu-item">';
            echo '<i class="ti ti-user"></i>';
            echo '<span>' . esc_html__('My Profile', 'nova-ui-akira') . '</span>';
            echo '</a>';
            
            echo '<a href="#" class="more-menu-item">';
            echo '<i class="ti ti-settings"></i>';
            echo '<span>' . esc_html__('Preferences and Security', 'nova-ui-akira') . '</span>';
            echo '</a>';
        }
        
        // Add mobile utility buttons
        echo '<div class="mobile-more-menu-utils">';
        
        // Dark/Light mode toggle - Icon only
        echo '<button id="mobile-dark-light-toggle" class="btn btn-outline-primary btn-icon">';
        echo '<i class="ti ti-moon"></i>';
        echo '</button>';
        
        // Search button - Icon only
        echo '<button class="btn btn-outline-primary btn-icon" data-bs-toggle="modal" data-bs-target="#searchModal">';
        echo '<i class="ti ti-search"></i>';
        echo '</button>';
        
        echo '</div>'; // .mobile-more-menu-utils
        
        echo '</div>'; // .mobile-more-menu-content
        echo '</div>'; // .mobile-more-menu
    }
    
    /**
     * Create default menus if they don't exist
     */
    public function create_default_menus() {
        $locations = get_nav_menu_locations();
        
        // Create mobile bottom menu if it doesn't exist
        if (!isset($locations['mobile_bottom_menu']) || $locations['mobile_bottom_menu'] <= 0) {
            $this->create_default_bottom_menu();
        }
        
        // Create mobile more menu if it doesn't exist
        if (!isset($locations['mobile_more_menu']) || $locations['mobile_more_menu'] <= 0) {
            $this->create_default_more_menu();
        }
    }
    
    /**
     * Create default bottom menu
     */
    private function create_default_bottom_menu() {
        $menu_name = 'Mobile Bottom Menu';
        $menu_exists = wp_get_nav_menu_object($menu_name);
        
        if (!$menu_exists) {
            $menu_id = wp_create_nav_menu($menu_name);
            
            // Add default menu items
            
            // Home
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Home', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => home_url('/'),
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-home');
            
            // AI Assistants
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('AI Assistants', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-robot');
            
            // Quick Links
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Quick Links', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-bolt');
            
            // Assign menu to location
            $locations = get_nav_menu_locations();
            $locations['mobile_bottom_menu'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
    
    /**
     * Create default more menu
     */
    private function create_default_more_menu() {
        $menu_name = 'Mobile More Menu';
        $menu_exists = wp_get_nav_menu_object($menu_name);
        
        if (!$menu_exists) {
            $menu_id = wp_create_nav_menu($menu_name);
            
            // Add default menu items
            
            // Other Tools
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Other Tools', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-tools');
            
            // Support
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Support', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-help-circle');
            
            // My Subscription
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('My Subscription', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-credit-card');
            
            // My Profile
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('My Profile', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-user');
            
            // Preferences and Security
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Preferences and Security', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-settings');
            
            // Assign menu to location
            $locations = get_nav_menu_locations();
            $locations['mobile_more_menu'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
    
    /**
     * Add customizer options
     */
    public function customize_register($wp_customize) {
        // Add Mobile Menu section
        $wp_customize->add_section('nova_mobile_menu_section', array(
            'title'       => esc_html__('Mobile Menu', 'nova-ui-akira'),
            'description' => esc_html__('Customize the mobile menu settings.', 'nova-ui-akira'),
            'priority'    => 120,
        ));
        
        // Enable Mobile Menu
        $wp_customize->add_setting('nova_enable_mobile_menu', array(
            'default'           => true,
            'sanitize_callback' => 'nova_sanitize_checkbox', // This function is already defined in customizer.php
        ));
        
        $wp_customize->add_control('nova_enable_mobile_menu', array(
            'label'    => esc_html__('Enable Mobile Menu', 'nova-ui-akira'),
            'section'  => 'nova_mobile_menu_section',
            'type'     => 'checkbox',
        ));
    }
}

// Initialize the mobile menu
Nova_Mobile_Menu::get_instance();
