<?php

namespace App\View\Composers;
use Roots\Acorn\View\Composer;

class MyAccountDashboard extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.dashboard'];
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

    public function navigation() {
        $items = [];

        // Orders
        $items[] = (object) [
            'label' => __('Orders', 'sage'),
            'link' => esc_url(wc_get_account_endpoint_url('orders')),
            'description' => __('View your recent purchases and keep track of the status of your orders.', 'sage'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
        ];

        // Addresses
        $items[] = (object) [
            'label' => __('Addresses', 'sage'),
            'link' => esc_url(wc_get_account_endpoint_url('edit-address')),
            'description' => __('Update your default billing and shipping addresses.', 'sage'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        ];

        // Messages
        if (dokan_is_seller_enabled(get_current_user_id())) {
            $inbox_url = get_field('link_page_chat_vendor', 'option');
        } else {
            $inbox_url = get_field('link_page_chat_customer', 'option');
        }

        $items[] = (object) [
            'label' => __('Messages', 'sage'),
            'link' => esc_url($inbox_url),
            'description' => __('View your conversations between other users of the platform.', 'sage'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
        ];

        // Settings
        $items[] = (object) [
            'label' => __('Account Settings', 'sage'),
            'link' => esc_url(wc_get_account_endpoint_url('edit-account')),
            'description' => __('Update your basic account details and settings.', 'sage'),
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        ];

        return $items;
    }
}