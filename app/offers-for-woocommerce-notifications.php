<?php

namespace App;

/**
 * Save notification to database
 */

add_action(
    'angelleye_offer_for_woocommerce_before_email_send',
    function ($offer_args, $emails) {
        global $wpdb;
        // sender
        if (!is_user_logged_in()) {
            return;
        }
        $user_sent_id = get_current_user_id();

        // receiver
        $post = get_post($offer_args['product_id']);
        if (!$post) {
            return;
        }
        $user_receieve_id = $post->post_author;
        $product_id = $offer_args['product_id'];
        $type = 'offer';
        $detail_type = bidstitch_get_offer_type($emails->id);
        $id_offer = !empty($offer_args['offer_id'])
            ? $offer_args['offer_id']
            : 0;
        $id_order = 0;
        // save in database
        $prefix = $wpdb->base_prefix;
        $wpdb->insert("{$prefix}user_notifications", [
            'user_sent_id' => $user_sent_id,
            'user_receieve_id' => $user_receieve_id,
            'product_id' => $product_id,
            'type' => $type,
            'detail_type' => $detail_type,
            'id_offer' => $id_offer,
            'id_order' => $id_order,
            'created_at' => date('Y-m-d H:i:s', time()),
        ]);
    },
    9,
    2
);

/**
 * Get offer notification type by email type.
 *
 * @param string $type Get offer notification type.
 *
 * @return string $notification_type Return notification type.
 */
function bidstitch_get_offer_type($type = 'wc_new_offer')
{
    switch ($type) {
        case 'wc_new_counter_offer':
            $notification_type = 'offer_sent_new_countered';
            break;
        case 'wc_offer_received':
            $notification_type = 'offer_received';
            break;
        case 'wc_accepted_offer':
            $notification_type = 'offer_sent_accepted';
            break;
        case 'wc_countered_offer':
            $notification_type = 'offer_sent_countered';
            break;
        case 'wc_declined_offer':
            $notification_type = 'offer_sent_declined';
            break;
        default:
            $notification_type = 'offer_received';
    }

    return $notification_type;
}

function bidstitch_get_notification_description($name)
{
    switch ($name) {
        case 'offer_sent_new_countered':
            return 'New Counter Offer';
        case 'offer_received':
            return 'Offer Received';
        case 'offer_sent_accepted':
            return 'Offer Accepted';
        case 'offer_sent_countered':
            return 'Offer Sent Countered';
        case 'offer_sent_declined':
            return 'Offer Sent Declined';
    }
}

function bidstitch_get_unread_notifications_for_user($user_id)
{
    global $wpdb;
    $prefix = $wpdb->base_prefix;
    $query = $wpdb->prepare(
        "select * from {$prefix}user_notifications where user_receieve_id = %d and status = 0 order by ID desc",
        $user_id
    );
    $results = $wpdb->get_results($query);

    $notifications = [];
    foreach ($results as $notification) {
        $post_object = get_post($notification->product_id);
        if ($post_object) {
            $notifications[] = [
                'id' => $notification->id,
                'product_id' => $notification->product_id,
                'id_offer' => $notification->id_offer,
                'title' => bidstitch_get_notification_description(
                    $notification->detail_type
                ),
                'text' => $post_object->post_title,
                'thumbnail' => get_the_post_thumbnail_url(
                    $post_object->ID,
                    'thumbnail'
                ),
                'link' => get_permalink($post_object->ID),
                'isOffer' => $notification->type == 'offer',
            ];
        }
    }
    return $notifications;
}

function bidstitch_get_notifications_for_user($user_id, $items_per_page, $page)
{
    global $wpdb;
    $prefix = $wpdb->base_prefix;
    $offset = $page * $items_per_page - $items_per_page;

    // total
    $queryTotal = $wpdb->prepare(
        "select count(1) from {$prefix}user_notifications where user_receieve_id = %d",
        $user_id
    );
    $total = $wpdb->get_var($queryTotal);
    $pages = ceil($total / $items_per_page);

    // results
    $query = $wpdb->prepare(
        "select * from {$prefix}user_notifications where user_receieve_id = %d order by ID desc limit %d,%d",
        $user_id,
        $offset,
        $items_per_page
    );
    $results = $wpdb->get_results($query);

    $notifications = [];
    $dateFormat = get_option('date_format');
    foreach ($results as $notification) {
        $post_object = get_post($notification->product_id);
        if ($post_object) {
            $notifications[] = [
                'id' => $notification->id,
                'product_id' => $notification->product_id,
                'id_offer' => $notification->id_offer,
                'title' => bidstitch_get_notification_description(
                    $notification->detail_type
                ),
                'text' => $post_object->post_title,
                'thumbnail' => get_the_post_thumbnail_url(
                    $post_object->ID,
                    'thumbnail'
                ),
                'link' => get_permalink($post_object->ID),
                'isOffer' => $notification->type == 'offer',
                'status' => $notification->status,
                'date' => date_i18n($dateFormat, $notification->created_at),
                'time' => date_format(date_create($notification->created_at), 'H:i:s'),
            ];
        }
    }
    return [
        'data' => $notifications,
        'pages' => $pages,
        'page' => $page,
    ];
}

function bidstitch_get_unread_notifications_for_user_count($user_id)
{
    global $wpdb;
    $prefix = $wpdb->base_prefix;

    $query = $wpdb->prepare(
        "select count(*) from {$prefix}user_notifications where user_receieve_id = %d and status = 0",
        $user_id
    );

    return $wpdb->get_var($query);
}

// notification: mark as read
function bidstitch_notification_mark_as_read($id)
{
    global $wpdb;
    $prefix = $wpdb->base_prefix;
    return $wpdb->update(
        "{$prefix}user_notifications",
        ['status' => 1],
        ['id' => $id],
        ['%d'],
        ['%d']
    );
}
