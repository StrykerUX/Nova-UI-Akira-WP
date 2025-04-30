<?php
/**
 * Template Name: Quick Link
 * Description: A minimal template without header or sidebar, but with a special footer.
 *
 * @package Nova_UI_Akira
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class('quick-link-template'); ?>>
<?php wp_body_open(); ?>

<div class="quick-link-content">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</div>

<!-- Quick Link Footer -->
<div class="quick-link-footer">
    <div class="container">
        <div class="text-center py-3">
            <?php esc_html_e('Powered by', 'nova-ui-akira'); ?> <a href="https://novalabss.com" target="_blank" rel="noopener">NovaLabss</a>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>