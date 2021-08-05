<?php

// plugin generoi/sage-woocommerce
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

// single product: reorder price
remove_action(
    'woocommerce_single_product_summary',
    'woocommerce_template_single_price',
    10
);
add_action(
    'woocommerce_single_product_summary',
    'woocommerce_template_single_price',
    25
);

// single product: remove meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// single product: remove sharing
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

// single product: remove data tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// single product: remove upsell
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

// single product: custom "add to cart" text
add_filter(
    'woocommerce_product_single_add_to_cart_text',
    'custom_cart_button_text'
);
add_filter('woocommerce_product_add_to_cart_text', 'custom_cart_button_text');
function custom_cart_button_text()
{
    global $product;
    $id = get_the_ID();
    $price = $product->get_price();

    $currency_symbol = get_woocommerce_currency_symbol();

    if ($product->has_child()) {
        $price = $product->get_regular_price();
    }

    return __('Buy it now -  ' . $currency_symbol . $price, 'woocommerce');
}

