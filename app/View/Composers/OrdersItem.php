<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class OrdersItem extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.myaccount.orders-item'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $order = $this->order();

        return [
            'order' => $order,
        ];
    }

    public function order() {
        if (!isset($this->data['customer_order'])) {
            return false;
        }

        $order = wc_get_order($this->data['customer_order']);

        return $order;
    }
}
