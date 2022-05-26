<?php

use WeDevs\DokanPro\Shipping\ShippingZone;

add_action('init', function () {
    // remove dashboard nav
    remove_action('dokan_dashboard_content_before', [\WeDevs\Dokan\Dashboard\Templates\Main::class, 'dashboard_side_navigation']);
    // remove profile progress
    remove_action('dokan_settings_content_area_header', [dokan()->dashboard->templates->settings, 'render_settings_load_progressbar'], 20);
}, 6);

// remove font-awesome
add_action('wp_enqueue_scripts', function() {
    wp_deregister_style('dokan-fontawesome');
    wp_dequeue_style('dokan-fontawesome');

    // remove font-awesome from dokan-follow-store style depedencies
    if (defined('DOKAN_FOLLOW_STORE_ASSETS') && defined('DOKAN_FOLLOW_STORE_VERSION')) {
        wp_deregister_style('dokan-follow-store');

        // Use minified libraries if SCRIPT_DEBUG is turned off
        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
        wp_enqueue_style('dokan-follow-store', DOKAN_FOLLOW_STORE_ASSETS . '/css/follow-store' . $suffix . '.css', [], DOKAN_FOLLOW_STORE_VERSION);
    }
}, 11);

// Newly registered vendors get default shipping rates added
add_action('dokan_new_seller_created', function($user_id, $dokan_settings) {
    global $wpdb;

    $costs = [
        'USA' => 10,
        'Canada' => 15,
    ];

    $zones = ShippingZone::get_zones();

    foreach ($zones as $zone_id => $zone) {
        if (isset($costs[$zone['zone_name']])) {
            // NOTE: calling Shippingzone::add_shipping_methods() does not populate user_id
            // since it relies on dokan_get_current_user_id() and the new user is not yet logged in
            // $data = [
            //     'zone_id'   => $zone_id,
            //     'method_id' => 'flat_rate',
            //     'settings'  => [
            //         'title' => 'Flat Rate',
            //         'cost' => $costs[$zone['zone_name']],
            //         'description' => 'flat rate',
            //         'tax_status' => 'none',
            //     ],
            // ];

            // ShippingZone::add_shipping_methods($data);

            $settings = [
                'title' => 'Flat Rate',
                'cost' => $costs[$zone['zone_name']],
                'description' => 'flat rate',
                'tax_status' => 'none',
            ];

            $result = $wpdb->insert(
                "{$wpdb->prefix}dokan_shipping_zone_methods",
                [
                    'method_id' => 'flat_rate',
                    'zone_id' => $zone_id,
                    'seller_id' => $user_id,
                    'is_enabled' => 1,
                    'settings' => maybe_serialize($settings),
                ], [
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                    '%s',
                ]
            );
        }
    }
}, 99, 2);

// update dashboard menu items
add_filter('dokan_get_dashboard_nav', function($items) {
    $items = [
        [
            'title' => __('View Store', 'sage'),
            'url' => dokan_get_store_url(get_current_user_id()),
            'icon' => '',
            'pos' => 10,
        ],
        [
            'title' => __('Store Settings', 'sage'),
            'url' => dokan_get_navigation_url('settings/store'),
            'icon' => '',
            'pos' => 20,
        ],
        [
            'title' => __('Active Listings', 'sage'),
            'url' => dokan_get_navigation_url('products'),
            'icon' => '',
            'pos' => 30,
        ],
        [
            'title' => __('Sold Listings', 'sage'),
            'url' => dokan_get_navigation_url('orders'),
            'icon' => '',
            'pos' => 40,
        ],
        [
            'title' => __('Received Offers', 'sage'),
            'url' => dokan_get_navigation_url('woocommerce_offer'),
            'icon' => '',
            'pos' => 50,
        ],
        [
            'title' => __('Coupons', 'sage'),
            'url' => dokan_get_navigation_url('coupons'),
            'icon' => '',
            'pos' => 60,
        ],
        [
            'title' => __('Followers', 'sage'),
            'url' => dokan_get_navigation_url('followers'),
            'icon' => '',
            'pos' => 70,
        ],
        [
            'title' => __('Subscription', 'sage'),
            'url' => dokan_get_navigation_url('subscription'),
            'icon' => '',
            'pos' => 80,
        ],
        [
            'title' => __('Update Credit Card', 'sage'),
            'url' => dokan_get_navigation_url('payment'),
            'icon' => '',
            'pos' => 90,
        ],
    ];

    return $items;
}, 21, 1);

// Add a separate page for updating CC details
add_filter('dokan_query_var_filter', function($query_vars) {
    $query_vars['payment'] = 'payment';
    return $query_vars;
});

add_action('dokan_load_custom_template', function($query_vars) {
    if (isset($query_vars['payment'])) {
        echo \Roots\view('dokan.vendor-payment-settings')->render();
    }
});

// Override the dokan form field styling for payment methods
function bidstitch_withdraw_method_paypal($store_settings) {
    $current_user = wp_get_current_user();

    $email = $current_user->user_email;

    if (
        isset($store_settings['payment'])
    &&
        isset($store_settings['payment']['paypal'])
    &&
        isset($store_settings['payment']['paypal']['email'])
    &&
        !empty($store_settings['payment']['paypal']['email'])
    ) {
        $email = esc_attr($store_settings['payment']['paypal']['email']);
    }

    $view_args = [
        'email' => $email,
    ];

    echo \Roots\view('dokan.withdraw-methods.paypal', $view_args)->render();
}

function bidstitch_withdraw_methods($methods) {
    $methods['paypal']['callback'] = 'bidstitch_withdraw_method_paypal';

    return $methods;
}
add_filter('dokan_withdraw_methods', 'bidstitch_withdraw_methods', 21, 1);

// Disable save payment method on dokan stripe checkout
function bidstitch_stripe_display_save_payment_method_checkbox($display_tokenization) {
    return false;
}
add_filter('dokan_stripe_display_save_payment_method_checkbox', 'bidstitch_stripe_display_save_payment_method_checkbox', 21, 1);

// Remove vendor dashboard button on my account page
remove_action('woocommerce_account_dashboard', 'dokan_set_go_to_vendor_dashboard_btn');

// Remove "Untitled" from store page titles
// NOTE: no post data is available inside this hook.
add_filter('the_seo_framework_title_from_generation', function($title, $args) {
    if ($args === null) {
        $vendor = dokan()->vendor->get(get_query_var('author'));

        if ($vendor && $title === the_seo_framework()->get_static_untitled_title()) {
            $title = $vendor->get_shop_name();
        }
    }

    return $title;
}, 10, 2);

// Add reminder to vendors' emails to set their orders to complete once shipped
add_action('woocommerce_email_after_order_table', function($order) {
    // Don't display this for completed orders
    if ($order->has_status('completed')) {
        return;
    }

    // Also don't display for subscription orders if they haven't been marked complete yet
    foreach ($order->get_items() as $item) {
        $product = wc_get_product($item->get_data()['product_id']);

        if ($product->get_type() === 'product_pack') {
            return;
        }
    }

    echo \Roots\view('partials.vendor-new-order-completion-reminder', ['completed' => $order->status === 'completed'])->render();
});
