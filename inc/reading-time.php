<?php
/**
 * Calculate reading time for posts
 *
 * @package Nova_UI_Akira
 */

if (!function_exists('nova_reading_time')) :
    /**
     * Calculate and return the reading time for a post
     * 
     * @return int Reading time in minutes
     */
    function nova_reading_time() {
        $content = get_post_field('post_content', get_the_ID());
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // Assuming 200 words per minute reading speed
        
        return $reading_time < 1 ? 1 : $reading_time;
    }
endif;