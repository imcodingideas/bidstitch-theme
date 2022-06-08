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
            'category' => $category->slug,
            'stock_status' => 'instock',
            'orderby' => 'date',
            'order' => 'ASC',
            'limit' => 6,
        ]);

        foreach ($wc_products as $wc_product) {
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
            ];
        }

        return $products;
    }
}
