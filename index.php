<?php
/**
 * The main template file
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
                            if (is_home() && !is_front_page()) {
                                single_post_title();
                            } else {
                                esc_html_e('Latest Posts', 'nova-ui-akira');
                            }
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
                    ?>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php
                        /* Start the Loop */
                        while (have_posts()) :
                            the_post();
                            ?>
                            <div class="col">
                                <div class="card h-100">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="<?php the_permalink(); ?>" class="text-reset"><?php the_title(); ?></a></h5>
                                        <div class="card-subtitle mb-2 text-muted small">
                                            <?php 
                                            echo get_avatar(get_the_author_meta('ID'), 24, '', '', array('class' => 'rounded-circle me-1'));
                                            echo esc_html(get_the_author()) . ' • ' . esc_html(get_the_date());
                                            ?>
                                        </div>
                                        <div class="card-text">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary"><?php esc_html_e('Read More', 'nova-ui-akira'); ?></a>
                                        <?php if (comments_open()) : ?>
                                            <a href="<?php comments_link(); ?>" class="btn btn-sm btn-outline-primary ms-2">
                                                <i class="ti ti-message-circle me-1"></i> 
                                                <?php 
                                                    $comment_count = get_comments_number();
                                                    if ($comment_count == 0) {
                                                        esc_html_e('Leave a comment', 'nova-ui-akira');
                                                    } else {
                                                        printf(
                                                            _n('%s Comment', '%s Comments', $comment_count, 'nova-ui-akira'),
                                                            number_format_i18n($comment_count)
                                                        );
                                                    }
                                                ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                    <?php

                    // Pagination
                    echo '<div class="mt-4">';
                    the_posts_pagination(array(
                        'prev_text' => '<i class="ti ti-chevron-left"></i>',
                        'next_text' => '<i class="ti ti-chevron-right"></i>',
                        'class'     => 'pagination pagination-rounded justify-content-center',
                    ));
                    echo '</div>';
                else :
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <p><?php esc_html_e('No posts found.', 'nova-ui-akira'); ?></p>
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