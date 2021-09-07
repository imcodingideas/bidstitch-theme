<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutPayment extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.payment'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'needs_payment' => WC()->cart->needs_payment(),
        ];
    }
}
