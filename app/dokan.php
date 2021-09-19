<?php

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
            'title' => __('Followers', 'sage'),
            'url' => dokan_get_navigation_url('followers'),
            'icon' => '',
            'pos' => 60,
        ],
    ];

    return $items;
}, 21, 1);

// Override the dokan form field styling for payment methods
function bidstitch_withdraw_method_paypal($store_settings) {
    $current_user = get_current_user();

    $email = isset($store_settings['payment']['paypal']['email']) ? esc_attr($store_settings['payment']['paypal']['email']) : $current_user->user_email;

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