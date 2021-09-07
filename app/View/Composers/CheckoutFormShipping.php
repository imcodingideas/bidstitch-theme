<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutFormShipping extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.form-shipping'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'needs_shipping_address' => $this->needs_shipping_address(),
            'has_order_notes' => $this->has_order_notes(),
            'shipping_input_checked' => $this->shipping_input_checked(),
        ];
    }

    public function needs_shipping_address() {
        if (WC()->cart->needs_shipping_address() === true) {
            return true;
        }
        return false;
    }

    public function has_order_notes() {
        return apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'));
    }

    public function shipping_input_checked() {
        $shipping_enabled = get_option('woocommerce_ship_to_destination') === 'shipping';

        return apply_filters('woocommerce_ship_to_different_address_checked', $shipping_enabled ? 1 : 0);
    }
}
