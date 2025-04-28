<?php
/**
 * The template for displaying search forms
 *
 * @package Nova_UI_Akira
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="input-group">
        <input type="search" class="form-control" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'nova-ui-akira'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-search"></i>
            <span class="visually-hidden"><?php echo esc_html_x('Search', 'submit button', 'nova-ui-akira'); ?></span>
        </button>
    </div>
</form>