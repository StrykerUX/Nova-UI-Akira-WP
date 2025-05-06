<?php
/**
 * Mobile Navigation Template Part
 *
 * @package Nova_UI_Akira
 */
?>

<!-- Mobile Bottom Navigation -->
<div class="mobile-bottom-nav">
    <div class="mobile-nav-item">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-link">
            <i class="ti ti-home"></i>
            <span><?php esc_html_e('Home', 'nova-ui-akira'); ?></span>
        </a>
    </div>
    
    <div class="mobile-nav-item">
        <a href="<?php echo esc_url(home_url('/category/nova-ias')); ?>" class="mobile-nav-link">
            <i class="ti ti-robot"></i>
            <span><?php esc_html_e('Nova IAs', 'nova-ui-akira'); ?></span>
        </a>
    </div>
    
    <div class="mobile-nav-item">
        <a href="<?php echo esc_url(home_url('/quick-links')); ?>" class="mobile-nav-link">
            <i class="ti ti-link"></i>
            <span><?php esc_html_e('Quick Links', 'nova-ui-akira'); ?></span>
        </a>
    </div>
    
    <div class="mobile-nav-item">
        <button id="mobile-menu-toggle" class="mobile-nav-link">
            <i class="ti ti-menu-2"></i>
            <span><?php esc_html_e('Menu', 'nova-ui-akira'); ?></span>
        </button>
    </div>
</div>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="mobile-menu-overlay">
    <div class="mobile-menu-container">
        <!-- Logo -->
        <div class="mobile-menu-header">
            <div class="mobile-menu-logo">
                <?php 
                if (function_exists('nova_get_advanced_logo')) {
                    echo nova_get_advanced_logo();
                } else {
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<span class="site-title">' . get_bloginfo('name') . '</span>';
                    }
                }
                ?>
            </div>
            <button id="mobile-menu-close" class="mobile-menu-close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        
        <!-- Main Navigation -->
        <div class="mobile-menu-nav">
            <?php
            if (has_nav_menu('mobile_main')) {
                wp_nav_menu(array(
                    'theme_location' => 'mobile_main',
                    'menu_class'     => 'mobile-menu',
                    'container'      => false,
                    'depth'          => 2,
                ));
            } else if (has_nav_menu('primary')) {
                // Fallback to primary menu if mobile_main not set
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'mobile-menu',
                    'container'      => false,
                    'depth'          => 2,
                ));
            }
            ?>
        </div>
        
        <!-- Actions Row -->
        <div class="mobile-menu-actions">
            <!-- Search Icon -->
            <button class="mobile-action-btn" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="ti ti-search"></i>
            </button>
            
            <!-- Theme Toggle Icon -->
            <button class="mobile-action-btn" id="mobile-light-dark-mode">
                <i class="ti ti-moon"></i>
            </button>
            
            <!-- Icons Menu -->
            <div class="mobile-icons-menu">
                <?php
                if (has_nav_menu('mobile_icons')) {
                    wp_nav_menu(array(
                        'theme_location' => 'mobile_icons',
                        'menu_class'     => 'mobile-icons-list',
                        'container'      => false,
                        'depth'          => 1,
                        'link_before'    => '<span class="icon-only">',
                        'link_after'     => '</span>',
                    ));
                }
                ?>
            </div>
        </div>
    </div>
</div>