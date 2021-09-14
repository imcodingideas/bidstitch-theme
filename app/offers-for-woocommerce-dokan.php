<?php
// filter out action buttons for vendors
add_filter('bidstitch_vendors_offers_actions', function($row_actions, $offer_id) {
    // only admins can delete and edit
    if (!current_user_can('administrator')) {
        unset($row_actions['edit']);
        unset($row_actions['delete']);
    }

    if (!$offer_id) return $row_actions;

    $post_status = get_post_status($offer_id);
    if (!$post_status) return $row_actions;

    $actionable_status_list = [
        'publish',
        'buyercountered-offer',
    ];

    if ($post_status && !in_array($post_status, $actionable_status_list)) {
        unset($row_actions['accept']);
        unset($row_actions['decline']);
    }

    return $row_actions;
}, 11, 2);
