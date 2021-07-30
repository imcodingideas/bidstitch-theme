<?php
function notifications_notread_all($user_id)
{
    $notifications_count = 0;
    global $wpdb;
    $query = $wpdb->get_row(
        "SELECT count(*) as count FROM `{$wpdb->base_prefix}user_notifications` WHERE user_receieve_id = $user_id and status = 0 Order by created_at DESC "
    );

    if (isset($query->count)) {
        $notifications_count = $query->count;
    }
    return $notifications_count;
}
