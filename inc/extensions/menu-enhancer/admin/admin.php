<?php
/**
 * Menu Enhancer Admin
 *
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin Class for Menu Enhancer
 */
class Nova_Menu_Enhancer_Admin {
    
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
        // Add admin notices about the extension
        add_action('admin_notices', array($this, 'admin_notices'));
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
        
        // Get the menu being edited
        $nav_menu_selected_id = isset($_REQUEST['menu']) ? (int) $_REQUEST['menu'] : 0;
        
        // If no menu is selected, don't show notice
        if (!$nav_menu_selected_id) {
            return;
        }
        
        // Show notice about the menu enhancer
        ?>
        <div class="notice notice-info is-dismissible">
            <p>
                <?php 
                echo sprintf(
                    esc_html__('Nova UI Menu Enhancer: You can add icons to menu items by editing each item and setting an icon class. Examples: %1$s, %2$s, %3$s', 'nova-ui-akira'),
                    '<code>ti ti-home</code>',
                    '<code>ti ti-user</code>',
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
}

// Initialize the admin class
Nova_Menu_Enhancer_Admin::get_instance();
