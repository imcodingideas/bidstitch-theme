<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\bidstitch_get_notification_description;
use function App\bidstitch_get_unread_notifications_for_user;

class HeaderNotifications extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.header-notifications'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'user_notifications' => $this->user_notifications(),
            'offers_link' => dokan_get_navigation_url('woocommerce_offer')
        ];
    }
    function user_notifications()
    {
        return bidstitch_get_unread_notifications_for_user(
            get_current_user_id()
        );
    }
}
