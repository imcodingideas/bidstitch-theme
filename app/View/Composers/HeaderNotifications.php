<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\bidstitch_get_notification_description;
use function App\bidstitch_get_notifications_for_user;

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
        ];
    }
    function user_notifications()
    {
        $notifications = bidstitch_get_notifications_for_user(
            get_current_user_id()
        );
        return array_map(function ($notification) {
            $product = get_post($notification->product_id);
            return [
                'title' => bidstitch_get_notification_description(
                    $notification->detail_type
                ),
                'text' => $product->post_title,
                'thumbnail' => get_the_post_thumbnail_url(
                    $product->ID,
                    'thumbnail'
                ),
                'link' => get_permalink($product->ID),
                'isOffer' => $notification->type == 'offer',
            ];
        }, $notifications);
    }
}
