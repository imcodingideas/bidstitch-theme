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

// add shop name after title
add_action(
    'woocommerce_shop_loop_item_title',
    function () {
        if (!function_exists('dokan_get_store_info')) {
            return;
        }
        $vendor_id = get_post_field('post_author', get_the_id());
        $store_info = dokan_get_store_info($vendor_id); // Get the store data
        $url = dokan_get_store_url($vendor_id);
        $store_name = $store_info['store_name'];
        echo "<div class='store-wrapper'><a href='$url' class='link-to'><p class='name-store'>$store_name</p> </a></div>";
    },
    10
);

// remove "sale" icon
add_filter('woocommerce_sale_flash', function () {
    return false;
});

// update dashboard menu items
add_filter('woocommerce_account_menu_items', function ($items) {
    $new_items = $items;

    foreach($new_items as $endpoint => $data) {
        switch ($endpoint) {
            // remove unwanted items
            case 'customer-logout':
            case 'downloads':
            case 'support-tickets':
                unset($new_items[$endpoint]);
                break;

            // update existing items
            case 'dashboard':
                $new_items[$endpoint] = __('My Account', 'txtdomain');
                break;
            case 'orders':
                $new_items[$endpoint] = __('Purchase History', 'txtdomain');
                break;
            case 'following':
                $new_items[$endpoint] = __('Following', 'txtdomain');
                break;
            case 'edit-account':
                $new_items[$endpoint] = __('Account Settings', 'txtdomain');
                break;
                
            default:
                break;
        }
    }

    return $new_items;
}, 11, 1);

// remove my account nav
remove_action('woocommerce_account_navigation', 'woocommerce_account_navigation');

// update woocommerce registration privacy policy template
remove_action('woocommerce_register_form', 'wc_registration_privacy_policy_text', 20);
function bidstitch_registration_policy_text() {
    echo '<div class="text-sm">';
	wc_privacy_policy_text('registration');
	echo '</div>';
}
add_action('woocommerce_register_form', 'bidstitch_registration_policy_text', 20);

// remove add to cart button
add_action(
    'woocommerce_after_shop_loop_item',
    'woocommerce_remove_add_to_cart_buttons',
    1
);
function woocommerce_remove_add_to_cart_buttons()
{
    remove_action(
        'woocommerce_after_shop_loop_item',
        'woocommerce_template_loop_add_to_cart'
    );
}

