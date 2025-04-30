<?php
/**
 * Template Name: Canvas
 * Description: A minimal template without header, footer, or sidebar.
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

<body <?php body_class('canvas-template'); ?>>
<?php wp_body_open(); ?>

<div class="canvas-content">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php wp_footer(); ?>
</body>
</html>