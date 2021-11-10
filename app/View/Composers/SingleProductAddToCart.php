<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SingleProductAddToCart extends Composer {
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.single-product.add-to-cart.simple'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with() {
        global $product;

        return [
            'quantity_input_params' => $this->get_quantity_input_params($product),
            'product' => $product,
        ];
    }

    function get_quantity_input_params($product) {
        return [
            'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
            'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
            'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
        ];
    }
}
