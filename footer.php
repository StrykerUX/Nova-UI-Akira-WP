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

<?php wp_footer(); ?>

</body>
</html>