<?php
/**
 * User Menu Class
 * 
 * Adds user menu functionality
 * 
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * User Menu Class
 */
class Nova_User_Menu {
    
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
        // Add admin notice about the user menu
        add_action('admin_notices', array($this, 'admin_notices'), 20);
        
        // Add default menu items if the menu doesn't exist
        add_action('after_setup_theme', array($this, 'create_default_user_menu'));
    }
    
    /**
     * Admin notices
     */
    public function admin_notices() {
        $screen = get_current_screen();
        
        // Only show on nav-menus.php page
        if (!$screen || $screen->id !== 'nav-menus') {
            return;
        }
        
        // Check if we're editing the user menu
        $nav_menu_selected_id = isset($_REQUEST['menu']) ? (int) $_REQUEST['menu'] : 0;
        if (!$nav_menu_selected_id) {
            return;
        }
        
        $locations = get_nav_menu_locations();
        if (!isset($locations['user_menu']) || $locations['user_menu'] != $nav_menu_selected_id) {
            return;
        }
        
        // Show notice about user menu
        ?>
        <div class="notice notice-info is-dismissible">
            <p>
                <?php 
                echo sprintf(
                    esc_html__('You are editing the User Menu. You can add these CSS classes to menu items for special formatting: %1$s (for section titles), %2$s (for dividers).', 'nova-ui-akira'),
                    '<code>menu-header</code>',
                    '<code>menu-divider</code>'
                ); 
                ?>
            </p>
        </div>
        <?php
    }
    
    /**
     * Create default user menu if it doesn't exist
     */
    public function create_default_user_menu() {
        $locations = get_nav_menu_locations();
        
        // Check if user menu location is assigned
        if (isset($locations['user_menu']) && $locations['user_menu'] > 0) {
            return;
        }
        
        // Create a menu if it doesn't exist
        $menu_name = 'User Menu';
        $menu_exists = wp_get_nav_menu_object($menu_name);
        
        if (!$menu_exists) {
            $menu_id = wp_create_nav_menu($menu_name);
            
            // Add default menu items
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Welcome !', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-classes'=> 'menu-header',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            
            // My Account link
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('My Account', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => admin_url('profile.php'),
            ));
            
            // Add Dashboard link for admins only (will be filtered in front-end)
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Dashboard', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => admin_url(),
                'menu-item-attr-title' => 'admin-only', // This will be used to show/hide for admins
            ));
            
            // Divider
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Divider', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-classes'=> 'menu-divider',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            
            // Logout link
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Sign Out', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => wp_logout_url(home_url()),
            ));
            
            // Assign menu to the user_menu location
            $locations = get_nav_menu_locations();
            $locations['user_menu'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
    
    /**
     * Render the user menu
     */
    public static function render_user_menu() {
        if (!has_nav_menu('user_menu')) {
            // Fallback to default hardcoded menu
            self::render_default_user_menu();
            return;
        }
        
        wp_nav_menu(array(
            'theme_location' => 'user_menu',
            'container'      => false,
            'fallback_cb'    => array('Nova_User_Menu', 'render_default_user_menu'),
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'walker'         => new Nova_User_Menu_Walker(),
        ));
    }
    
    /**
     * Render default user menu as fallback
     */
    public static function render_default_user_menu() {
        ?>
        <!-- Default User Menu -->
        <div class="dropdown-header noti-title">
            <h6 class="text-overflow m-0"><?php esc_html_e('Welcome !', 'nova-ui-akira'); ?></h6>
        </div>

        <!-- item-->
        <a href="<?php echo esc_url(admin_url('profile.php')); ?>" class="dropdown-item">
            <i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
            <span class="align-middle"><?php esc_html_e('My Account', 'nova-ui-akira'); ?></span>
        </a>

        <?php if (current_user_can('manage_options')) : ?>
        <!-- item-->
        <a href="<?php echo esc_url(admin_url()); ?>" class="dropdown-item">
            <i class="ti ti-settings me-1 fs-17 align-middle"></i>
            <span class="align-middle"><?php esc_html_e('Dashboard', 'nova-ui-akira'); ?></span>
        </a>
        <?php endif; ?>

        <div class="dropdown-divider"></div>

        <!-- item-->
        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="dropdown-item active fw-semibold text-danger">
            <i class="ti ti-logout me-1 fs-17 align-middle"></i>
            <span class="align-middle"><?php esc_html_e('Sign Out', 'nova-ui-akira'); ?></span>
        </a>
        <?php
    }
}

// Initialize the user menu
Nova_User_Menu::get_instance();
