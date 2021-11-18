<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutThankYou extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.thankyou'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'is_trial_subscription_order' => $this->is_trial_subscription_order(),
        ];
    }

    public function is_subscription_order() {
        // check if order is empty
        if (!isset($this->data['order'])) return false;
        if (empty($this->data['order'])) return false;

        // get order
        $order = $this->data['order'];

        // get order items
        $order_items = $order->get_items();

        // validate order items existence
        if (empty($order_items)) return;

        $has_subscription_product = false;

        // get order products
        foreach ($order_items as $item_id => $item) {
            // get the product ID
            $product_id = $item->get_product_id();

            // validate product id existence
            if (empty($product_id)) continue;

            // get product
            $product = wc_get_product($product_id);

            // check if product is empty
            if (empty($product)) continue;

            // check if is subscription pack
            if ('product_pack' == $product->get_type()) {
                $has_subscription_product = true;
                break;
            }
        }

        return $has_subscription_product;
    }

    public function is_trial_subscription_order() {
        // check if order is empty
        if (!isset($this->data['order'])) return false;
        if (empty($this->data['order'])) return false;

        // get order
        $order = $this->data['order'];

        // check if order is subscription
        if (!$this->is_subscription_order()) return false;

        // get coupon codes
        $coupon_codes = $order->get_coupon_codes();

        // check if coupons exist
        if (empty($coupon_codes)) return false;

        $has_trial_coupon = false;

        foreach($coupon_codes as $coupon_code) {
            // get coupon
            $coupon = new \WC_Coupon($coupon_code);

            // check if coupon is subscription trial
            if ('dokan_subscripion_stripe_trial' == $coupon->get_discount_type()) {
                $has_trial_coupon = true;
                break;
            }
        }

        return $has_trial_coupon;
    }
}
