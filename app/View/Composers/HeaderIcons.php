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
            'cart' => function_exists('wc_get_cart_url')
                ? wc_get_cart_url()
                : '',
        ];
    }
    public function notifications_count()
    {
        if (!is_user_logged_in()) {
            return 0;
        }

        return notifications_notread_all(get_current_user_id());
    }
}
