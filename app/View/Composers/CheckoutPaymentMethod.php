<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutPaymentMethod extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.payment-method'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'available_gateways' => $this->get_available_gateways(),
            'payment_unavailable_notice' => $this->payment_unavailable_notice(),
        ];
    }

    public function get_available_gateways() {
        if (!WC()->cart->needs_payment()) return false;

        $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();

        WC()->payment_gateways()->set_current_gateway($available_gateways);

        return $available_gateways;
    }

    public function payment_unavailable_notice() {
        $billing_country = WC()->customer->get_billing_country();

        if ($billing_country) {
            return 'There are no payment methods available in your state. Please contact us if you require assistance or wish to make alternate arrangements.';
        }

        return 'Please fill in your details above to see available payment methods.';
    }
}
