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
        $notifications = [];
        foreach (
            bidstitch_get_notifications_for_user(get_current_user_id())
            as $notification
        ) {
            $post_object = get_post($notification->product_id);
            if ($post_object) {
                $notifications[] = [
                    'title' => bidstitch_get_notification_description(
                        $notification->detail_type
                    ),
                    'text' => $post_object->post_title,
                    'thumbnail' => get_the_post_thumbnail_url(
                        $post_object->ID,
                        'thumbnail'
                    ),
                    'link' => get_permalink($post_object->ID),
                    'isOffer' => $notification->type == 'offer',
                ];
            }
        }
        return $notifications;
    }
}
