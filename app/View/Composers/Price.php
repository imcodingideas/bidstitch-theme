<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Price extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woocommerce.single-product.price'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        global $product;

        $currency = get_woocommerce_currency();
        $classes = [];
        if ($product->is_on_sale()) {
            $classes[] = 'price-on-sale';
        }
        if (!$product->is_in_stock()) {
            $classes[] = 'price-not-in-stock';
        }

        return [
            'classes' => implode(' ', $classes),
            'price_html' => $product->get_price_html(),
            'currency' => $currency,
        ];
    }
}
