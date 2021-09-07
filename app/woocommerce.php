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
    if(!$product)
        return;
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
                $new_items[$endpoint] = __('My Account', 'sage');
                break;
            case 'orders':
                $new_items[$endpoint] = __('Purchase History', 'sage');
                break;
            case 'following':
                $new_items[$endpoint] = __('Following', 'sage');
                break;
            case 'edit-account':
                $new_items[$endpoint] = __('Account Settings', 'sage');
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

// remove payment from order review
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);

//remove login before checkout
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);

//remove coupon before checkout
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

// remove terms on checkout
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30);

// remove form field attributes
add_action('woocommerce_form_field_args', 'woocommerce_remove_form_field_attributes', 10, 3);
function woocommerce_remove_form_field_attributes($args, $key, $value = null) {
    $args['class'] = array_filter($args['class'], function($class) {
        $excluded_class = [
            'form-row-first',
            'form-row-last',
            'form-row-wide'
        ];

        return !in_array($class, $excluded_class);
    });

    $args['label_class'] = [];
    $args['input_class'] = [];

    return $args;
}

// dequeue selectWoo
add_action('wp_enqueue_scripts', function() {
    wp_dequeue_script('selectWoo');
}, 11);