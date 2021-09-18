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

    public function get_message_button_data($vendor_id = '') {
        if(!$vendor_id || empty($vendor_id)) return false;

        $store_user = dokan()->vendor->get($vendor_id);
        if (!$store_user) return false;
        
        $payload = [
            'id' => $store_user->get_id(),
            'name' => !empty($store_user->get_shop_name()) ? $store_user->get_shop_name() : 'fakename',
            'photoUrl' => esc_url(get_avatar_url($store_user->get_id())),
        ];

        return json_encode($payload);
    }

    public function products($order) {
        $products = [];

        foreach($order->get_items() as $item_id => $item) {
            $product = $item->get_product();

            $payload = [
                'name' => $item->get_name(),
                'total' => wc_price($item->get_total()),
                'link' => false,
                'thumbnail' => false,
                'store_name' => false,
                'store_link' => false,
                'message_button_data' => false
            ];

            if ($product) {
                $vendor_id = $product->post->post_author;
                $store = dokan_get_store_info($vendor_id);

                $payload['link'] = $product->get_permalink();
                $payload['thumbnail'] = $product->get_image('thumbnail', ['class' => 'object-center object-cover rounded mr-6 order__product__img'], true);
                $payload['store_name'] = $store['store_name'];
                $payload['store_link'] = dokan_get_store_url($vendor_id);
                $payload['message_button_data'] = $vendor_id ? $this->get_message_button_data($vendor_id) : false;
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
