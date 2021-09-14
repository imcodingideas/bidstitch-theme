<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class DashboardNavigation extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.dashboard-navigation'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $active_menu = $this->active_menu();

        $account_navigation = $this->account_navigation($active_menu);
        $vendor_navigation = $this->vendor_navigation($active_menu);

        return [
            'account_navigation' => $account_navigation,
            'vendor_navigation' => $vendor_navigation,
            'seller_enabled' => $this->seller_enabled(),
        ];
    }

    public function seller_enabled() {
        $user_id = get_current_user_id();

        return dokan_is_seller_enabled($user_id);
    }

    function active_menu()
    {
        global $wp;

        $request = $wp->request;
        $active = explode('/', $request);

        $active_length = count($active);

        if ($active_length > 1) {
            unset($active[0]);
        }

        return $active[$active_length - 1];
    }

    public function vendor_navigation($active_menu)
    {
        $menu_items = dokan_get_dashboard_nav();

        $items = [];

        foreach($menu_items as $endpoint => $menu_item) {
            $item = (object) [
                'label' => $menu_item['title'],
                'url' => $menu_item['url'],
                'classes' => '',
                'active' => $active_menu === $endpoint,
                // Set children to support Log1x/Navi menu instances
                'children' => [],
                // Set default target to support Log1x/Navi menu instances
                'target' => ''
            ];

            $items[] = $item;
        }

        return $items;
    }

    public function account_navigation($active_menu)
    {
        $wc_menu = wc_get_account_menu_items();

        $items = [];

        foreach ($wc_menu as $endpoint => $label) {
            $target_endpoint = $endpoint;

            if ($endpoint === 'dashboard') {
                $target_endpoint = 'my-account';
            }
            
            $item = (object) [
                'label' => esc_html($label),
                'url' => esc_url(wc_get_account_endpoint_url($endpoint)),
                'classes' => '',
                'active' => $target_endpoint === $active_menu ? true : false,
                // Set children to support Log1x/Navi menu instances
                'children' => [],
                // Set default target to support Log1x/Navi menu instances
                'target' => ''
            ];

            $items[] = $item;
        }

        // Wishlist
        $wishlist_endpoint = YITH_WCWL()->get_wishlist_url();
        $items[] = (object) [
            'label' => __('Wishlist', 'sage'),
            'url' => esc_url($wishlist_endpoint),
            'classes' => '',
            'active' => $wishlist_endpoint === $active_menu ? true : false,
            // Set children to support Log1x/Navi menu instances
            'children' => [],
            // Set default target to support Log1x/Navi menu instances
            'target' => ''
        ];

        
        // Messages
        $messages_endpoint = dokan_get_navigation_url('inbox');
        $items[] = (object) [
            'label' => __('Messages', 'sage'),
            'url' => esc_url($messages_endpoint),
            'classes' => '',
            'active' => $messages_endpoint === $active_menu ? true : false,
            // Set children to support Log1x/Navi menu instances
            'children' => [],
            // Set default target to support Log1x/Navi menu instances
            'target' => ''
        ];

        // Following
        $following_endpoint = wc_get_account_endpoint_url('following');
        $items[] = (object) [
            'label' => __('Following', 'sage'),
            'url' => esc_url($following_endpoint),
            'classes' => '',
            'active' => $following_endpoint === $active_menu ? true : false,
            // Set children to support Log1x/Navi menu instances
            'children' => [],
            // Set default target to support Log1x/Navi menu instances
            'target' => ''
        ];

        return $items;
    }
}
