<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class CheckoutReviewOrder extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.checkout.review-order'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'products' => $this->get_products(),
            'coupons' => $this->get_coupons(),
            'fees' => $this->get_fees(),
            'has_tax_totals' => $this->has_tax_totals(),
            'has_itemized_tax_totals' => $this->has_itemized_tax_totals(),
            'itemized_taxes' => $this->get_itemized_taxes(),
            'region_taxes' => $this->get_region_taxes(),
            'needs_shipping' => $this->needs_shipping(),
            'shipping' => $this->get_shipping(),
            'order_button_text' => $this->order_button_text(),
        ];
    }

    // from plugin: woocommerce\includes\wc-template-functions.php
    // wc_get_formatted_cart_item_data
    function get_cart_item_data($cart_item) {
        $item_data = array();

        // Variation values are shown only if they are not found in the title as of 3.0.
        // This is because variation titles display the attributes.
        if ($cart_item['data']->is_type('variation') && is_array($cart_item['variation'])) {
            foreach ($cart_item['variation'] as $name => $value) {
                $taxonomy = wc_attribute_taxonomy_name(str_replace('attribute_pa_', '', urldecode($name)));
    
                if (taxonomy_exists( $taxonomy)) {
                    // If this is a term slug, get the term's nice name.
                    $term = get_term_by('slug', $value, $taxonomy);
                    if (!is_wp_error($term) && $term && $term->name) {
                        $value = $term->name;
                    }
                    $label = wc_attribute_label($taxonomy);
                } else {
                    // If this is a custom option slug, get the options name.
                    $value = apply_filters('woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item['data']);
                    $label = wc_attribute_label(str_replace('attribute_', '', $name ), $cart_item['data']);
                }
    
                // Check the nicename against the title.
                if ('' === $value || wc_is_attribute_in_product_name($value, $cart_item['data']->get_name())) {
                    continue;
                }
    
                $item_data[] = (object) [
                    'key' => $label,
                    'value' => $value,
                ];
            }
        }
    
        // Filter item data to allow 3rd parties to add more to the array.
        $item_data = apply_filters('woocommerce_get_item_data', $item_data, $cart_item);
    
        // Format item data ready to display.
        foreach ($item_data as $key => $data) {
            // Set hidden to true to not display meta on cart.
            if (!empty($data['hidden'])) {
                unset($item_data[$key]);
                continue;
            }

            $item_data[$key]['key'] = !empty($data['key']) ? $data['key'] : $data['name'];
            $item_data[$key]['display'] = !empty($data['display']) ? $data['display'] : $data['value'];

            $item_data[$key] = (object) $item_data[$key];
        }
    
        // Output flat or in list format.
        if (count($item_data) > 0) {
            return $item_data;
        }
    
        return '';
    }

    public function get_products() {
        $cart_items = WC()->cart->get_cart();

        $payload = [];

        foreach($cart_items as $cart_item_key => $cart_item) {
            $product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $is_visible = apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key);
            $in_stock = $cart_item['quantity'] > 0;

            if ($product && $product->exists() && $in_stock && $is_visible) {
                $payload[] = (object) [
                    'name' => apply_filters('woocommerce_cart_item_name', $product->get_name(), $cart_item, $cart_item_key),
                    'quantity' => $cart_item['quantity'],
                    'subtotal' => apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($product, $cart_item['quantity']), $cart_item, $cart_item_key),
                    'thumbnail' => $product->get_image('thumbnail', ['class' => 'object-center object-cover rounded w-16 h-16 bg-gray-50 shadow'], true),
                    'data' => $this->get_cart_item_data($cart_item),
                ];
            }
        }

        return $payload;
    }

    public function get_fees() {
        return WC()->cart->get_fees();
    }

    public function get_coupons() {
        return WC()->cart->get_coupons();
    }

    public function has_tax_totals() {
        return wc_tax_enabled() && ! WC()->cart->display_prices_including_tax();
    }

    public function has_itemized_tax_totals() {
        return 'itemized' === get_option('woocommerce_tax_total_display');
    }

    public function get_itemized_taxes() {
        return WC()->cart->get_tax_totals();
    }

    public function get_region_taxes() {
        return WC()->countries->tax_or_vat();
    }

    public function needs_shipping() {
        return WC()->cart->needs_shipping() && WC()->cart->show_shipping();
    }

    public function get_shipping() {
        $has_shipping = WC()->session->get('chosen_shipping_methods')[0];

        if (!$has_shipping) return;

        return WC()->cart->get_cart_shipping_total();
    }

    public function order_button_text() {
        return apply_filters('woocommerce_order_button_text', __('Place order', 'sage'));
    }
}

