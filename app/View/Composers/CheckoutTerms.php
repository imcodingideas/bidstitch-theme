<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutTerms extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.terms'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'has_terms' => $this->has_terms(),
            'shipping_input_checked' => $this->shipping_input_checked(),
        ];
    }

    public function has_terms() {
        return apply_filters('woocommerce_checkout_show_terms', true) && function_exists('wc_terms_and_conditions_checkbox_enabled');
    }

    public function shipping_input_checked() {
        return apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms']));
    }
}
