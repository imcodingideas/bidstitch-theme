<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class OrdersItemHeader extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.orders-item-header'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $order = $this->order();

        return [
            'order_date' => $order ? $this->order_date($order) : (object) [],
            'order_number' => $order ? $this->order_number($order) : '',
            'order_total' => $order ? $this->order_total($order) : '',
            'order_link' => $order ? $this->order_link($order) : '',
            'product_count' => $order ? $this->product_count($order) : '',
        ];
    }

    public function order_link($order) {
        return $order->get_view_order_url();
    }

    public function order_total($order) {
        return $order->get_formatted_order_total();
    }

    public function order_number($order) {
        return $order->get_order_number($order);
    }

    public function order_date($order) {
        $order_date = $order->get_date_created();
        
        return (object) [
            'attribute' => $order_date->date('c'),
            'label' => $order_date->date('F j, Y'),
        ];
    }

    public function product_count($order) {
        return $order->get_item_count() - $order->get_item_count_refunded();
    }

    public function order() {
        if (!isset($this->data['order'])) {
            return false;
        }

        return $this->data['order'];
    }
}
