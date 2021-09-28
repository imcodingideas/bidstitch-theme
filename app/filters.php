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
