<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutShipping extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.shipping'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $shipping_methods = $this->get_shipping_options();
        
        return [
            'needs_shipping' => $this->needs_shipping(),
            'chosen_method' => $shipping_methods->chosen_method,
            'packages' => $shipping_methods->packages,
        ];
    }

    public function needs_shipping() {
        return WC()->cart->needs_shipping() && WC()->cart->show_shipping();
    }
    
    // from plugin: woocommerce\includes\wc-cart-functions.php
    // wc_cart_totals_shipping_html
    public function get_shipping_options() {
        $packages = WC()->shipping()->get_packages();
        $first = true;

        $payload = (object) [
            'chosen_method' => false,
            'packages' => []
        ];
    
        foreach ($packages as $i => $package) {
            $chosen_method = isset(WC()->session->chosen_shipping_methods[$i]) ? WC()->session->chosen_shipping_methods[$i] : '';
            $product_names = array();
    
            if (count($packages) > 1) {
                foreach ($package['contents'] as $item_id => $values) {
                    $product_names[$item_id] = $values['data']->get_name() . ' &times;' . $values['quantity'];
                }

                $product_names = apply_filters('woocommerce_shipping_package_details_array', $product_names, $package);
            }
    
            $payload->packages[] = (object) [
                'package' => $package,
                'available_methods' => $package['rates'],
                'show_package_details' => count($packages) > 1,
                'show_shipping_calculator' => is_cart() && apply_filters('woocommerce_shipping_show_shipping_calculator', $first, $i, $package),
                'package_details' => implode(', ', $product_names),
                'package_name' => apply_filters('woocommerce_shipping_package_name', (($i + 1) > 1) ? sprintf(_x('Shipping %d', 'shipping packages', 'sage'), ($i + 1)) : _x('Shipping', 'shipping packages', 'sage'), $i, $package),
                'index' => $i,
                'chosen_method' => $chosen_method,
                'formatted_destination' => WC()->countries->get_formatted_address($package['destination'], ', '),
                'has_calculated_shipping' => WC()->customer->has_calculated_shipping(),
            ];

            if ($chosen_method) {
                $payload->chosen_method = $package['rates'][$chosen_method]->cost;
            }
    
            $first = false;
        }

        return $payload;
    }
}
