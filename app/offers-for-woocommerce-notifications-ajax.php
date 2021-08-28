<?php

namespace App;

// serve notifications count
add_action('wp_ajax_fetch_notifications_count', function () {
    $count = bidstitch_get_unread_notifications_for_user_count(
        get_current_user_id()
    );
    echo $count;
    wp_die();
});

// serve notifications html
add_action('wp_ajax_fetch_notifications', function () {
    echo \Roots\view('partials.header-notifications')->render();
    wp_die();
});

// remove notifications
add_action('wp_ajax_notification_mark_as_read', function () {
    $id = $_POST['id'] ?? false;
    if (!$id) {
        echo 'error: id not provided';
        wp_die();
    }
    bidstitch_notification_mark_as_read($id);
    wp_die();
});
