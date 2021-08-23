<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class MyAccountDashboardNavigation extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.myaccount.navigation',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $navgiation = $this->navigation();

        $items = $navgiation->items;
        $active_item = $navgiation->active_item;

        return [
            'navigation' => $items,
            'active_item' => $active_item
        ];
    }

    /**
     * Returns the my account dashboard navigation.
     *
     * @return array
     */
    public function navigation()
    {
        $menu_items = wc_get_account_menu_items();

        $items = [];

        $active_item = (object) [];
        $active_class = 'is-active';

        foreach ($menu_items as $endpoint => $label) {
            $classes = wc_get_account_menu_item_classes($endpoint);

            $is_active = str_contains($classes, $active_class);

            $item = (object) [
                'label' => esc_html($label),
                'url' => esc_url(wc_get_account_endpoint_url($endpoint)),
                'classes' => $classes,
                'active' => $is_active,
                // Set childdren to support Log1x/Navi menu instances
                'children' => [],
                // Set default target to support Log1x/Navi menu instances
                'target' => ''
            ];

            $items[] = $item;

            if ($is_active) {
                $active_item = $item;
            }
        }

        $payload = (object) [
            'items' => $items,
            'active_item' => $active_item
        ];

        return $payload;
    }
}
