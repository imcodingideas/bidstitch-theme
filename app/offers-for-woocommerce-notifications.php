<?php

namespace App;

use Illuminate\Support\Facades\Log;

/*
 * Email notifications
 * Override original email templates
 * see: public/class-offers-for-woocommerce.php
 */
add_action(
    'angelleye_offer_for_woocommerce_before_email_send',
    function ($offer_args, $offersClass) {
        /* debug: */
        /* use Illuminate\Support\Facades\Log; */
        /* Log::debug('-----------offer args-----------'); */
        /* Log::debug(var_export($offer_args, true)); */
        /* Log::debug('-----------offer emails-----------'); */
        /* Log::debug(var_export($offersClass, true)); */

        // email templates
        $themePath = get_theme_file_path('resources/views/notifications/');

        // define email template/path (html)
        $offersClass->template_html = 'woocommerce-offer-received.php';
        $offersClass->template_html_path = $themePath;

        // define email template/path (plain)
        $offersClass->template_plain = 'woocommerce-offer-received.php';
        $offersClass->template_plain_path = "$themePath/plain";
        $offersClass->send(
            $offersClass->get_recipient(),
            $offersClass->get_subject(),
            $offersClass->get_content(),
            $offersClass->get_headers(),
            $offersClass->get_attachments()
        );
        wp_die('success');
    },
    10,
    2
);

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
    return $wpdb->get_results($query);
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
