<?php
/**
 * The template for displaying all single posts
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
                        <h4 class="fs-18 text-uppercase fw-bold m-0"><?php echo get_the_category_list(', '); ?></h4>
                    </div>
                    <div class="mt-3 mt-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'nova-ui-akira'); ?></a></li>
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a></li>';
                                }
                                ?>
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
                            <h1 class="card-title h2"><?php the_title(); ?></h1>
                            <div class="card-subtitle mb-3 text-muted d-flex align-items-center">
                                <div class="me-3">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'rounded-circle')); ?>
                                </div>
                                <div>
                                    <div class="fw-medium"><?php the_author(); ?></div>
                                    <div class="small">
                                        <?php echo get_the_date(); ?> · 
                                        <?php echo nova_reading_time(); ?> <?php esc_html_e('min read', 'nova-ui-akira'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php nova_post_thumbnail(); ?>
                            
                            <div class="card-text">
                                <?php the_content(); ?>
                            </div>
                            
                            <div class="entry-footer mt-4 pt-3 border-top">
                                <?php nova_entry_footer(); ?>
                            </div>
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
                    
                    // Previous/next post navigation.
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    
                    if ($prev_post || $next_post) :
                    ?>
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="post-navigation row">
                                <?php if ($prev_post) : ?>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="post-navigation-prev">
                                        <span class="d-block text-muted small mb-2"><?php esc_html_e('Previous Post', 'nova-ui-akira'); ?></span>
                                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="fw-medium d-flex align-items-center">
                                            <i class="ti ti-arrow-left me-2"></i>
                                            <?php echo esc_html(get_the_title($prev_post->ID)); ?>
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($next_post) : ?>
                                <div class="col-md-6 text-md-end">
                                    <div class="post-navigation-next">
                                        <span class="d-block text-muted small mb-2"><?php esc_html_e('Next Post', 'nova-ui-akira'); ?></span>
                                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="fw-medium d-flex align-items-center justify-content-md-end">
                                            <?php echo esc_html(get_the_title($next_post->ID)); ?>
                                            <i class="ti ti-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
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