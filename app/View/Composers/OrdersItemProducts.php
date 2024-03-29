<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class OrdersItemProducts extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.orders-item-products'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $order = $this->order();

        return [
            'products' => $order ? $this->products($order) : (object) [],
        ];
    }

    public function products($order) {
        $products = [];

        foreach($order->get_items() as $item_id => $item) {
            $product = $item->get_product();

            $payload = [
                'name' => $item->get_name(),
                'total' => wc_price($item->get_total()),
                'link' => '#',
                'thumbnail' => false,
                'store_name' => '-',
                'store_link' => '#',
                'store_id' => ''
            ];

            if ($product) {
                $vendor_id = $product->post->post_author;
                $store = dokan_get_store_info($vendor_id);

                $payload['link'] = $product->get_permalink();
                $payload['thumbnail'] = $product->get_image('thumbnail', ['class' => 'object-center object-cover rounded mr-1 md:mr-6 order__product__img'], true);
                $payload['store_name'] = $store['store_name'];
                $payload['store_link'] = dokan_get_store_url($vendor_id);
                $payload['store_id'] = $vendor_id;
            }

            $products[] = (object) $payload;
        }

        return $products;
    }

    public function order() {
        if (!isset($this->data['order'])) {
            return false;
        }

        $order = wc_get_order($this->data['order']);

        return $order;
    }
}
