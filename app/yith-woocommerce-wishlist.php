<?php
// remove font-awesome
add_action('wp_enqueue_scripts', function() {
    wp_deregister_style('yith-wcwl-font-awesome');
    wp_dequeue_style('yith-wcwl-font-awesome');
}, 11);

// remove wishlist shortcode
remove_shortcode('yith_wcwl_wishlist', ['YITH_WCWL_Shortcode', 'wishlist']);

// replace wishlist shortcode
add_shortcode('yith_wcwl_wishlist', function() {
    echo \Roots\view('woocommerce.myaccount.wishlist')->render();
});