<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutFormAccount extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.form-account'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'checkout' => WC()->checkout(),
            'fields' => $this->get_fields(),
        ];
    }

    protected function get_fields() {
        return WC()->checkout()->get_checkout_fields('account');
    }
}
