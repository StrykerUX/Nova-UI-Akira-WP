<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Nova_UI_Akira
 */

get_header();
?>

<div class="page-content">
    <div class="page-container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="mb-3">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/error-404.svg" class="img-fluid" alt="404 Not Found" style="max-height: 300px;">
                    </div>
                    <h1 class="display-4 fw-bold"><?php esc_html_e('Page Not Found', 'nova-ui-akira'); ?></h1>
                    <p class="text-muted mb-4"><?php esc_html_e('The page you are looking for does not exist. It might have been moved or deleted.', 'nova-ui-akira'); ?></p>
                    
                    <div class="mb-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                            <i class="ti ti-home me-1"></i> <?php esc_html_e('Back to Home', 'nova-ui-akira'); ?>
                        </a>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?php esc_html_e('Search', 'nova-ui-akira'); ?></h5>
                        </div>
                        <div class="card-body">
                            <p><?php esc_html_e('Perhaps you can find what you are looking for by searching:', 'nova-ui-akira'); ?></p>
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();