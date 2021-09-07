<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutFormBilling extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.form-billing'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'fields' => $this->get_fields(),
        ];
    }

    public function get_fields() {
        $checkout = WC()->checkout();

        $fields = $checkout->get_checkout_fields('billing');

        return $fields;
    }
}
