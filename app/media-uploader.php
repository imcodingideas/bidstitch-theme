<?php

/**
 * Media Uploader
 *
 * Currently supports and checks only for media files supported by WordPress.
 * Other file extensions like .doc, .txt and others can be implemented separately
 */

namespace App;

use function Roots\asset;

/**
 *
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {

    wp_enqueue_script(
        'sage/media-uploader.js',
        asset('scripts/media-uploader.js')->uri(),
        array('jquery'),
        null,
        true
    );

    $ajax_url = admin_url('admin-ajax.php');

    $actions = array(
        'process' => array(
            'action' => 'bidstitch_process_file_upload',
            'nonce' => wp_create_nonce('bidstitch_process_file_upload')
        ),
        'revert' => array(
            'action' => 'bidstitch_revert_file_upload',
            'nonce' => wp_create_nonce('bidstitch_revert_file_upload')
        ),
        'load' => array(
            'action' => 'bidstitch_load_file_upload',
            'nonce' => wp_create_nonce('bidstitch_load_file_upload')
        ),
        'fetch' => array(
            'action' => 'bidstitch_fetch_file_upload',
            'nonce' => wp_create_nonce('bidstitch_fetch_file_upload')
        ),
    );

    wp_localize_script(
        'sage/media-uploader.js',
        'mediaUploaderData',
        array(
            'process_url' => add_query_arg($actions['process'], $ajax_url),
            'revert_url' => add_query_arg($actions['revert'], $ajax_url),
            'load_url' => add_query_arg($actions['load'], $ajax_url),
            'fetch_url' => add_query_arg($actions['fetch'], $ajax_url),
        )
    );
});

/**
 * Process file upload from FilePond
 * Only for register user, so we dont adding nopriv
 *
 * @return void
 */
add_action('wp_ajax_bidstitch_process_file_upload', function () {

    if (!is_user_logged_in()) wp_send_json_error(esc_html__('Unauthorized', 'bidstitch'), 400);

    if (!wp_verify_nonce($_GET['nonce'], 'bidstitch_process_file_upload')) wp_send_json_error(esc_html__('Go away', 'bidstitch'), 400);

    if (!dokan_is_user_seller(get_current_user_id())) wp_send_json_error(esc_html__('Wrong permissions', 'bidstitch'), 400);

    if (!isset($_FILES) || empty($_FILES)) wp_send_json_error(esc_html__('Please upload a file', 'bidstitch'), 400);
    
    // validate max file count
    $max_file_count = 7;
    if (count($_FILES) > $max_file_count) wp_send_json_error(esc_html__('Max number of files reached', 'bidstitch'), 400);

    $file_key = sanitize_text_field(array_key_first($_FILES));

    $allowed_extensions = apply_filters(
        'bidstitch_allowed_extensions',
        array('image/jpeg', 'image/jpg', 'image/png'),
        $file_key
    );

    if(!in_array($_FILES[$file_key]['type'], $allowed_extensions)) wp_send_json_error(esc_html__('Disallowed file type.', 'bidstitch'), 400);
    
    // validate max file size
    if(!isset($_FILES[$file_key]['size'])) wp_send_json_error(esc_html__('Invalid file size', 'bidstitch'), 400);
    
    $mega_byte = 1048576;
    $max_file_size = $mega_byte * 5;

    $max_file_size = apply_filters(
        'bidstitch_max_file_size',
        $max_file_size,
        $file_key
    );

    if($_FILES[$file_key]['size'] >= $max_file_size) wp_send_json_error(esc_html__('Invalid file size', 'bidstitch'), 400);

    add_filter('intermediate_image_sizes', function () {
        return apply_filters('bidstitch_allowed_upload_sizes', array(
            'woocommerce_thumbnail',
            'woocommerce_single',
            'woocommerce_gallery_thumbnail'
        ));
    });

    $attachment_id = media_handle_upload($file_key, 0);

    if (is_wp_error($attachment_id)) {
        wp_send_json_error($attachment_id->get_error_message(), 400);
    }

    wp_send_json($attachment_id);
});

/**
 * Revert file upload by deleting uploaded media from server
 *
 */

add_action('wp_ajax_bidstitch_revert_file_upload', function () {

    if (!is_user_logged_in()) wp_send_json_error(esc_html__('Unauthorized', 'bidstitch'));

    if (!wp_verify_nonce($_GET['nonce'], 'bidstitch_revert_file_upload')) wp_send_json_error(esc_html__('Go away', 'bidstitch'), 400);

    $current_user_id = get_current_user_id();

    if (!dokan_is_user_seller($current_user_id)) wp_send_json_error(esc_html__('Wrong permissions', 'bidstitch'), 400);

    $attachment_id = intval(file_get_contents('php://input'));
    $author_id = intval(get_post_field('post_author', $attachment_id));
    if ($author_id !== $current_user_id) wp_send_json_error(esc_html__('Insufficient permission', 'bidstitch'), 400);

    /*Now we can delete uploaded image*/
    wp_delete_attachment($attachment_id);
    wp_send_json(true);

});

add_action('wp_ajax_bidstitch_load_file_upload', function () {

    if (!is_user_logged_in()) wp_send_json_error(esc_html__('Unauthorized', 'bidstitch'));

    if (!wp_verify_nonce($_GET['nonce'], 'bidstitch_load_file_upload')) wp_send_json_error(esc_html__('Go away', 'bidstitch'));

    $current_user_id = get_current_user_id();

    if (!dokan_is_user_seller($current_user_id)) wp_send_json_error(esc_html__('Wrong permissions', 'bidstitch'));

    $attachment_id = intval(file_get_contents('php://input'));

    wp_send_json(wp_get_attachment_url($attachment_id));

});
