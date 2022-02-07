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
            'inbox' => $this->get_inbox_url(),
            'favorites' => $this->get_wishlist_url(),
            'notifications' => get_field(
                'link_page_all_notification',
                'option'
            ),
        ];
    }

    protected function get_inbox_url()
    {
        if (dokan_is_seller_enabled(get_current_user_id())) {
            return get_field('link_page_chat_vendor', 'option');
        } else {
            return get_field('link_page_chat_customer', 'option');
        }
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
