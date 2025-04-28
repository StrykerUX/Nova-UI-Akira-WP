<?php
/**
 * Custom template tags for this theme
 *
 * @package Nova_UI_Akira
 */

if (!function_exists('nova_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function nova_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'nova-ui-akira'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'nova-ui-akira'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('nova_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function nova_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'nova-ui-akira'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links"><i class="ti ti-category me-1"></i> ' . esc_html__('Posted in %1$s', 'nova-ui-akira') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'nova-ui-akira'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links"><i class="ti ti-tag me-1"></i> ' . esc_html__('Tagged %1$s', 'nova-ui-akira') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link"><i class="ti ti-message-circle me-1"></i> ';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'nova-ui-akira'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'nova-ui-akira'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link"><i class="ti ti-pencil me-1"></i> ',
            '</span>'
        );
    }
endif;

if (!function_exists('nova_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function nova_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail mb-4">
                <?php the_post_thumbnail('full', array('class' => 'img-fluid rounded')); ?>
            </div>

        <?php else : ?>

            <a class="post-thumbnail mb-3 d-block" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'medium',
                    array(
                        'class' => 'img-fluid rounded',
                        'alt'   => the_title_attribute(array('echo' => false)),
                    )
                );
                ?>
            </a>

        <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     *
     * @link https://core.trac.wordpress.org/ticket/12563
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;

/**
 * Custom Walker for the Topbar Navigation
 */
class Nova_Topbar_Walker extends Walker_Nav_Menu {
    private $column_counter = 0;
    private $items_per_column = 7;

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            $output .= "<ul class=\"list-unstyled megamenu-list\">";
        } else {
            $output .= "<ul class=\"sub-menu\">";
        }
    }

    /**
     * Start the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if ($depth === 0) {
            if ($this->column_counter % $this->items_per_column === 0) {
                if ($this->column_counter > 0) {
                    $output .= "</ul></div>";
                }
                $output .= "<div class=\"col-md-4\"><div class=\"p-3\">";
                $output .= "<h5 class=\"mb-2 fw-semibold\">{$item->title}</h5>";
                $output .= "<ul class=\"list-unstyled megamenu-list\">";
            } else {
                $output .= "<li><a href=\"" . esc_url($item->url) . "\">" . esc_html($item->title) . "</a></li>";
            }
            $this->column_counter++;
        } else {
            $output .= "<li><a href=\"" . esc_url($item->url) . "\">" . esc_html($item->title) . "</a></li>";
        }
    }

    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            $output .= "</ul>";
        } else {
            $output .= "</ul>";
        }
    }

    /**
     * Ends the element output, if needed.
     */
    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        if ($depth === 0 && $this->column_counter % $this->items_per_column === 0) {
            $output .= "</div></div>";
        }
    }
}