<?php
namespace App;

class OffersHelpers {
    // offer post type
    public static $offer_post_type = 'woocommerce_offer';
    
    // open offer statuses
    public static $offer_pending_statuses = [
        'accepted-offer',
        'countered-offer',
        'publish',
        'buyercountered-offer'
    ];

    // purchasable offer statuses
    public static $offer_buyer_purchase_statuses = [
        'accepted-offer'
    ];

    // buyer counterable offer statuses
    public static $offer_buyer_counterable_statuses = [
        'countered-offer'
    ];

    // seller open statuses
    public static $offer_seller_pending_statuses = [
        'publish',
        'buyercountered-offer'
    ];

    // get sent offers page link
    public static function get_sent_offers_permalink() {
        return get_permalink(get_option('woocommerce_myaccount_page_id')) . 'offers';
    }

    // get received offers page link
    public static function get_received_offers_permalink() {
        return home_url('/dashboard/woocommerce_offer');
    }

    // check if is offer post type
    public static function is_offer_post_type($post_type = '') {
        if (empty($post_type)) return false;

        // check if post type is equal to offer post type
        if ($post_type != self::$offer_post_type)
            return false;

        return true;
    }

    // get offer by id
    public static function get_offer_by_id($offer_id = '') {
        if (empty($offer_id)) return false;
        
        // get offer
        $offer = get_post($offer_id);
        if (empty($offer)) return false;

        // validate post type
        $is_offer_post_type = self::is_offer_post_type($offer->post_type);
        if (!$is_offer_post_type) return false;

        return $offer;
    }

    // get offer notes by offer id
    public static function get_offer_notes_by_offer_id($offer_id = '') {
        if (empty($offer_id)) return false;

        // get wp database
        global $wpdb;
        if (!isset($wpdb)) return false;

        // get offer
        $offer = self::get_offer_by_id($offer_id);
        if (empty($offer)) return false;

        // prepare notes query
        $notes_query = $wpdb->prepare("SELECT * FROM $wpdb->commentmeta INNER JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID WHERE $wpdb->commentmeta.meta_value = '%d' AND $wpdb->comments.comment_type = 'offers-history' ORDER BY comment_date DESC LIMIT 1", $$offer->ID);
        
        // get notes query results
        $notes_query_results = $wpdb->get_results($notes_query);
        if (empty($notes_query_results)) return false;

        return $notes_query_results;
    }

    // get offer uid
    public static function get_offer_uid($offer_id = '') {
        if (empty($offer_id)) return false;

        $offer_uid = get_post_meta($offer_id, 'offer_uid', true);
        if (empty($offer_uid)) return false;

        return $offer_uid;
    }

    // get offer product id
    public static function get_offer_product_id($offer_id = '') {
        if (empty($offer_id)) return false;

        $offer_product_id = get_post_meta($offer_id, 'offer_product_id', true);
        if (empty($offer_product_id)) return false;

        return $offer_product_id;
    }

    // get offer price
    public static function get_offer_price($offer_id = '') {
        if (empty($offer_id)) return false;

        $offer_price = get_post_meta($offer_id, 'offer_price_per', true);
        if (empty($offer_price)) return false;

        return $offer_price;
    }

    // get offer details for counteroffer
    public static function get_offer_action_data($offer_id = '') {
        if (empty($offer_id)) return false;

        // get offer product id
        $offer_product_id = self::get_offer_product_id($offer_id);
        if (empty($offer_product_id)) return false;

        // get offer product price
        $offer_price = self::get_offer_price($offer_id);
        if (empty($offer_price)) return false;

        return (object) [
            'offer_id' => $offer_id,
            'offer_product_id' => $offer_product_id,
            'offer_price' => $offer_price,
        ];
    }
    
    // get offers enabled status by product id
    public static function get_offers_enabled_status_by_product_id($product_id = '') {
        if (empty($product_id)) return false;

        // check if offers are enabled
        $offers_enabled = get_post_meta($product_id, 'offers_for_woocommerce_enabled', true);
        if (empty($offers_enabled)) return false;
        if ($offers_enabled != 'yes') return false;

        return true;
    }

    // get product author by offer id
    public static function get_product_author_by_offer_id($offer_id = '') {
        if (empty($offer_id)) return false;

        // get offer
        $offer = self::get_offer_by_id($offer_id);
        if (empty($offer)) return false;

        // get offer product id
        $offer_product_id = self::get_offer_product_id($offer_id);
        if (empty($offer)) return false;

        // get offer product
        $product = get_post($offer_product_id);
        if (empty($product)) return false;

        // get product author
        if (!isset($product->post_author)) return false;
        $product_author = $product->post_author;

        return $product_author;
    }

    // check if current user is the author of the offer
    public static function current_user_is_offer_author($offer_id = '') {
        if (empty($offer_id)) return false;

        // get offer
        $offer = self::get_offer_by_id($offer_id);
        if (empty($offer)) return false;

        // get offer author
        if (!isset($offer->post_author)) return false;
        $offer_author = $offer->post_author;
        
        // check if current user is the offer author
        if ($offer_author != get_current_user_id()) return false;

        return true;
    }

    // check if current user can offer
    public static function current_user_can_offer() {
        // check if current user is logged in
        if (!is_user_logged_in()) return false;

        return true;
    }

    // check if current user is product author
    public static function current_user_is_product_author($product_id = '') {
        if (empty($product_id)) return false;

        // check if user can offer
        $current_user_can_offer = self::current_user_can_offer();
        if (!$current_user_can_offer) return false;

        // get product post
        $product = get_post($product_id);
        if (empty($product)) return false;

        // get product author
        if (!isset($product->post_author)) return false;
        $product_author = $product->post_author;
        
        // check if current user is the product author
        if ($product_author != get_current_user_id()) return false;

        return true;
    }
    
    // check if current user has open offers
    public static function current_user_has_open_offers($product_id = '') {
        if (empty($product_id)) return false;

        // get current offers 
        $offers = self::get_current_user_offers_by_product_id($product_id);
        if (empty($offers)) return false;

        // check if existing active offers exist
        foreach ($offers as $offer) {
            // get offer status
            $offer_status = $offer->post_status;

            // check if offer status has active offer status
            if (in_array($offer_status, self::$offer_pending_statuses))
                return true;
        }

        return false;
    }

    // check if current user can create offer
    public static function current_user_can_create_offer($product_id = '') {
        if (empty($product_id)) return false;

        // check if user can offer
        $current_user_can_offer = self::current_user_can_offer();
        if (!$current_user_can_offer) return false;

        // check if is product author
        $is_product_author = self::current_user_is_product_author($product_id);
        if ($is_product_author) return false;

        // get current offers 
        $current_user_has_open_offers = self::current_user_has_open_offers($product_id);
        if ($current_user_has_open_offers) return false;

        return true;
    }

    // check if current user can checkout offer
    public static function current_user_can_checkout_offer($offer_id = '') {
        if (empty($offer_id)) return false;

        // check if user can offer
        $current_user_can_offer = self::current_user_can_offer();
        if (!$current_user_can_offer) return false;
        
        // get offer
        $offer = self::get_offer_by_id($offer_id);
        if (empty($offer)) return false;
    
        // check if offer author is current user
        $current_user_is_offer_author = self::current_user_is_offer_author($offer_id);
        if ($current_user_is_offer_author) return false;
    
        // get offer status
        if (!isset($offer->post_status)) return false;
        $offer_status = $offer->post_status;

        // check if offer status is purchasable status
        if (!in_array($offer_status, self::$offer_buyer_purchase_statuses)) return false;
    
        return true;
    }

    // check if current user can counteroffer
    public static function current_user_can_counteroffer($offer_id = '') {
        if (empty($offer_id)) return false;

        // check if user can offer
        $current_user_can_offer = self::current_user_can_offer();
        if (!$current_user_can_offer) return false;
        
        // get offer
        $offer = self::get_offer_by_id($offer_id);
        if (empty($offer)) return false;

        // get offer status
        if (!isset($offer->post_status)) return false;
        $offer_status = $offer->post_status;
        
        // check if offer status is pending status
        if (!in_array($offer_status, self::$offer_seller_pending_statuses)) return false;

        // get offer product id
        $product_id = self::get_offer_product_id($offer_id);
        if (empty($product_id)) return false;

        // check if is product author
        $is_product_author = self::current_user_is_product_author($product_id);
        if (!$is_product_author) return false;

        return true;
    }

    // check if current user can buyer counteroffer
    public static function current_user_can_buyer_counteroffer($offer_id = '') {
        if (empty($offer_id)) return false;
        
        // check if user can offer
        $current_user_can_offer = self::current_user_can_offer();
        if (!$current_user_can_offer) return false;

        // get offer
        $offer = self::get_offer_by_id($offer_id);
        if (empty($offer)) return false;

        // get offer status
        if (!isset($offer->post_status)) return false;
        $offer_status = $offer->post_status;
        
        // check if offer status is counterable status
        if (!in_array($offer_status, self::$offer_buyer_counterable_statuses)) return false;

        // check if offer author is current user
        $current_user_is_offer_author = self::current_user_is_offer_author($offer_id);
        if (!$current_user_is_offer_author) return false;

        return true;
    }

    // check if current user can manage offer
    public static function current_user_can_manage_offer($offer_id = '') {
        if (empty($offer_id)) return false;
        
        // check if user can offer
        $current_user_can_offer = self::current_user_can_offer();
        if (!$current_user_can_offer) return false;

        // get offer
        $offer = self::get_offer_by_id($offer_id);
        if (empty($offer)) return false;

        // get offer status
        if (!isset($offer->post_status)) return false;
        $offer_status = $offer->post_status;
        
        // check if offer status is counterable status
        if (!in_array($offer_status, self::$offer_seller_pending_statuses)) return false;

        // check if offer author is current user
        $current_user_is_offer_author = self::current_user_is_offer_author($offer_id);
        if (!$current_user_is_offer_author) return false;

        return true;
    }

    // get current user offers by offer id
    public static function get_current_user_offers_by_product_id($product_id = '') {
        if (empty($product_id)) return false;

        $query_args = [
            'post_type' => self::$offer_post_type,
            'post_author' => get_current_user_id(),
            'post_status' => 'any',
            'numberposts' => -1,
            'suppress_filters' => true,
            'meta_query' => [
                [
                    'key' => 'offer_product_id',
                    'value' => $product_id,
                ]
            ]
        ];

        // get offers
        $offers = get_posts($query_args);
        if (empty($offers)) return false;

        return $offers;
    }

    // get offer checkout link by offer id
    public static function get_offer_checkout_link($offer_id = '') {
        if (empty($offer_id)) return false;

        // get offer uid
        $offer_uid = self::get_offer_uid($offer_id);    
        if (empty($offer_uid)) return false;

        // get offer product id
        $product_id = self::get_offer_product_id($offer_id);
        if (empty($product_id)) return false;

        // get product link
        $product_link = get_permalink($product_id);
        if (empty($product_link)) return false;

        // set query params
        $query_params = [
            '__aewcoapi=1' => 1,
            'woocommerce-offer-id' => $offer_id,
            'woocommerce-offer-uid' => $offer_uid,
        ];

        // create pay link with query args and product link
        $pay_link = add_query_arg($query_params, $product_link);

        return $pay_link;
    }
}