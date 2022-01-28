<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutForm extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.form-checkout'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'user_can_register_account' => $this->user_can_register_account(),
            'user_can_checkout' => $this->user_can_checkout(),
            'has_checkout_fields' => $this->has_checkout_fields(),
        ];
    }

    protected function user_can_register_account()
    {
        $function_helper = new \WC_Gateway_PayPal_Express_Function_AngellEYE();

        return $function_helper->ec_is_express_checkout() && !is_user_logged_in();
    }

    public function has_checkout_fields() {
        return !empty(WC()->checkout()->get_checkout_fields());
    }

    public function user_can_checkout() {
        $checkout = WC()->checkout();

        if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
            return false;
        }

        return true;
    }
}
