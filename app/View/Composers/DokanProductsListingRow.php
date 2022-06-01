<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanProductsListingRow extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.products.products-listing-row'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'product' => $this->product(),
            'sold_url' => $this->sold_url(),
            'edit_url' => $this->edit_url(),
            'delete_url' => $this->delete_url(),
            'can_export_to_shopify' => $this->can_export_to_shopify(),
            'exported_to_shopify' => $this->exported_to_shopify(),
        ];
    }

    function is_auction() {
        return isset($this->data['is_auction']) ? $this->data['is_auction'] : false;
    }

    protected function sold_url()
    {
        global $post;

        $is_auction = $this->is_auction();
        $sold_base_url = dokan_get_navigation_url($is_auction ? 'auction' : 'products');

        return wp_nonce_url(add_query_arg(['action' => 'mark-sold', 'product_id' => $post->ID], $sold_base_url), 'mark-sold');
    }

    public function edit_url() {
        global $post;

        return dokan_edit_product_url($post->ID);
    }

    public function delete_url() {
        global $post;

        $is_auction = $this->is_auction();

        $delete_base_url = dokan_get_navigation_url($is_auction ? 'auction' : 'products');
        $delete_action = $is_auction ? 'dokan-delete-auction-product' : 'dokan-delete-product';

        return wp_nonce_url(add_query_arg(['action' => $delete_action, 'product_id' => $post->ID], $delete_base_url), $delete_action);
    }

    function thumbnail($product) {
        $img_kses = apply_filters('dokan_product_image_attributes', [
            'img' => [
                'alt' => [],
                'class' => [],
                'height' => [],
                'src' => [],
                'width' => [],
                'srcset' => [],
                'data-srcset' => [],
                'data-src' => [],
            ],
        ]);

        return wp_kses($product->get_image('thumbnail', ['class' => 'w-full object-cover h-full']), $img_kses);
    }

    function offers_enabled() {
        global $post;

        return get_post_meta($post->ID, 'offers_for_woocommerce_enabled', true);
    }

    // from plugin: offers-for-woocommerce/public/class-offers-for-woocommerce.php
    // ofw_get_highest_current_offer_data
    function highest_offer() {
        global $post, $wpdb;

        $total_result = $wpdb->get_results($wpdb->prepare("
            SELECT MAX( CAST(postmeta.meta_value AS decimal(11,4)) ) AS max_offer, posts.ID as post_id
            FROM $wpdb->postmeta AS postmeta
            JOIN $wpdb->postmeta pm2 ON pm2.post_id = postmeta.post_id
            INNER JOIN $wpdb->posts AS posts ON ( posts.post_type = 'woocommerce_offer' AND posts.post_status IN ('publish'))
            WHERE postmeta.meta_key LIKE 'offer_price_per' AND pm2.meta_key LIKE 'offer_product_id' AND pm2.meta_value LIKE %d
            AND postmeta.post_id = posts.ID
        ", $post->ID), ARRAY_A);

        $highest_offer = $total_result[0];

        return !empty($highest_offer['max_offer']) ? wc_price(wc_format_decimal(wc_clean($highest_offer['max_offer']))) : false;
    }

    function highest_bid() {
        global $post;

        $highest_bid = get_post_meta($post->ID, '_auction_current_bid', true);

        return $highest_bid ? wc_price(wc_format_decimal(wc_clean($highest_bid))) : false;
    }

    function starting_bid() {
        global $post;

        $starting_bid = get_post_meta($post->ID, '_auction_start_price', true);

        return $starting_bid ? wc_price(wc_format_decimal(wc_clean($starting_bid))) : false;
    }

    protected function can_export_to_shopify()
    {
        global $post;

        $user_id = get_current_user_id();

        if ($post->post_author != $user_id) {
            return false;
        }

        $user_key = 'user_' . $user_id;
        $store_url = get_field('store_url', $user_key);
        $api_key = get_field('api_key', $user_key);
        $api_secret = get_field('api_secret', $user_key);
        $access_token = get_field('access_token', $user_key);

        return $store_url && $api_key && $api_secret && $access_token;
    }

    protected function exported_to_shopify()
    {
        global $post;
        return (int)get_post_meta($post->ID, '_bidstitch_exported_to_shopify');
    }

    public function product() {
        global $post;

        $product = wc_get_product($post->ID);
        if (empty($product) || !$product) return false;

        $is_auction = $this->is_auction();

        return (object) [
            'id' => $post->ID,
            'title' => get_the_title(),
            'thumbnail' => $this->thumbnail($product),
            'url' => esc_url($product->get_permalink($product->get_id())),
            'date' => get_the_date('F j, Y'),
            'price' =>  $product->get_price_html(),
            'highest_offer' => $this->offers_enabled() ? $this->highest_offer() : false,
            'highest_bid' => $is_auction ? $this->highest_bid() : false,
            'starting_bid' => $is_auction ? $this->starting_bid() : false,
        ];
    }
}
