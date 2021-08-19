<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DashboardNav extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.dashboard-nav'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $active_menu = $this->active_menu();
        return [
            'home_url' => home_url(),
            'title_my_shop' => get_field('title_my_shop', 'option'),
            'active_menu' => $active_menu,
            'settings_menu' => $this->settings_menu($active_menu),
            'account_menu' => $this->account_menu(),
            'default_menu' => $this->default_menu($active_menu),
        ];
    }
    // from plugin: dokan-lite/includes/Dashboard/Templates/Main.php
    function active_menu()
    {
        global $wp;

        $request = $wp->request;
        $active = explode('/', $request);

        unset($active[0]);

        if ($active) {
            $active_menu = implode('/', $active);

            if ($active_menu == 'new-product') {
                $active_menu = 'products';
            }

            if (get_query_var('edit') && is_singular('product')) {
                $active_menu = 'products';
            }
        } else {
            $active_menu = 'dashboard';
        }

        return apply_filters(
            'dokan_dashboard_nav_active',
            $active_menu,
            $request,
            $active
        );
    }
    function settings_menu($active_menu)
    {
        global $allowedposttags;
        // These are required for the hamburger menu.
        if (is_array($allowedposttags)) {
            $allowedposttags['input'] = [
                'id' => [],
                'type' => [],
                'checked' => [],
            ];
        }
        $nav_menu = dokan_get_dashboard_nav();
        $active_menu_parts = explode('/', $active_menu);
        $urls = [];
        if (
            isset($active_menu_parts[1]) &&
            ($active_menu_parts[1] === 'settings' ||
                $active_menu_parts[0] === 'settings') &&
            isset($nav_menu['settings']['sub']) &&
            (array_key_exists(
                $active_menu_parts[1],
                $nav_menu['settings']['sub']
            ) ||
                array_key_exists(
                    $active_menu_parts[2],
                    $nav_menu['settings']['sub']
                ))
        ) {
            $items = $nav_menu['settings']['sub'];

            foreach ($items as $key => $item) {
                $class = $active_menu === $key ? 'active ' . $key : $key;
                //hide verification
                if ($key != 'verification') {
                    $urls[] = [
                        'class' => $class,
                        'url' => $item['url'],
                        'icon' => $item['icon'],
                        'label' => $item['title'],
                    ];
                }
            }
        }
        return $urls;
    }
    function account_menu()
    {
        $items = [];
        foreach (wc_get_account_menu_items() as $endpoint => $label) {
            $class = wc_get_account_menu_item_classes($endpoint);

            if ($endpoint == 'dashboard') {
                $url = wc_get_account_endpoint_url($endpoint);
            } else {
                $url = wc_get_endpoint_url(
                    $endpoint,
                    '',
                    wc_get_page_permalink('myaccount')
                );
            }
            $items[] = compact('class', 'url', 'label');
        }
        return $items;
    }
    function default_menu($active_menu)
    {
        return [
            [
                'class' => '',
                'url' => dokan_get_navigation_url(''),
                'label' => 'Dashboard',
            ],
            [
                'class' => $active_menu == 'orders' ? 'active' : '',
                'url' => dokan_get_navigation_url('reports'),
                'label' => get_field('title_reports', 'option'),
            ],

            [
                'class' => $active_menu == 'orders' ? 'active' : '',
                'url' => dokan_get_navigation_url('orders'),
                'label' => get_field('title_sales_history', 'option'),
            ],

            [
                'class' => $active_menu == 'products' ? 'active' : '',
                'url' => dokan_get_navigation_url('products'),
                'label' => get_field('title_my_listings', 'option'),
            ],

            [
                'class' => $active_menu == 'auction' ? 'active' : '',
                'url' => dokan_get_navigation_url('auction'),
                'label' => get_field('title_auction', 'option'),
            ],

            [
                'class' => $active_menu == 'coupons' ? 'active' : '',
                'url' => dokan_get_navigation_url('coupons'),
                'label' => get_field('title_coupons', 'option'),
            ],

            [
                'class' => $active_menu == 'subscription' ? 'active' : '',
                'url' => dokan_get_navigation_url('subscription'),
                'label' => get_field('title_subscription', 'option'),
            ],

            [
                'class' => $active_menu == 'inbox' ? 'active' : '',
                'url' => dokan_get_navigation_url('inbox'),
                'label' => get_field('title_inbox', 'option'),
            ],
            [
                'class' => $active_menu == 'settings/store' ? 'active' : '',
                'url' => dokan_get_navigation_url('settings/store'),
                'label' => get_field('title_shop_settings', 'option'),
            ],
            [
                'class' => $active_menu == 'settings/shipping' ? 'active' : '',
                'url' => dokan_get_navigation_url('settings/shipping'),
                'label' => 'Shipping',
            ],
            [
                'class' => $active_menu == 'support' ? 'active' : '',
                'url' => dokan_get_navigation_url('support'),
                'label' => 'Support',
            ],
        ];
    }
}
