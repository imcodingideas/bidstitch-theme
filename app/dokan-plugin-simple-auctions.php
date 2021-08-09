<?php

/*
 * Functions required by custom version of woocommerce-simple-auctions
 * Custom version of that plugin seems to be based on 1.2.40
 */

function Insert_Data_notification(
    $user_sent_id = null,
    $user_receieve_id = null,
    $product_id = null,
    $type = null,
    $detail_type = null,
    $id_offer = null,
    $id_order = null
) {
    global $wpdb;
    $wpdb->insert("{$wpdb->base_prefix}user_notifications", [
        'user_sent_id' => $user_sent_id,
        'user_receieve_id' => $user_receieve_id,
        'product_id' => $product_id,
        'type' => $type,
        'detail_type' => $detail_type,
        'id_offer' => $id_offer,
        'id_order' => $id_order,
        'created_at' => date('Y-m-d H:i:s', time()),
    ]);
}
