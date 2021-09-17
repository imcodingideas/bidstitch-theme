<?php
add_action('woocommerce_init', function() {
    global $woocommerce_auctions;
    if (!isset($woocommerce_auctions)) return;

    // remove auctions filtering
    remove_action('woocommerce_product_query', array($woocommerce_auctions, 'pre_get_posts'), 99, 2);

    // update auctions filtering query
    add_action('woocommerce_product_query', 'bs_pre_get_posts', 999, 2);

    // remove auction icon from single product loop
    remove_action('woocommerce_before_shop_loop_item_title', array($woocommerce_auctions, 'add_auction_bage'), 60);
});

// from plugin: woocommerce-simple-auctions
// woocommerce-simple-auctions/woocommerce-simple-auctions.php
// pre_get_posts
function bs_pre_get_posts($q, $query) {
    if (is_admin() || !$q->is_main_query()) return;

    $simple_auctions_sealed_on = get_option('simple_auctions_sealed_on', 'no');

    function bs_get_tax_query($q) {
        $tax_query = $q->get('tax_query');
        if (!is_array($tax_query)) $tax_query = [];

        return $tax_query;
    }

    function bs_get_meta_query($q) {
        $meta_query = $q->get('meta_query');
        if (!is_array($meta_query)) $meta_query = [];

        return $meta_query;
    }

    function bs_set_auction_tax($q) {
        $tax_query = bs_get_tax_query($q);

        $tax_query[] = [
            [
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction',
            ]
        ];

        $q->set('tax_query', $tax_query);
    }

    function bs_set_post_type($q) {
        $q->set('post_type', 'product');
        $q->set('ignore_sticky_posts', 1);
    }

    function bs_set_auction_sealed($q, $simple_auctions_sealed_on) {
        if ($simple_auctions_sealed_on == 'yes') {
            $meta_query = bs_get_tax_query($q);

            $meta_query[] = [
                'relation' => 'OR',
                [
                    'key' => '_auction_sealed',
                    'compare' => 'NOT EXISTS',
                ], [
                    'key'   => '_auction_sealed',
                    'value' => 'no',
                ]
            ];

            $q->set('meta_query', $meta_query);
        }
    }

    function bs_set_auction_past($q) {
        $meta_query = bs_get_meta_query($q);

        $meta_query[] = [
            'key' => '_auction_dates_to',
            'value' => date_i18n('Y-m-d H:i:s', false, true),
            'type' => 'DATETIME',
            'compare' => '>=',
        ];

        $q->set('meta_query', $meta_query);
    }

    function bs_set_auction_future($q) {
        $meta_query = bs_get_meta_query($q);

        $meta_query[] = [
            'key' => '_auction_dates_from',
            'value' => date_i18n('Y-m-d H:i:s', false, true),
            'type' => 'DATETIME',
            'compare' => '<=',
        ];

        $q->set('meta_query', $meta_query);
    }

    if (isset($q->query_vars['is_auction_archive']) && $q->query_vars['is_auction_archive'] == 'true') {
        bs_set_auction_tax($q);

        // from plugin
        // hack for displaying auctions when Shop Page Display is set to show categories
        add_filter('woocommerce_is_filtered', function() { return true; }, 99);

        $orderby = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('wsa_default_auction_orderby', get_option('wsa_default_auction_orderby'));
    } else {
        $orderby = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : ($q->get('orderby') ? $q->get('orderby') : false);
    }

    switch ($orderby) {
        case 'bid_desc':
            bs_set_post_type($q);
            bs_set_auction_tax($q);
            bs_set_auction_sealed($q, $simple_auctions_sealed_on);

            $q->query['show_future_auctions'] = false;
            $q->query['show_past_auctions'] = false;

            $q->set('meta_key', '_auction_current_bid');
            $q->set('orderby', 'meta_value_num');
            $q->set('order', 'ASC');
  
            break;
        case 'bid_asc':
            bs_set_post_type($q);
            bs_set_auction_tax($q);
            bs_set_auction_sealed($q, $simple_auctions_sealed_on);

            $q->query['show_future_auctions'] = false;
            $q->query['show_past_auctions'] = false;

            $q->set('meta_key', '_auction_current_bid');
            $q->set('orderby', 'meta_value_num');
            $q->set('order', 'DESC');
            break;
        case 'auction_end':
            bs_set_post_type($q);
            bs_set_auction_tax($q);
            
            $q->query['show_future_auctions'] = false;
            $q->query['show_past_auctions'] = false;

            $q->set('meta_key', '_auction_dates_to');
            $q->set('orderby', 'meta._auction_dates_to.datetime');
            $q->set('order', 'ASC');
            
            break;
        case 'auction_started':
            bs_set_post_type($q);
            bs_set_auction_tax($q);

            $q->query['show_future_auctions'] = false;
            $q->query['show_past_auctions'] = false;

            $q->set('meta_key', '_auction_dates_from');
            $q->set('orderby', 'meta._auction_dates_from.datetime');
            $q->set('order', 'ASC');

            break;
        case 'auction_activity':
            bs_set_post_type($q);
            bs_set_auction_tax($q);

            $q->query['show_future_auctions'] = false;
            $q->query['show_past_auctions'] = false;

            $q->set('meta_key', '_auction_bid_count');
            $q->set('orderby', 'meta_value_num');
            $q->set('order', 'DESC');

            break;
    }

    if (isset($q->query['show_past_auctions']) && $q->query['show_past_auctions'] == false) {
        bs_set_auction_past($q);
    }

    if (isset($q->query['show_future_auctions']) && $q->query['show_future_auctions'] == false) {
        bs_set_auction_future($q);
    }
}
