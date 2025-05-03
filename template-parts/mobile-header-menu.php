<?php
/**
 * Mobile Header and Menu for responsive templates
 *
 * @package Nova_UI_Akira
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<!-- Mobile Header - Only visible on small screens -->
<div class="nova-mobile-header d-md-none">
    <div class="nova-mobile-header-inner">
        <!-- Menu Toggle Button -->
        <button class="nova-mobile-menu-toggle">
            <i class="ti ti-menu-2"></i>
        </button>
        
        <!-- Logo (Optional) -->
        <div class="nova-mobile-logo">
            <?php 
            // Use the site logo if available
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            } else {
                echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
            }
            ?>
        </div>
        
        <!-- User Profile Image -->
        <div class="nova-mobile-user">
            <?php if (is_user_logged_in()) : ?>
                <button class="nova-mobile-user-avatar">
                    <?php echo get_avatar(get_current_user_id(), 32); ?>
                </button>
            <?php else : ?>
                <a href="<?php echo esc_url(wp_login_url()); ?>" class="nova-mobile-login-btn">
                    <i class="ti ti-login"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div class="nova-mobile-menu-overlay">
    <div class="nova-mobile-menu">
        <div class="nova-mobile-menu-header">
            <h5><?php esc_html_e('Menu', 'nova-ui-akira'); ?></h5>
            <button class="nova-mobile-menu-close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="nova-mobile-menu-content">
            <!-- Navigation Section -->
            <div class="nova-mobile-sidebar-menu">
                <h6><?php esc_html_e('Navigation', 'nova-ui-akira'); ?></h6>
                <ul class="side-nav mobile-side-nav">
                    <li class="side-nav-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text"> <?php esc_html_e('Home', 'nova-ui-akira'); ?> </span>
                        </a>
                    </li>
                    <?php
                    // Display WordPress Menu in the sidebar
                    if (has_nav_menu('primary')) {
                        $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary']);
                        $parent_items = array_filter($menu_items, function($item) {
                            return $item->menu_item_parent == 0;
                        });

                        foreach ($parent_items as $parent_item) {
                            $children = array_filter($menu_items, function($item) use ($parent_item) {
                                return $item->menu_item_parent == $parent_item->ID;
                            });

                            // Check if item has a custom icon
                            $icon_attr = '';
                            if (isset($parent_item->icon) && !empty($parent_item->icon)) {
                                $icon_attr = ' data-icon="' . esc_attr($parent_item->icon) . '"';
                            }

                            echo '<li class="side-nav-item"' . $icon_attr . '>';
                            if (empty($children)) {
                                echo '<a href="' . esc_url($parent_item->url) . '" class="side-nav-link">';
                                echo '<span class="menu-icon"><i class="ti ti-file"></i></span>';
                                echo '<span class="menu-text"> ' . esc_html($parent_item->title) . ' </span>';
                                echo '</a>';
                            } else {
                                echo '<a data-bs-toggle="collapse" href="#mobile-sidebar-' . esc_attr($parent_item->ID) . '" aria-expanded="false" aria-controls="mobile-sidebar-' . esc_attr($parent_item->ID) . '" class="side-nav-link">';
                                echo '<span class="menu-icon"><i class="ti ti-folder"></i></span>';
                                echo '<span class="menu-text"> ' . esc_html($parent_item->title) . ' </span>';
                                echo '<span class="menu-arrow"></span>';
                                echo '</a>';
                                echo '<div class="collapse" id="mobile-sidebar-' . esc_attr($parent_item->ID) . '">';
                                echo '<ul class="sub-menu">';
                                
                                foreach ($children as $child) {
                                    echo '<li class="side-nav-item">';
                                    echo '<a href="' . esc_url($child->url) . '" class="side-nav-link">';
                                    echo '<span class="menu-text">' . esc_html($child->title) . '</span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                                
                                echo '</ul>';
                                echo '</div>';
                            }
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <!-- Quick Actions Section -->
            <div class="nova-mobile-actions">
                <h6><?php esc_html_e('Quick Actions', 'nova-ui-akira'); ?></h6>
                <div class="d-flex flex-wrap">
                    <!-- Search Action -->
                    <div class="mobile-action-item">
                        <button class="btn btn-sm btn-outline-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                            <i class="ti ti-search me-1"></i> <?php esc_html_e('Search', 'nova-ui-akira'); ?>
                        </button>
                    </div>

                    <!-- Dark/Light Toggle -->
                    <div class="mobile-action-item">
                        <button class="btn btn-sm btn-outline-primary me-2 mb-2" id="mobile-light-dark-mode" type="button">
                            <i class="ti ti-moon me-1"></i> <?php esc_html_e('Theme', 'nova-ui-akira'); ?>
                        </button>
                    </div>

                    <!-- Topbar Icons -->
                    <?php if (class_exists('Nova_Topbar_Icons')) : ?>
                        <?php 
                        // Custom filter for mobile topbar icons
                        add_filter('wp_nav_menu_items', function($items, $args) {
                            if ($args->theme_location === 'topbar_icons') {
                                $items = str_replace('topbar-item d-none d-sm-flex', 'mobile-action-item', $items);
                                $items = str_replace('btn btn-outline-primary btn-icon', 'btn btn-sm btn-outline-primary me-2 mb-2', $items);
                                // Add text next to icons
                                $items = preg_replace('/<i class="(ti ti-[^"]+) fs-22"><\/i>/', '<i class="$1 me-1"></i><span class="topbar-item-text"></span>', $items);
                            }
                            return $items;
                        }, 10, 2);
                        
                        Nova_Topbar_Icons::render_topbar_icons(); 
                        
                        // Remove the filter
                        remove_all_filters('wp_nav_menu_items', 10);
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add names to the topbar icons
    document.addEventListener('DOMContentLoaded', function() {
        var icons = {
            'ti-flag': '<?php esc_html_e('Language', 'nova-ui-akira'); ?>',
            'ti-bell': '<?php esc_html_e('Notifications', 'nova-ui-akira'); ?>',
            'ti-apps': '<?php esc_html_e('Apps', 'nova-ui-akira'); ?>',
            'ti-settings': '<?php esc_html_e('Settings', 'nova-ui-akira'); ?>'
        };
        
        document.querySelectorAll('.topbar-item-text').forEach(function(el) {
            var iconEl = el.previousElementSibling;
            if (iconEl) {
                for (var iconClass in icons) {
                    if (iconEl.classList.contains(iconClass)) {
                        el.textContent = icons[iconClass];
                        break;
                    }
                }
            }
        });
    });
</script>
