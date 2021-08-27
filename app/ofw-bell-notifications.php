<?php

namespace App;

use function Roots\asset;

/**
 * Add offer notification by offer type.
 *
 * @param array $offer_args Get offer arguments.
 *
 * @param object $emails Get email object.
 */

add_action('angelleye_offer_for_woocommerce_before_email_send', function ( $offer_args, $emails ) {

    if(empty($emails->recipient)) {
        return;
    }

    $user_emails = !empty($emails->recipient) ? explode(',', $emails->recipient) : '';

    if( !empty($user_emails) && is_array($user_emails) ) {

        foreach ( $user_emails as $key => $email ) {

            $user_id = get_user_id_by_email($email);

            if( !empty($user_id) && $user_id > 0 ) {
                $user_sent_id     = get_current_user_id();
                $user_receive_id = $user_id;
                $product_id       = 0;
                $type             = 'offer';
                $detail_type      = get_ofw_notification_type($emails->id);
                $id_offer         = ! empty( $offer_args['offer_id'] ) ? $offer_args['offer_id'] : 0;
                $id_order         = 0;

                Insert_Data_notification( $user_sent_id, $user_receive_id, $product_id, $type, $detail_type, $id_offer, $id_order );
            }
        }

    } else {

        $user_id = get_user_id_by_email($user_emails);

        if( !empty($user_id) && $user_id > 0 ) {
            $user_sent_id     = get_current_user_id();
            $user_receive_id = $user_id;
            $product_id       = 0;
            $type             = 'offer';
            $detail_type      = get_ofw_notification_type($emails->id);
            $id_offer         = ! empty( $offer_args['offer_id'] ) ? $offer_args['offer_id'] : 0;
            $id_order         = 0;

            Insert_Data_notification( $user_sent_id, $user_receive_id, $product_id, $type, $detail_type, $id_offer, $id_order );
        }
    }

}, 9, 2);

/**
 * Get user_id by email.
 *
 * @param string $email Get email.
 *
 * @return int User_id.
 */
function get_user_id_by_email( $email ){

    if(empty($email)) {
        return 0;
    }

    $user = get_user_by( 'email', trim($email) );

    return !empty($user->ID) ? $user->ID : 0;
}

/**
 * Get offer notification type by email type.
 *
 * @param string $type Get offer notification type.
 *
 * @return string $notification_type Return notification type.
 */
function get_ofw_notification_type( $type = 'wc_new_offer' ) {

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
