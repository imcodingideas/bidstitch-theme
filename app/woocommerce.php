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

// Keep product title length down
add_filter('the_title', function($title, $id) {
    if (!is_singular(['product']) && get_post_type($id) === 'product' && strlen($title) > 80) {
        $title = wordwrap($title, 80);
        $title = substr($title, 0, strpos($title, "\n")) . '...';
    }

    return $title;
}, 10, 2);

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
        echo "<div class='store-wrapper'><a href='$url' class='link-to'><p class='name-store truncate'>$store_name</p> </a></div>";
    },
    10
);

// remove "sale" icon
add_filter('woocommerce_sale_flash', function () {
    return false;
});

// update dashboard menu items
add_filter('woocommerce_account_menu_items', function ($items) {
    $items = [
        'edit-account' => __('Account Settings', 'sage'),
        'edit-address' => __('Addresses', 'sage'),
        'orders' => __('Purchases', 'sage'),
        'offers' => __('Sent Offers', 'sage'),
        'bids' => __('Sent Bids', 'sage'),
    ];

    return $items;
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

// stripe payment method only available for subscriptions
add_filter('woocommerce_available_payment_gateways', 'conditional_payment_gateways', 10, 1);
function conditional_payment_gateways($available_gateway) {
    // If is admin, do not filter
    if (is_admin()) return $available_gateway;

    // If stripe is not enabled, do not filter
    if (empty($available_gateway) || !isset($available_gateway['dokan-stripe-connect'])) return $available_gateway;

    $is_subscription = false;

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        // Check if product is a subscription
        $has_subscription_tax = has_term('product_pack', 'product_type', $cart_item['product_id']);

        if ($has_subscription_tax) {
            $is_subscription = true;
            break;
        }
    }

    // If is subscription purchase, only allow for stripe payment method
    if ($is_subscription) {
        return [
            'dokan-stripe-connect' => $available_gateway['dokan-stripe-connect'],
        ];
    }

    // If is not subscription, remove stripe as payment method
    unset($available_gateway['dokan-stripe-connect']);
    return $available_gateway;
}

// Register bids endpoint
add_action('init', function() {
	add_rewrite_endpoint('bids', EP_ROOT | EP_PAGES);
});

// Register woocommerce endpoint
add_action('woocommerce_account_bids_endpoint', function() {
    wc_get_template('myaccount/bids.php');
});

// decrease stock for buy it now listings if stock is not managed
add_action('woocommerce_checkout_order_processed', function($order_id) {
    $order = wc_get_order($order_id);
    if (empty($order)) return;

    $order_items = $order->get_items();
    if (empty($order_items)) return;

    foreach ($order_items as $line_item) {
        $product = $line_item->get_product();
        if (empty($product)) continue;

        // if is not simple product, move on
        $product_type = $product->get_type();
        if (empty($product_type)) continue;

        if ($product_type != 'simple') continue;

        // check if product creator is admin
        if (!isset($product->post) || !isset($product->post->post_author)) continue;
        $author_id = $product->post->post_author;
        if (empty($author_id)) continue;

        $is_admin = user_can($author_id, 'manage_options');
        if ($is_admin) continue;

        // check if product has managed stock
        $has_managed_stock = $product->get_manage_stock();
        if ($has_managed_stock) continue;

        // check if product is in stock
        $stock_status = $product->get_stock_status();
        if (empty($stock_status)) continue;

        if ($stock_status == 'instock') {
            $product->set_stock_status('outofstock');
            $product->save();
        }
    }
});

// add product comments after single produxt
add_action('woocommerce_after_single_product', function() {
    comments_template('/woocommerce/single-product-comments.php');
});

// prevent woocomemrce comment template from being loaded on product pages
// this should be done manually
add_action('init', function () {
    remove_filter('comments_template', [\WC_Template_Loader::class, 'comments_template_loader']);
});

// For guest PayPal checkouts it asks for a new account password twice,
// so we hide it / remove "required" on the initial form & only show on
// the actual order-submit page.
add_action('woocommerce_checkout_fields', function($fields) {
    if (isset($fields['account']['account_password'])) {
        $function_helper = new \WC_Gateway_PayPal_Express_Function_AngellEYE();
        $fields['account']['account_password']['required'] = $function_helper->ec_is_express_checkout();
    }

    return $fields;
});

// Intercept Dokan's error message to append name of current vendor in cart
// dokan-pro/includes/functions-wc.php line 1716
add_action('woocommerce_add_error', function($message) {
    if ($message === 'Sorry, you can\'t add more than one vendor\'s product in the cart.') {
        $cart_items = WC()->cart->get_cart();

        if (!empty($cart_items)) {
            $vendor = dokan_get_vendor_by_product(current($cart_items)['product_id']);

            if ($vendor) {
                $store_url = dokan_get_store_url($vendor->id);
                $store_name = dokan_get_store_info($vendor->id)['store_name'];
                $message = sprintf('%s Current vendor: <a class="underline" href="%s">%s</a>', $message, $store_url, $store_name);
            }
        }
    }

    return $message;
});

// Allow vendors to mark items as sold if sold on another platform.
// This piggybakcs on the "delete product" permission.
add_action('template_redirect', function() {
    if (dokan_is_seller_dashboard() && isset($_GET['action']) && $_GET['action'] === 'mark-sold') {
        // This code block is lifted and modified from dokan-lite/includes/Dashboard/Templates/Products.php
        if ( ! dokan_is_user_seller( dokan_get_current_user_id() ) ) {
            return;
        }

        if ( ! current_user_can( 'dokan_delete_product' ) ) {
            return;
        }

        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'mark-sold' ) ) {
            wp_redirect( add_query_arg( array( 'message' => 'error' ), dokan_get_navigation_url( 'products' ) ) );
            exit;
        }

        $product_id = isset( $_GET['product_id'] ) ? (int) wp_unslash( $_GET['product_id'] ) : 0;

        if ( ! $product_id ) {
            wp_redirect( add_query_arg( array( 'message' => 'error' ), dokan_get_navigation_url( 'products' ) ) );
            exit;
        }

        if ( ! dokan_is_product_author( $product_id ) ) {
            wp_redirect( add_query_arg( array( 'message' => 'error' ), dokan_get_navigation_url( 'products' ) ) );
            exit;
        }

        // Mark product as out of stock & draft, then nudge ElasticPress to reindex
        wc_update_product_stock($product_id, 0);

        wp_update_post([
            'ID' => $product_id,
            'post_status' => 'draft',
        ]);

        if (function_exists('ep_sync_post')) {
            ep_sync_post($product_id);
        }

        // Redirect back with success message
        $redirect = apply_filters( 'dokan_add_new_product_redirect', dokan_get_navigation_url( 'products' ), '' );

        wp_redirect( add_query_arg( array( 'message' => 'marked_as_sold' ), $redirect ) );
        exit;
    }
});

// Add nonce for AJAX "featured" URL
add_action('wp_enqueue_scripts', function() {
    $nonce = wp_create_nonce('wp_rest');
    wp_register_script('bidstitch-product-feature-script', false);
    wp_enqueue_script('bidstitch-product-feature-script');
    wp_add_inline_script('bidstitch-product-feature-script', "bidstitchFeaturedSettings = { nonce: '$nonce' }");
});


// Add REST endpoint for featuring products
add_action('rest_api_init', function() {
    register_rest_route('bidstitch/v1', '/feature-product', [
        'methods' => 'POST',
        'callback' => 'bidstitch_feature_product',
        'args' => [
            'product_id' => [
                'validate_callback' => function($product_id, $request, $key) {
                    // Check this is a valid upcoming auction product
                    if (!is_numeric($product_id)) {
                        return false;
                    }

                    $product = wc_get_product($product_id);

                    if (!$product) {
                        return false;
                    }

                    return true;
                },
            ],
        ],
        'permission_callback' => '__return_true',
    ]);
});

// Set product featured meta
function bidstitch_feature_product($request) {
    if (get_current_user_id() != 1) {
        return;
    }

    $params = $request->get_params();
    $product_id = $params['product_id'];
    $featured = $params['featured'];

    update_post_meta($product_id, '_bidstitch_featured_product', (int)$featured);
}
