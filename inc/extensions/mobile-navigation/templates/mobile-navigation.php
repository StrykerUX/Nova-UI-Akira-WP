<?php
/**
 * Mobile Navigation Template
 *
 * @package Nova_UI_Akira
 */
?>

<!-- Mobile Bottom Navigation - Only visible on mobile -->
<div class="nova-mobile-nav">
    <div class="nova-mobile-nav-bar">
        <div class="nova-mobile-nav-item">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nova-mobile-nav-link">
                <i class="ti ti-home fs-22"></i>
                <span><?php esc_html_e('Home', 'nova-ui-akira'); ?></span>
            </a>
        </div>
        <div class="nova-mobile-nav-item">
            <a href="<?php echo esc_url(home_url('/ia-chat')); ?>" class="nova-mobile-nav-link">
                <i class="ti ti-robot fs-22"></i>
                <span><?php esc_html_e('Nova IAs', 'nova-ui-akira'); ?></span>
            </a>
        </div>
        <div class="nova-mobile-nav-item">
            <a href="<?php echo esc_url(home_url('/quick-links')); ?>" class="nova-mobile-nav-link">
                <i class="ti ti-bookmark fs-22"></i>
                <span><?php esc_html_e('Quick Links', 'nova-ui-akira'); ?></span>
            </a>
        </div>
        <div class="nova-mobile-nav-item">
            <a href="#" class="nova-mobile-nav-link" id="nova-mobile-menu-toggle">
                <i class="ti ti-menu-2 fs-22"></i>
                <span><?php esc_html_e('Menu', 'nova-ui-akira'); ?></span>
            </a>
        </div>
    </div>
</div>

<!-- Full Screen Menu Overlay - Only visible when activated -->
<div class="nova-mobile-menu-overlay" id="nova-mobile-menu-overlay">
    <div class="nova-mobile-menu-container">
        <!-- Header with Logo and Close Button -->
        <div class="nova-mobile-menu-header">
            <div class="nova-mobile-menu-logo">
                <?php 
                // Use our advanced logo system
                if (function_exists('nova_get_advanced_logo')) {
                    echo nova_get_advanced_logo();
                } else {
                    // Fallback to standard WordPress logo
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<span class="logo-light"><span class="logo-lg">' . get_bloginfo('name') . '</span></span>';
                    }
                }
                ?>
            </div>
            <button class="nova-mobile-menu-close" id="nova-mobile-menu-close">
                <i class="ti ti-x fs-24"></i>
            </button>
        </div>
        
        <!-- Main Mobile Menu -->
        <div class="nova-mobile-menu-content">
            <?php
            if (has_nav_menu('mobile_menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'mobile_menu',
                    'container'      => false,
                    'menu_class'     => 'nova-mobile-menu-list',
                    'depth'          => 2,
                ));
            } else if (has_nav_menu('primary')) {
                // Fallback to primary menu if mobile menu is not set
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nova-mobile-menu-list',
                    'depth'          => 2,
                ));
            }
            ?>
        </div>
        
        <!-- Icons Menu - Search and Dark/Light Toggle -->
        <div class="nova-mobile-menu-icons">
            <?php if (has_nav_menu('mobile_icons')) : ?>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'mobile_icons',
                    'container'      => false,
                    'menu_class'     => 'nova-mobile-icons-list',
                    'depth'          => 1,
                ));
                ?>
            <?php else : ?>
                <!-- Default Icons -->
                <ul class="nova-mobile-icons-list">
                    <li>
                        <button class="nova-mobile-icon-btn" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="ti ti-search fs-22"></i>
                        </button>
                    </li>
                    <li>
                        <button class="nova-mobile-icon-btn" id="mobile-light-dark-mode">
                            <i class="ti ti-moon fs-22"></i>
                        </button>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
