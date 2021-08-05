<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class VendorInfo extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.vendor-info'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        global $product, $wpdb;

        $user_id = get_post_field('post_author', get_the_id());

        $store_info = dokan_get_store_info($user_id);
        $store_name = $store_info['store_name']; // Get the store name
        $store_url = dokan_get_store_url($user_id);

        $orders_count = dokan_count_orders($user_id);
        $store_total_sales = $orders_count->total;

        $store_instagramhandle = isset($store_info['instagramhandle'])
            ? $store_info['instagramhandle']
            : '';

        $customer_id = get_current_user_id();
        $status = null;

        $btn_labels = dokan_follow_store_button_labels();

        if (dokan_follow_store_is_following_store($user_id, $customer_id)) {
            $label_current = $btn_labels['following'];
            $status = 'following';
        } else {
            $label_current = $btn_labels['follow'];
        }

        $args_btn_follow = [
            'label_current' => $label_current,
            'label_unfollow' => $btn_labels['unfollow'],
            'vendor_id' => $user_id,
            'status' => $status,
            'button_classes' => 'btn btn--white px-8 py-2 uppercase',
            'is_logged_in' => $customer_id,
        ];

        $vendor_id = apply_filters('wcfm_current_vendor_id', $user_id);

        $count_product = 0;
        $count_following = dokan_get_following($user_id);
        $count_followers = dokan_get_followers($vendor_id);

        $store_user = dokan()->vendor->get($vendor_id);
        $product_count = count_user_posts($vendor_id, 'product');
        return compact(
            'args_btn_follow',
            'product_count',
            'store_instagramhandle',
            'store_name',
            'store_total_sales',
            'store_url',
            'store_user',
            'vendor_id'
        );
    }
}
