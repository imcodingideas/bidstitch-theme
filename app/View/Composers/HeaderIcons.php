<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class HeaderIcons extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.header-icons'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'inbox' => get_field('link_page_chat_vendor', 'option'),
            'favorites' => get_field('link_page_favorites', 'option'),
            'notifications' => get_field(
                'link_page_all_notification',
                'option'
            ),
            'notifications_count' => $this->notifications_count(),
            'cart_url' => wc_get_cart_url(),
            'cart_count' => WC()->cart->cart_contents_count,
        ];
    }
    public function notifications_count()
    {
        if (!is_user_logged_in()) {
            return 0;
        }

        $user_id = get_current_user_id();
        $notifications_count = 0;
        global $wpdb;
        $query = $wpdb->get_row(
            "SELECT count(*) as count FROM `{$wpdb->base_prefix}user_notifications` WHERE user_receieve_id = $user_id and status = 0 Order by created_at DESC "
        );

        if (isset($query->count)) {
            $notifications_count = $query->count;
        }

        return $notifications_count;
    }
}
