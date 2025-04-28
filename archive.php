<?php
/**
 * The template for displaying archive pages
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
                        <?php
                        the_archive_title('<h4 class="fs-18 text-uppercase fw-bold m-0">', '</h4>');
                        the_archive_description('<div class="archive-description text-muted mt-2">', '</div>');
                        ?>
                    </div>
                    <div class="mt-3 mt-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'nova-ui-akira'); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo wp_strip_all_tags(get_the_archive_title()); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?php
                if (have_posts()) :
                    ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
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
                                            <?php nova_posted_on(); ?>
                                        </div>
                                        <div class="card-text">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary"><?php esc_html_e('Read More', 'nova-ui-akira'); ?></a>
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