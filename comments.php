<?php
/**
 * The template for displaying comments
 *
 * @package Nova_UI_Akira
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        ?>
        <h4 class="comments-title mb-4">
            <?php
            $nova_comment_count = get_comments_number();
            if ('1' === $nova_comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'nova-ui-akira'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $nova_comment_count, 'comments title', 'nova-ui-akira')),
                    number_format_i18n($nova_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h4><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <div class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'      => 'div',
                    'short_ping'  => true,
                    'avatar_size' => 60,
                    'callback'    => 'nova_comment',
                )
            );
            ?>
        </div><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
            ?>
            <div class="alert alert-info mt-4">
                <p class="mb-0"><?php esc_html_e('Comments are closed.', 'nova-ui-akira'); ?></p>
            </div>
            <?php
        endif;

    endif; // Check for have_comments().

    comment_form(
        array(
            'class_form'         => 'comment-form mt-4',
            'title_reply'        => esc_html__('Leave a Comment', 'nova-ui-akira'),
            'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
            'title_reply_after'  => '</h4>',
            'class_submit'       => 'btn btn-primary',
            'comment_field'      => '<div class="form-group mb-3"><label for="comment">' . esc_html__('Comment', 'nova-ui-akira') . '</label><textarea id="comment" name="comment" class="form-control" rows="5" aria-required="true"></textarea></div>',
            'fields'             => array(
                'author' => '<div class="row"><div class="col-md-4 mb-3"><label for="author">' . esc_html__('Name', 'nova-ui-akira') . ' <span class="required text-danger">*</span></label><input id="author" name="author" type="text" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" required="required" /></div>',
                'email'  => '<div class="col-md-4 mb-3"><label for="email">' . esc_html__('Email', 'nova-ui-akira') . ' <span class="required text-danger">*</span></label><input id="email" name="email" type="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" required="required" /></div>',
                'url'    => '<div class="col-md-4 mb-3"><label for="url">' . esc_html__('Website', 'nova-ui-akira') . '</label><input id="url" name="url" type="url" class="form-control" value="' . esc_attr($commenter['comment_author_url']) . '" /></div></div>',
                'cookies' => '<div class="form-check mb-3"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" class="form-check-input" value="yes"' . (empty($commenter['comment_author_email']) ? '' : ' checked="checked"') . ' /><label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__('Save my name, email, and website in this browser for the next time I comment.', 'nova-ui-akira') . '</label></div>',
            ),
        )
    );
    ?>

</div><!-- #comments -->