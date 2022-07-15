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
        $products = [];
        $category = get_field('listings_of_the_week_category', 'option');
        $wc_products = wc_get_products([
            'type' => 'simple',
            'category' => $category->slug,      //
            'stock_status' => 'instock',        //
            'orderby' => 'date',
            'order' => 'ASC',
            // 'featured_product' => '1',
            'limit' => 6,
        ]);
        // $posts = get_posts([
        //     'numberposts' => 6,
        //     'post_type' => 'product',
        //     'meta_key' => '_bidstitch_featured_product',
        //     'meta_value' => '1',
        //     'orderby' => 'date',
        //     'order' => 'ASC',
        // ]);

        foreach ($wc_products as $wc_product) {
        // foreach ($posts as $post) {
            // $wc_product = wc_get_product($post->ID);
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
