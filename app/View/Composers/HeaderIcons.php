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
            'cart_url' => wc_get_cart_url(),
            'cart_count' => WC()->cart->cart_contents_count,
        ];
    }
}
