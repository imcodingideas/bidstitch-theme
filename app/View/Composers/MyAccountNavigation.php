<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class MyAccountNavigation extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.header-myaccount-navigation',
        'partials.sidenav-myaccount-navigation',
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
        $navigation = Navi::build('myaccount_navigation');

        if ($navigation->isEmpty()) {
            return;
        }

        $payload = $navigation->toArray();

        // Remove vendor items if not a vendor
        if (!dokan_is_user_seller(get_current_user_id())) {
            foreach ($payload as $key => $menu_item) {
                if ($menu_item->slug === 'my-store') {
                    unset($payload[$key]);
                }
            }
        }

        // Logout
        $payload[] = (object) [
            'label' => __('Logout', 'sage'),
            'url' => esc_url(wc_logout_url()),
            'classes' => '',
            'active' => false,
            // Set children to support Log1x/Navi menu instances
            'children' => [],
            // Set default target to support Log1x/Navi menu instances
            'target' => ''
        ];

        return $payload;
    }
}
