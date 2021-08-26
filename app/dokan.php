<?php
use \WeDevs\Dokan\Dashboard\Templates\Main;

// remove dashboard nav
add_action('init', function () {
    $class_name = Main::class;

    remove_action('dokan_dashboard_content_before', array($class_name, 'dashboard_side_navigation'));
}, 6);

// update dashboard menu items
add_filter('dokan_get_dashboard_nav', function($items) {
    $new_items = $items;

    // add new items
    $new_items['shipping'] = [
        'title' => __( 'Shipping', 'dokan'),
        'url' => dokan_get_navigation_url('settings/shipping'),
        'icon' => '',
    ];

    foreach($new_items as $endpoint => $data) {
        switch ($endpoint) {
            // remove unwanted items
            case 'coupons':
            case 'reports':
            case 'staffs':
            case 'reviews':
            case 'announcement':
            case 'support':
            case 'withdraw':
            case 'auction':
                unset($new_items[$endpoint]);
                break;

            // update existing items
            case 'dashboard':
                $new_items[$endpoint]['title'] = __( 'My Store', 'dokan');
                break;
            case 'settings':
                $new_items[$endpoint]['title'] = __( 'Store Settings', 'dokan');
                $new_items[$endpoint]['url'] = dokan_get_navigation_url('settings/store');
                break;
            case 'products':
                $new_items[$endpoint]['title'] = __( 'Active Listings', 'dokan');
                break;
            case 'orders':
                $new_items[$endpoint]['title'] = __( 'Sold Listings', 'dokan');
                break;

            default:
                break;
        }
    }

    return $new_items;
}, 21, 1);