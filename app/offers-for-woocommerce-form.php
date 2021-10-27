<?php

use App\OffersHelpers;

if (class_exists('Angelleye_Offers_For_Woocommerce')) {
    // get offers for woocommerce class instance
    $ofw_instance = \Angelleye_Offers_For_Woocommerce::get_instance();
    
    // remove styling and scripts from offer forms
    remove_action('wp_enqueue_scripts', [$ofw_instance, 'enqueue_styles']);
    remove_action('wp_enqueue_scripts', [$ofw_instance, 'enqueue_scripts']);

    // remove offer submit ajax action
    remove_action('wp_ajax_new_offer_form_submit', [$ofw_instance, 'new_offer_form_submit']);
    remove_action('wp_ajax_nopriv_new_offer_form_submit', [$ofw_instance, 'new_offer_form_submit']);

    // remove offer buttons from single product page
    remove_action('woocommerce_before_single_product', [$ofw_instance, 'angelleye_ofwc_maybe_add_make_offer_to_single_product'], 1);
    remove_action('woocommerce_after_shop_loop_item', [$ofw_instance, 'angelleye_ofwc_after_show_loop_item'], 99, 2);
}