<?php

if (class_exists('Angelleye_Offers_For_Woocommerce')) {
    $offers_class_instance = Angelleye_Offers_For_Woocommerce::get_instance();

    // check if user can checkout with the target offer
    add_filter('bidstitch_user_can_checkout_offer', function($status, $offer_id) {
        // check if user is logged in
        if (!is_user_logged_in()) return false;

        // check if offer id is valid
        if (empty($offer_id)) return false;
        if (!is_numeric($offer_id)) return false;

        // check if offer exists
        $offer = get_post($offer_id);
        if (empty($offer)) return false;

        // check if is offer type
        if (!isset($offer->post_type)) return false;
        if (empty($offer->post_type)) return false;
        if ($offer->post_type != 'woocommerce_offer') return false;
     
        // check if offer author exists
        if (!isset($offer->post_author)) return false;
        if (empty($offer->post_author)) return false;

        // check if offer author is current user
        $user_id = get_current_user_id();
        if ($user_id != $offer->post_author) return false;

        return $status;
    }, 11, 2);

    // change priority of api sniffer
    remove_action('parse_request', [$offers_class_instance, 'sniff_api_requests'], 0);
    add_action('parse_request', [$offers_class_instance, 'sniff_api_requests'], 21);

    // validate offer api request based on user permissions
    add_action('parse_request', function($query) {
        // check if is checkout offer request
        if (!isset($query->query_vars['__aewcoapi'])) return $query;
        if (!isset($query->query_vars['woocommerce-offer-id'])) return $query;
        if (!isset($query->query_vars['woocommerce-offer-uid'])) return $query;

        // check if is product page
        if (!isset($query->query_vars['post_type'])) return $query;
        if (empty($query->query_vars['post_type'])) return $query;
        if ($query->query_vars['post_type'] != 'product') return $query;
    
        // if is checkout offer request, check if user can checkout offer
        $offer_id = (int) $query->query_vars['woocommerce-offer-id'];
        $user_can_checkout_offer = apply_filters('bidstitch_user_can_checkout_offer', true, $offer_id);

        if (!$user_can_checkout_offer) {
            // if user cannot checkout offer, redirect
            $login_url = get_permalink(wc_get_page_id('myaccount'));
            
            // if user is not logged in, redirect to checkout offer after login
            if (!is_user_logged_in()) {
                global $wp;
                $current_url = home_url(add_query_arg($query->query_vars, $wp->request));

                $login_url = add_query_arg([
                    'login_redirect' => urlencode($current_url),
                ], $login_url);
            }

            // if user is logged in, redirect to my-account page
            wp_redirect($login_url, 302);
            exit;
        }

        return $query;
    }, 11);

    // redirect via query param
    add_filter('woocommerce_login_redirect', function($redirect, $user) {
        // check if has login redirect
        if (!isset($_GET['login_redirect'])) return $redirect;

        // decode the login redirect
        $decoded_url = urldecode($_GET['login_redirect']);
        
        // check if is valid internal redirect
        if (wp_validate_redirect($decoded_url)) return $decoded_url;

        return $redirect;
    }, 11, 2);
}