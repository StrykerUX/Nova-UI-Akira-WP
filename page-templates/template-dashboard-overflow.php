<?php
/**
 * Template Name: Dashboard Overflow
 * Description: A template with vertical scroll and similar to Dashboard template but with overflow enabled.
 *
 * @package Nova_UI_Akira
 */

get_header();
?>

<div class="page-content dashboard-overflow-template">
    <div class="page-container">
        <!-- No page title or breadcrumbs as in dashboard template -->
        <div class="row dashboard-overflow-content-row">
            <div class="col dashboard-overflow-content-col">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <div class="card dashboard-overflow-card">
                        <div class="card-body dashboard-overflow-card-body">
                            <?php nova_post_thumbnail(); ?>
                            <div class="card-text dashboard-overflow-card-text">
                                <?php the_content(); ?>
                            </div>
                            <?php
                            wp_link_pages(
                                array(
                                    'before' => '<div class="page-links mt-4 pt-3 border-top">' . esc_html__('Pages:', 'nova-ui-akira'),
                                    'after'  => '</div>',
                                )
                            );
                            ?>
                        </div>
                    </div>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        echo '<div class="card mt-4">';
                        echo '<div class="card-body">';
                        comments_template();
                        echo '</div>';
                        echo '</div>';
                    endif;
                endwhile; // End of the loop.
                ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php
// No footer for this template
?>
    </div> <!-- End wrapper -->

<style>
/* Enable vertical scroll for Dashboard Overflow template */
body.page-template-template-dashboard-overflow {
    overflow-y: auto !important;
    overflow-x: hidden !important;
}
</style>

<?php 
// Include mobile navigation for responsive view
get_template_part('inc/mobile-navigation');

wp_footer(); 
?>

</body>
</html>
