<?php
/**
 * The template for displaying all pages
 *
 * @package Nova_UI_Akira
 */

get_header();
?>

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 text-uppercase fw-bold m-0"><?php echo get_the_title(); ?></h4>
                    </div>
                    <div class="mt-3 mt-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'nova-ui-akira'); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <?php nova_post_thumbnail(); ?>
                            <div class="card-text">
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
get_footer();