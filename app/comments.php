<?php

// remove "logged in as" message from comments
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

// get comment type nonce field data
function bidstitch_get_comment_type_nonce($comment_type = '') {
    if (empty($comment_type)) return false;

    $nonce_base = 'bidstitch_comment_type_';

    $nonce_action = $nonce_base . $comment_type;
    $nonce_field = $nonce_action . '_nonce';

    if (!isset($_REQUEST[$nonce_field])) return false;

    return (object) [
        'action' => $nonce_action,
        'field' => $nonce_field,
    ];
}

// set comment type based on nonce field
add_action('preprocess_comment', function ($comment_data) {
    // if is admin, return
    if (is_admin()) return $comment_data;

    if (!isset($_POST['comment_post_ID'])) return $comment_data;
    if (empty($_POST['comment_post_ID'])) return $comment_data;
    $post_id = absint($_POST['comment_post_ID']);

    $post_type = get_post_type($post_id);
    if (empty($post_type)) return $comment_data;

    // validate product comments
    if ($post_type === 'product') {
        // set product comment
        $comment_product_nonce = bidstitch_get_comment_type_nonce('product_comment');
        if (!empty($comment_product_nonce)) {
            $comment_data['comment_type'] = 'product_comment';
            return $comment_data;
        }

        // set review comment
        $comment_review_nonce = bidstitch_get_comment_type_nonce('review');
        if (!empty($comment_review_nonce)) {
            $comment_data['comment_type'] = 'review';
            return $comment_data;
        }
    }

    return $comment_data;
}, 11);

// validate nonce for each comment type
add_filter('pre_comment_on_post', function($comment_post_id) {
    // if is admin, return
    if (is_admin()) return;

    $post_type = get_post_type($comment_post_id);
    if (empty($post_type)) return;

    // validate product comments
    if ($post_type === 'product') {
        // validate comment nonce
        $comment_product_nonce = bidstitch_get_comment_type_nonce('product_comment');
        if (!empty($comment_product_nonce)) {
            $nonce = wp_verify_nonce($_REQUEST[$comment_product_nonce->field], $comment_product_nonce->action);

            if ($nonce === false) {
                return wp_die(__('Please refresh and try again.'));
            }

            return;
        }

        // validate review nonce
        $comment_review_nonce = bidstitch_get_comment_type_nonce('review');
        if (!empty($comment_review_nonce)) {
            $nonce = wp_verify_nonce($_REQUEST[$comment_review_nonce->field], $comment_review_nonce->action);

            if ($nonce === false) {
                return wp_die(__('Please refresh and try again.'));
            }

            return;
        }

        return wp_die(__('Please refresh and try again.'));
    }
}, 11);

// enable comments for all products unless disabled globally
add_action('comments_open', function($open, $post_id) {
    $post_type = get_post_type($post_id);

    if ($post_type === 'product') {
        if (!post_type_supports($post_type, 'comments')) return false;

        return true;
    }

    return $open;
}, 11, 2);