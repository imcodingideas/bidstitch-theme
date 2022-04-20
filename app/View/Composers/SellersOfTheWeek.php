<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SellersOfTheWeek extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['partials.sellers-of-the-week'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'vendors' => $this->get_vendors(),
        ];
    }

    protected function get_vendors()
    {
        $vendors = [];
        $vendor_ids = get_field('sellers_of_the_week', 'option');

        foreach ($vendor_ids as $vendor_id) {
            $store_info = dokan_get_store_info($vendor_id);

            $vendors[] = (object)[
                'link' => dokan_get_store_url($vendor_id),
                'name' => $store_info['store_name'],
                'products' => $this->get_products($vendor_id),
            ];
        }

        return $vendors;
    }

    protected function get_products($vendor_id)
    {
        $products = [];

        $wc_products = wc_get_products([
            'type' => 'simple',
            'author' => $vendor_id,
            'orderby' => 'date',
            'order' => 'DESC',
            'limit' => 2,
        ]);

        foreach ($wc_products as $wc_product) {
            $products[] = (object)[
                'title' => $wc_product->get_title(),
                'image_url' => esc_url(wp_get_attachment_image_src($wc_product->get_image_id(), 'thumbnail')[0]),
                'link' => esc_url($wc_product->get_permalink()),
                'price' => $wc_product->get_price_html(),
            ];
        }

        return $products;
    }
}
