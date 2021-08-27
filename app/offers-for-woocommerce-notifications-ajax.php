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
