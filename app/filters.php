<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

// show only posts on post listing search
add_filter('pre_get_posts', function($q) {
    if (is_admin() || !$q->is_main_query()) return $q;

    $search_query = $q->get('s');
    if (empty($search_query)) return $q;

    if (is_home() && !dokan_is_store_page()) {
        $q->set('post_type', 'post');
    }
    
    return $q;
}, 11, 1);

// decrease excerpt length
add_filter('excerpt_length', function($length) {
    if (is_admin()) return $length;

    return 32;
});

// remove 'logged in as' message from comments
add_filter('comment_form_logged_in', '__return_empty_string' );

// set reply link to woocommerce login
add_filter('comment_reply_link', function($link, $args) {
    if (get_option('comment_registration') && !is_user_logged_in()) {
        $link = sprintf(
            '<a rel="nofollow" class="comment-reply-login" href="%s">%s</a>',
            esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')))
        ,
            $args['login_text']
        );
    }

    return $link;
}, 11, 2);
