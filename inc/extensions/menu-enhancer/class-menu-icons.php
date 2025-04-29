<?php
/**
 * Menu Icons Class
 * 
 * Adds icon functionality to WordPress menus
 * 
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Menu Icons Class
 */
class Nova_Menu_Icons {
    
    /**
     * Instance of this class
     */
    private static $instance = null;
    
    /**
     * Icon field name
     */
    private $meta_key = '_nova_menu_item_icon';
    
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
        // Add custom fields to menu item
        add_action('wp_nav_menu_item_custom_fields', array($this, 'menu_item_custom_fields'), 10, 4);
        
        // Save menu item meta
        add_action('wp_update_nav_menu_item', array($this, 'save_menu_item_meta'), 10, 3);
        
        // Filter menu items for front-end display
        add_filter('walker_nav_menu_start_el', array($this, 'walker_nav_menu_start_el'), 10, 4);
        
        // Filter menu items for the sidebar display
        add_filter('wp_get_nav_menu_items', array($this, 'add_icons_to_menu_items'), 10, 3);
        
        // Add filter to header.php sidebar menu rendering
        add_filter('wp_setup_nav_menu_item', array($this, 'setup_nav_menu_item'), 10, 1);
        
        // Modify the header.php sidebar menu rendering
        add_action('after_setup_theme', array($this, 'modify_header_sidebar_menu'));
    }
    
    /**
     * Add custom fields to menu item
     */
    public function menu_item_custom_fields($item_id, $item, $depth, $args) {
        $icon = get_post_meta($item_id, $this->meta_key, true);
        ?>
        <div class="field-nova-icon description-wide">
            <p class="description">
                <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e('Icon (Tabler Icons Class)', 'nova-ui-akira'); ?><br>
                    <input type="text" 
                           id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" 
                           class="widefat code edit-menu-item-icon" 
                           name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" 
                           value="<?php echo esc_attr($icon); ?>" 
                           placeholder="ti ti-home" />
                </label>
            </p>
            <p class="description">
                <?php esc_html_e('Enter Tabler icon class name. Example: ti ti-home', 'nova-ui-akira'); ?>
                <a href="https://tabler-icons.io/" target="_blank" rel="noopener">
                    <?php esc_html_e('Browse icons', 'nova-ui-akira'); ?>
                </a>
            </p>
        </div>
        <?php
    }
    
    /**
     * Save menu item meta
     */
    public function save_menu_item_meta($menu_id, $menu_item_db_id, $menu_item_args) {
        // Check if we have icon data to save
        if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
            $icon = sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, $this->meta_key, $icon);
        }
    }
    
    /**
     * Filter menu items for front-end display
     */
    public function walker_nav_menu_start_el($item_output, $item, $depth, $args) {
        // Only add icons to first level items
        if (isset($item->ID)) {
            $icon = get_post_meta($item->ID, $this->meta_key, true);
            
            if (!empty($icon)) {
                // Find the position to insert the icon
                if (isset($args->theme_location) && $args->theme_location === 'primary') {
                    // For primary menu (sidebar)
                    $item_output = preg_replace('/(<a[^>]*>)/', '$1<span class="menu-icon"><i class="' . esc_attr($icon) . '"></i></span> ', $item_output);
                } else {
                    // For other menus
                    $item_output = preg_replace('/(<a[^>]*>)/', '$1<i class="' . esc_attr($icon) . ' me-1"></i> ', $item_output);
                }
            }
        }
        
        return $item_output;
    }
    
    /**
     * Add icons to menu items for the custom sidebar walker
     * This is needed because the sidebar menu uses a custom walker in header.php
     */
    public function add_icons_to_menu_items($items, $menu, $args) {
        if (!is_array($items)) {
            return $items;
        }
        
        foreach ($items as $item) {
            if (isset($item->ID)) {
                $icon = get_post_meta($item->ID, $this->meta_key, true);
                if (!empty($icon)) {
                    $item->icon = $icon;
                }
            }
        }
        
        return $items;
    }
    

    
    /**
     * Setup menu item with icon data
     */
    public function setup_nav_menu_item($menu_item) {
        $menu_item->icon = get_post_meta($menu_item->ID, $this->meta_key, true);
        return $menu_item;
    }
    
    /**
     * Modify the header.php sidebar menu rendering
     * This function adds a filter to output_theme_menu_item to replace the default icon
     */
    public function modify_header_sidebar_menu() {
        // This hook will run after the theme is fully loaded
        add_action('wp_head', function() {
            // Add inline JavaScript to override the default icon behavior
            ?>
            <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                // Find all menu items in the sidebar
                document.querySelectorAll('.side-nav-item').forEach(function(item) {
                    // Check if this item has a data-icon attribute (we'll add this to the PHP output)
                    var iconClass = item.getAttribute('data-icon');
                    if (iconClass) {
                        // Find the icon element and replace its class
                        var iconElement = item.querySelector('.menu-icon i');
                        if (iconElement) {
                            // Remove all existing ti classes
                            iconElement.className = '';
                            // Add the new icon class
                            iconElement.className = iconClass;
                        }
                    }
                });
            });
            </script>
            <?php
        });
    }
}
