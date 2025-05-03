<?php
/**
 * Template Name: IA Chat
 * Description: A special template for AI chat interfaces.
 *
 * @package Nova_UI_Akira
 */

// Enqueue responsive dashboard styles and script
wp_enqueue_style('responsive-dashboard', get_template_directory_uri() . '/assets/css/responsive-dashboard.css', array(), '1.0.0');
wp_enqueue_script('responsive-dashboard', get_template_directory_uri() . '/assets/js/responsive-dashboard.js', array('jquery'), '1.0.0', true);

get_header();

// Include the mobile header and menu
get_template_part('template-parts/mobile-header-menu');
?>

<div class="page-content ia-chat-template">
    <div class="page-container ia-chat-container">
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

        <div class="row ia-chat-content-row">
            <div class="col-12 ia-chat-content-col">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <div class="card ia-chat-card">
                        <div class="card-body ia-chat-card-body">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
