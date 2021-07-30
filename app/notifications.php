<?php
function notifications_notread_all($user_id)
{
    if (
        false === ($notifications_count = get_transient('notifications_count'))
    ) {
        $notifications_count = 0;
        global $wpdb;
        $query = $wpdb->get_row(
            "SELECT count(*) as count FROM `{$wpdb->base_prefix}user_notifications` WHERE user_receieve_id = $user_id and status = 0 Order by created_at DESC "
        );

        if (isset($query->count)) {
            $notifications_count = $query->count;
        }
        /* MINUTE_IN_SECONDS  = 60 (seconds) */
        /* HOUR_IN_SECONDS    = 60 * MINUTE_IN_SECONDS */
        /* DAY_IN_SECONDS     = 24 * HOUR_IN_SECONDS */
        /* WEEK_IN_SECONDS    = 7 * DAY_IN_SECONDS */
        /* MONTH_IN_SECONDS   = 30 * DAY_IN_SECONDS */
        /* YEAR_IN_SECONDS    = 365 * DAY_IN_SECONDS */
        set_transient(
            'notifications_count',
            $notifications_count,
            MINUTE_IN_SECONDS
        );
    }
    return $notifications_count;
}
