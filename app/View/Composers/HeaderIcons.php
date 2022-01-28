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
            'favorites' => $this->get_wishlist_url(),
            'notifications' => get_field(
                'link_page_all_notification',
                'option'
            ),
        ];
    }

    public function get_wishlist_url() {
        // check if wishlist is active
        if (!class_exists('YITH_WCWL')) return '';

        // get wishlist instance
        $wishlist_instance = \YITH_WCWL::get_instance();

        // check if wishlist instance exists
        if (empty($wishlist_instance)) return '';

        // wishlist url
        $wishlist_url = $wishlist_instance->get_wishlist_url();

        // check if wishlist url exists
        if (empty($wishlist_url)) return '';

        return $wishlist_url;
    }
}
