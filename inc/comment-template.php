<?php
/**
 * Custom comment template
 * 
 * @package Nova_UI_Akira
 */

if (!function_exists('nova_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     * @param object $comment Comment to display.
     * @param array  $args    Arguments passed to wp_list_comments().
     * @param int    $depth   Depth of comment.
     */
    function nova_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        $comment_classes = 'comment card mb-4';
        
        if ('pingback' === $comment->comment_type || 'trackback' === $comment->comment_type) {
            $comment_classes .= ' pingback';
        }
        
        if (0 === $depth) {
            $comment_classes .= ' parent';
        }
        
        if ('0' === $comment->comment_approved) {
            $comment_classes .= ' comment-unapproved';
        }
        ?>
        <div id="comment-<?php comment_ID(); ?>" <?php comment_class($comment_classes); ?>>
            <div class="card-body">
                <?php if ('pingback' === $comment->comment_type || 'trackback' === $comment->comment_type) : ?>
                    <div class="comment-meta mb-3">
                        <h6 class="mb-0">
                            <?php esc_html_e('Pingback:', 'nova-ui-akira'); ?> 
                            <?php comment_author_link(); ?>
                        </h6>
                        <div class="comment-metadata text-muted small">
                            <time datetime="<?php comment_time('c'); ?>">
                                <?php echo human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ' . esc_html__('ago', 'nova-ui-akira'); ?>
                            </time>
                            <?php edit_comment_link(esc_html__('Edit', 'nova-ui-akira'), '<span class="edit-link ms-2">', '</span>'); ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="comment-meta d-flex">
                        <div class="comment-author vcard me-3">
                            <?php 
                            if (0 !== $args['avatar_size']) {
                                echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'rounded-circle')); 
                            }
                            ?>
                        </div>
                        <div>
                            <h6 class="mt-0 mb-1">
                                <?php echo get_comment_author_link(); ?>
                                <?php if ('0' === $comment->comment_approved) : ?>
                                    <em class="comment-awaiting-moderation ms-2 text-muted">
                                        <?php esc_html_e('Comment awaiting moderation', 'nova-ui-akira'); ?>
                                    </em>
                                <?php endif; ?>
                            </h6>
                            <div class="comment-metadata text-muted small">
                                <time datetime="<?php comment_time('c'); ?>">
                                    <?php echo human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ' . esc_html__('ago', 'nova-ui-akira'); ?>
                                </time>
                                <?php edit_comment_link(esc_html__('Edit', 'nova-ui-akira'), '<span class="edit-link ms-2">', '</span>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="comment-content mt-3">
                        <?php comment_text(); ?>
                    </div>

                    <?php 
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => 'comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="reply mt-2">',
                                'after'     => '</div>',
                                'reply_text' => sprintf('<i class="ti ti-message-circle me-1"></i> %s', esc_html__('Reply', 'nova-ui-akira')),
                                'reply_to_text' => sprintf('<i class="ti ti-message-circle me-1"></i> %s', esc_html__('Reply to %s', 'nova-ui-akira')),
                                'login_text' => sprintf('<i class="ti ti-login me-1"></i> %s', esc_html__('Log in to Reply', 'nova-ui-akira')),
                                'class_link' => 'btn btn-sm btn-outline-primary',
                            )
                        )
                    ); 
                    ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
endif;