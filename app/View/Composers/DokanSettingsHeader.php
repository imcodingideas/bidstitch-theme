<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanSettingsHeader extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.settings.header'];

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

    public function get_active_menu_item() {
        global $wp;

        $request = $wp->request;
        $active = explode('/', $request);

        unset($active[0]);

        if ($active) {
            $active_menu = implode('/', $active);
        } else {
            $active_menu = 'dashboard';
        }

        return apply_filters('dokan_dashboard_nav_active', $active_menu, $request, $active);
    }

    public function navigation() {
        $active_menu_item = $this->get_active_menu_item();

        $navigation = [];

        // Store Settings
        $navigation[] = (object) [
            'label' => __('Store', 'sage'),
            'link' => esc_url(dokan_get_navigation_url('settings/store')),
            'active' => $active_menu_item === 'settings/store',
        ];

        // Payment Settings
        $navigation[] = (object) [
            'label' => __('Payment', 'sage'),
            'link' => esc_url(dokan_get_navigation_url('settings/payment')),
            'active' => $active_menu_item === 'settings/payment',
        ];

        // Shiping Settings
        $navigation[] = (object) [
            'label' => __('Shipping', 'sage'),
            'link' => esc_url(dokan_get_navigation_url('settings/shipping')),
            'active' => $active_menu_item === 'settings/shipping',
        ];

        // Subscription Settings
        $navigation[] = (object) [
            'label' => __('Subscription', 'sage'),
            'link' => esc_url(dokan_get_navigation_url('subscription')),
            'active' => $active_menu_item === 'subscription',
        ];

        return $navigation;
    }
}
