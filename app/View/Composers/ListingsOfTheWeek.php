<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ListingsOfTheWeek extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.listings-of-the-week'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'products' => $this->get_products(),
        ];
    }

    protected function get_products()
    {
        // Manual query to bypass ES
        global $wpdb;
        $rows = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_bidstitch_featured_product' AND meta_value != 0 ORDER BY meta_value, post_id LIMIT 6");

        $products = [];

        foreach ($rows as $row) {
            $wc_product = wc_get_product($row->post_id);
            $vendor_id = get_post_field('post_author', $wc_product->get_id());
            $store_info = dokan_get_store_info($vendor_id);
            $store_url = dokan_get_store_url($vendor_id);
            $store_name = $store_info['store_name'];

            $products[] = (object)[
                'title' => $wc_product->get_title(),
                'image_url' => esc_url(wp_get_attachment_image_src($wc_product->get_image_id(), 'thumbnail')[0]),
                'link' => esc_url($wc_product->get_permalink()),
                'vendor' => $store_name,
                'vendor_link' => esc_url($store_url),
                'price' => $wc_product->get_price_html(),
                'in_stock' => $wc_product->is_in_stock(),
            ];
        }

        return $products;
    }
}
