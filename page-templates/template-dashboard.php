<?php
/**
 * Template Name: Dashboard
 * Description: A template with 100% height content area and internal scrolling, without title, breadcrumbs, or footer.
 *
 * @package Nova_UI_Akira
 */

// Encolar el script específico para esta plantilla
wp_enqueue_script('nova-dashboard-template', get_template_directory_uri() . '/assets/js/pages/dashboard-template.js', array('jquery'), '1.0.0', true);

get_header();
?>

<div class="page-content dashboard-template vh-100">
    <div class="page-container h-100">
        <!-- No page title or breadcrumbs as requested -->
        <!-- Contenedor de tokens como en la imagen de referencia -->
        <div class="row dashboard-content-row">
            <div class="col dashboard-content-col">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <div class="card dashboard-card">
                        <div class="card-body dashboard-card-body h-100">
                            <?php nova_post_thumbnail(); ?>
                            <div class="card-text dashboard-card-text">
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

<?php wp_footer(); ?>

</body>
</html>
