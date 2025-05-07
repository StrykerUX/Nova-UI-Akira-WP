<?php
/**
 * The template for displaying the footer
 *
 * @package Nova_UI_Akira
 */
?>

        <!-- Footer Start -->
        <footer class="footer">
            <div class="page-container">
                <div class="row">
                    <div class="col-md-4">
                        <?php if (is_active_sidebar('footer-1')) : ?>
                            <?php dynamic_sidebar('footer-1'); ?>
                        <?php else : ?>
                            <div class="footer-brand">
                                <?php if (has_custom_logo()) : ?>
                                    <?php the_custom_logo(); ?>
                                <?php else : ?>
                                    <h4 class="mt-0"><?php bloginfo('name'); ?></h4>
                                <?php endif; ?>
                                <p class="mt-3"><?php bloginfo('description'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php if (is_active_sidebar('footer-2')) : ?>
                            <?php dynamic_sidebar('footer-2'); ?>
                        <?php elseif (has_nav_menu('footer')) : ?>
                            <h5 class="text-uppercase mb-3"><?php esc_html_e('Quick Links', 'nova-ui-akira'); ?></h5>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'list-unstyled footer-links',
                                'depth'          => 1,
                                'container'      => false,
                            ));
                            ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php if (is_active_sidebar('footer-3')) : ?>
                            <?php dynamic_sidebar('footer-3'); ?>
                        <?php else : ?>
                            <h5 class="text-uppercase mb-3"><?php esc_html_e('Contact Us', 'nova-ui-akira'); ?></h5>
                            <div class="footer-contact">
                                <p><i class="ti ti-mail me-2"></i> <?php esc_html_e('info@example.com', 'nova-ui-akira'); ?></p>
                                <p><i class="ti ti-phone me-2"></i> <?php esc_html_e('+1 (123) 456-7890', 'nova-ui-akira'); ?></p>
                                <p><i class="ti ti-location me-2"></i> <?php esc_html_e('123 Street, City, Country', 'nova-ui-akira'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 text-center text-md-start">
                        &copy; <?php echo date_i18n('Y'); ?> <?php bloginfo('name'); ?> - <?php esc_html_e('All Rights Reserved', 'nova-ui-akira'); ?>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end footer-links d-none d-md-block">
                            <a href="<?php echo esc_url(get_privacy_policy_url()); ?>"><?php esc_html_e('Privacy Policy', 'nova-ui-akira'); ?></a>
                            <a href="#"><?php esc_html_e('Terms of Use', 'nova-ui-akira'); ?></a>
                            <a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact Us', 'nova-ui-akira'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Mobile Bottom Navigation -->
<nav class="mobile-bottom-nav d-md-none">
    <div class="nav-item">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>">
            <i class="ti ti-home"></i>
            <span><?php esc_html_e('Home', 'nova-ui-akira'); ?></span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo esc_url(home_url('/nova-ias')); ?>" class="nav-link <?php echo is_page('nova-ias') ? 'active' : ''; ?>">
            <i class="ti ti-robot"></i>
            <span><?php esc_html_e('Nova IAs', 'nova-ui-akira'); ?></span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo esc_url(home_url('/quick-links')); ?>" class="nav-link <?php echo is_page('quick-links') ? 'active' : ''; ?>">
            <i class="ti ti-bookmark"></i>
            <span><?php esc_html_e('Quick Links', 'nova-ui-akira'); ?></span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" id="bottom-nav-menu-btn" class="nav-link">
            <i class="ti ti-menu-2"></i>
            <span><?php esc_html_e('Menu', 'nova-ui-akira'); ?></span>
        </a>
    </div>
</nav>

<!-- Fullscreen Menu -->
<div class="fullscreen-menu">
    <div class="fullscreen-menu-header">
        <div class="fullscreen-menu-logo">
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
        <button class="fullscreen-menu-close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="fullscreen-menu-content">
        <ul class="fullscreen-menu-nav">
            <li>
                <a href="<?php echo esc_url(home_url('/perfil')); ?>">
                    <i class="ti ti-user"></i>
                    <span><?php esc_html_e('Perfil', 'nova-ui-akira'); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo esc_url(home_url('/configuracion')); ?>">
                    <i class="ti ti-settings"></i>
                    <span><?php esc_html_e('Configuración', 'nova-ui-akira'); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo esc_url(home_url('/suscripcion')); ?>">
                    <i class="ti ti-credit-card"></i>
                    <span><?php esc_html_e('Suscripción', 'nova-ui-akira'); ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo esc_url(home_url('/equipos')); ?>">
                    <i class="ti ti-users"></i>
                    <span><?php esc_html_e('Equipos', 'nova-ui-akira'); ?></span>
                </a>
            </li>
            <?php
            // Display WordPress Menu in the fullscreen menu
            if (has_nav_menu('primary')) {
                $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary']);
                $parent_items = array_filter($menu_items, function($item) {
                    return $item->menu_item_parent == 0;
                });

                foreach ($parent_items as $parent_item) {
                    echo '<li>';
                    echo '<a href="' . esc_url($parent_item->url) . '">';
                    echo '<i class="ti ti-file"></i>';
                    echo '<span>' . esc_html($parent_item->title) . '</span>';
                    echo '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </div>
    <div class="fullscreen-menu-footer">
        <div class="fullscreen-menu-actions">
            <button type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="ti ti-search"></i>
            </button>
            <button type="button" id="light-dark-mode-mobile">
                <i class="ti ti-moon"></i>
            </button>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>