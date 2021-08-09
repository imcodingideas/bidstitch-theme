<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Facades\Navi;

class MiniCart extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.cart.mini-cart'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'cart_empty' => WC()->cart->is_empty(),
            'products' => $this->products(),
        ];
    }
    function products()
    {
        $products = [];
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters(
                'woocommerce_cart_item_product',
                $cart_item['data'],
                $cart_item,
                $cart_item_key
            );
            $product_id = apply_filters(
                'woocommerce_cart_item_product_id',
                $cart_item['product_id'],
                $cart_item,
                $cart_item_key
            );

            if (
                $_product &&
                $_product->exists() &&
                $cart_item['quantity'] > 0 &&
                apply_filters(
                    'woocommerce_widget_cart_item_visible',
                    true,
                    $cart_item,
                    $cart_item_key
                )
            ) {
                $product_name = apply_filters(
                    'woocommerce_cart_item_name',
                    $_product->get_name(),
                    $cart_item,
                    $cart_item_key
                );

                $thumbnail = apply_filters(
                    'woocommerce_cart_item_thumbnail',
                    $_product->get_image(),
                    $cart_item,
                    $cart_item_key
                );
                $product_price = apply_filters(
                    'woocommerce_cart_item_price',
                    WC()->cart->get_product_price($_product),
                    $cart_item,
                    $cart_item_key
                );
                $product_permalink = apply_filters(
                    'woocommerce_cart_item_permalink',
                    $_product->is_visible()
                        ? $_product->get_permalink($cart_item)
                        : '',
                    $cart_item,
                    $cart_item_key
                );
                $woocommerce_mini_cart_item_class = apply_filters(
                    'woocommerce_mini_cart_item_class',
                    'mini_cart_item',
                    $cart_item,
                    $cart_item_key
                );
                $products[] = [
                    'product_name' => $product_name,
                    'thumbnail' => $thumbnail,
                    'product_price ' => $product_price,
                    'product_permalink' => $product_permalink,
                    'woocommerce_mini_cart_item_class' => $woocommerce_mini_cart_item_class,
                    'sanitized_product_name' => wp_kses_post($product_name),
                    'formatted_cart_item_data_cart_item' => wc_get_formatted_cart_item_data(
                        $cart_item
                    ),
                    'filtered_quantity' => apply_filters(
                        'woocommerce_widget_cart_item_quantity',
                        '<span class="quantity">' .
                            sprintf(
                                '%s &times; %s',
                                $cart_item['quantity'],
                                $product_price
                            ) .
                            '</span>',
                        $cart_item,
                        $cart_item_key
                    ),
                    'remove_link' => apply_filters(
                        'woocommerce_cart_item_remove_link',
                        sprintf(
                            '<a href="%s" class="woocommerce-mini-cart__remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            esc_attr__('Remove this item', 'woocommerce'),
                            esc_attr($product_id),
                            esc_attr($cart_item_key),
                            esc_attr($_product->get_sku())
                        ),
                        $cart_item_key
                    ),
                ];
            }
        }

        return $products;
    }
}
