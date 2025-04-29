<?php
/**
 * Icon Selector View
 * 
 * @package Nova_UI_Akira
 * @subpackage Menu_Enhancer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display popular Tabler icons as a reference
 * 
 * @param int $item_id Menu item ID
 * @param string $current_icon Current icon class
 */
function nova_display_popular_icons($item_id, $current_icon = '') {
    // List of popular icons
    $popular_icons = array(
        'ti ti-home' => esc_html__('Home', 'nova-ui-akira'),
        'ti ti-user' => esc_html__('User', 'nova-ui-akira'),
        'ti ti-settings' => esc_html__('Settings', 'nova-ui-akira'),
        'ti ti-mail' => esc_html__('Mail', 'nova-ui-akira'),
        'ti ti-phone' => esc_html__('Phone', 'nova-ui-akira'),
        'ti ti-search' => esc_html__('Search', 'nova-ui-akira'),
        'ti ti-heart' => esc_html__('Heart', 'nova-ui-akira'),
        'ti ti-star' => esc_html__('Star', 'nova-ui-akira'),
        'ti ti-calendar' => esc_html__('Calendar', 'nova-ui-akira'),
        'ti ti-map' => esc_html__('Map', 'nova-ui-akira'),
        'ti ti-photo' => esc_html__('Photo', 'nova-ui-akira'),
        'ti ti-book' => esc_html__('Book', 'nova-ui-akira'),
        'ti ti-bell' => esc_html__('Bell', 'nova-ui-akira'),
        'ti ti-flag' => esc_html__('Flag', 'nova-ui-akira'),
        'ti ti-pencil' => esc_html__('Pencil', 'nova-ui-akira'),
    );
    ?>
    <div class="nova-popular-icons">
        <p class="description"><?php esc_html_e('Popular icons:', 'nova-ui-akira'); ?></p>
        <div class="nova-icon-grid">
            <?php foreach ($popular_icons as $icon_class => $icon_name) : ?>
                <a href="#" 
                   class="nova-icon-item" 
                   data-icon="<?php echo esc_attr($icon_class); ?>" 
                   data-target="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>"
                   title="<?php echo esc_attr($icon_name); ?>">
                    <i class="<?php echo esc_attr($icon_class); ?>"></i>
                    <span class="nova-icon-name"><?php echo esc_html($icon_name); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
