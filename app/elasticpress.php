<?php

add_action('widgets_init', function () {
    register_widget('App\Widgets\ElasticpressSearchWidget');
});

// add wc simple auction meta support
add_filter('ep_prepare_meta_allowed_protected_keys', function($meta_keys){
    $additional_keys = [
        '_auction_item_condition',
        '_auction_type',
        '_auction_proxy',
        '_auction_start_price',
        '_auction_bid_increment',
        '_auction_reserved_price',
        '_auction_dates_from',
        '_auction_dates_to',
        '_auction_current_bid',
        '_auction_current_bider',
        '_auction_max_bid',
        '_auction_max_current_bider',
        '_auction_bid_count',
        '_auction_closed',
        '_auction_has_started',
        '_auction_fail_reason',
        '_order_id',
        '_stop_mails',
        '_auction_wpml_language',
        '_auction_automatic_relist',
        '_auction_relist_fail_time',
        '_auction_relist_not_paid_time',
        '_auction_relist_duration',
        '_regular_price',
    ];

    $payload = array_merge($additional_keys, $meta_keys);

    return $payload;
}, 1, 1);