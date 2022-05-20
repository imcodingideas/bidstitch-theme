<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class PrimaryNavigation extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.header-primary-navigation',
        'partials.sidenav-primary-navigation',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'navigation' => $this->navigation(),
        ];
    }

    /**
     * Returns the primary navigation.
     *
     * @return array
     */
    public function navigation()
    {
        $navigation = Navi::build('primary_navigation');

        if ($navigation->isEmpty()) {
            return;
        }

        $links = [];

        foreach ($navigation->toArray() as $link) {
            $links[] = $link;

            if ($link->label === 'Buy') {
                $links[] = $this->sell_navigation_item();
            }
        }

        return $links;
    }

    /**
     * Stolen from HeaderNavigation.php
     */
    public function sell_navigation_item () {
        // Sell navigation item
        $sell_nav_item = (object) [
            'label' => __('Sell', 'sage'),
            'url' => '',
            'classes' => '',
            'active' => false,
            // Set children to support Log1x/Navi menu instances
            'children' => [],
            // Set default target to support Log1x/Navi menu instances
            'target' => ''
        ];

        // If user is not logged in, redirect to registration
        if (!is_user_logged_in()) {
            $sell_nav_item->url = esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '#register');

            return $sell_nav_item;
        }

        // If user can sell, show listing links
        $seller_enabled = dokan_is_seller_enabled(get_current_user_id());
        $can_sell = apply_filters('dokan_can_post', true);

        if ($seller_enabled && $can_sell) {
            $sell_nav_item->url = '#';

            // Buy it Now listing
            $sell_nav_item->children[] = (object) [
                'label' => __('Add Buy it Now Listing', 'sage'),
                'url' => esc_url(dokan_get_navigation_url('new-product')),
                'classes' => '',
                'active' => false,
                // Set children to support Log1x/Navi menu instances
                'children' => [],
                // Set default target to support Log1x/Navi menu instances
                'target' => ''
            ];

            // Auction listing
            $sell_nav_item->children[] = (object) [
                'label' => __('Add Auction Listing', 'sage'),
                'url' => esc_url(dokan_get_navigation_url('new-auction-product')),
                'classes' => '',
                'active' => false,
                // Set children to support Log1x/Navi menu instances
                'children' => [],
                // Set default target to support Log1x/Navi menu instances
                'target' => ''
            ];

            return $sell_nav_item;
        }

        // If user can't seller, direct to account upgrade
        $sell_nav_item->url = esc_url(dokan_get_page_url('myaccount', 'woocommerce') . 'account-migration');

        return $sell_nav_item;
    }
}
