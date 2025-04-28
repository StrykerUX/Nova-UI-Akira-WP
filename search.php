<?php
/**
 * The template for displaying search results pages
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
                        <h4 class="fs-18 text-uppercase fw-bold m-0">
                            <?php
                            /* translators: %s: search query. */
                            printf(esc_html__('Search Results for: %s', 'nova-ui-akira'), '<span>' . get_search_query() . '</span>');
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?php
                if (have_posts()) :
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();
                        ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h2 class="card-title"><a href="<?php the_permalink(); ?>" class="text-reset"><?php the_title(); ?></a></h2>
                                <div class="card-subtitle mb-3 text-muted">
                                    <?php nova_posted_on(); ?>
                                </div>
                                <div class="card-text">
                                    <?php the_excerpt(); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-3"><?php esc_html_e('Read More', 'nova-ui-akira'); ?></a>
                            </div>
                        </div>
                        <?php
                    endwhile;

                    // Pagination
                    the_posts_pagination(array(
                        'prev_text' => '<i class="ti ti-chevron-left"></i>',
                        'next_text' => '<i class="ti ti-chevron-right"></i>',
                        'class'     => 'pagination pagination-rounded justify-content-center mt-4',
                    ));
                else :
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nova-ui-akira'); ?></p>
                            <div class="search-form mt-4">
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php
get_footer();