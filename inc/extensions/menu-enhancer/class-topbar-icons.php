<?php
/**
 * Topbar Icons Menu Class
 * 
 * Adds functionality for topbar icons menu
 * 
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Topbar Icons Menu Class
 */
class Nova_Topbar_Icons {
    
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
        // Register the topbar icons menu location
        add_action('after_setup_theme', array($this, 'register_topbar_icons_menu'));
        
        // Add admin notice
        add_action('admin_notices', array($this, 'admin_notices'), 25);
        
        // Create default menu
        add_action('after_setup_theme', array($this, 'create_default_topbar_icons_menu'));
    }
    
    /**
     * Register topbar icons menu location
     */
    public function register_topbar_icons_menu() {
        // Check if location already registered
        $locations = get_registered_nav_menus();
        if (isset($locations['topbar_icons'])) {
            return;
        }
        
        // Register the new menu location
        register_nav_menu('topbar_icons', esc_html__('Topbar Icons Menu', 'nova-ui-akira'));
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
        
        // Check if we're editing the topbar icons menu
        $nav_menu_selected_id = isset($_REQUEST['menu']) ? (int) $_REQUEST['menu'] : 0;
        if (!$nav_menu_selected_id) {
            return;
        }
        
        $locations = get_nav_menu_locations();
        if (!isset($locations['topbar_icons']) || $locations['topbar_icons'] != $nav_menu_selected_id) {
            return;
        }
        
        // Show notice about topbar icons menu
        ?>
        <div class="notice notice-info is-dismissible">
            <p>
                <?php 
                echo sprintf(
                    esc_html__('You are editing the Topbar Icons Menu. Each menu item will appear as an icon button in the top bar. Only the icon will be shown, not the text. Use the icon field for each menu item to set the icon. Example icons: %1$s, %2$s, %3$s, %4$s', 'nova-ui-akira'),
                    '<code>ti ti-flag</code>',
                    '<code>ti ti-bell</code>',
                    '<code>ti ti-apps</code>',
                    '<code>ti ti-settings</code>'
                ); 
                ?>
                <a href="https://tabler-icons.io/" target="_blank" rel="noopener">
                    <?php esc_html_e('Browse all icons', 'nova-ui-akira'); ?>
                </a>
            </p>
        </div>
        <?php
    }
    
    /**
     * Create default topbar icons menu
     */
    public function create_default_topbar_icons_menu() {
        $locations = get_nav_menu_locations();
        
        // Check if topbar icons menu location is assigned
        if (isset($locations['topbar_icons']) && $locations['topbar_icons'] > 0) {
            return;
        }
        
        // Create a menu if it doesn't exist
        $menu_name = 'Topbar Icons';
        $menu_exists = wp_get_nav_menu_object($menu_name);
        
        if (!$menu_exists) {
            $menu_id = wp_create_nav_menu($menu_name);
            
            // Add default menu items - we'll add metadata for icons later
            
            // US Flag Icon
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Language', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-flag');
            
            // Notifications Icon
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Notifications', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-bell');
            
            // Apps Grid Icon
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Apps', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-apps');
            
            // Settings Icon
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title'  => esc_html__('Settings', 'nova-ui-akira'),
                'menu-item-status' => 'publish',
                'menu-item-type'   => 'custom',
                'menu-item-url'    => '#',
            ));
            update_post_meta($item_id, '_nova_menu_item_icon', 'ti ti-settings');
            
            // Assign menu to the topbar_icons location
            $locations = get_nav_menu_locations();
            $locations['topbar_icons'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
    
    /**
     * Render the topbar icons menu
     */
    public static function render_topbar_icons() {
        if (!has_nav_menu('topbar_icons')) {
            // No menu assigned, so don't display anything
            return;
        }
        
        wp_nav_menu(array(
            'theme_location' => 'topbar_icons',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'walker'         => new Nova_Topbar_Icons_Walker(),
            'fallback_cb'    => false,
        ));
    }
}

// Initialize the topbar icons menu
Nova_Topbar_Icons::get_instance();
