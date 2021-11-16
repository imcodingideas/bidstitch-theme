<?php

namespace App;

use Exception;
use WC_Logger;
use WC_Geolocation;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\ActionSource;
use FacebookAds\Object\ServerSide\Content;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;

class FacebookEvents {
    // facebook credentials
    protected $access_token;
    protected $pixel_id;

    // facebook api ref
    protected $api;

    // facebook event list
    protected $events = [];

    // user data
    protected $user_agent;
    protected $user_ip;

    function __construct() {
        // setup
        $this->setup();

        // validate credentials
        if (empty($this->access_token)) return;
        if (empty($this->pixel_id)) return;

        // initiate
        $this->init();

        // validate api
        if (empty($this->api)) return;

        // get user request data
        $this->get_user_data();
        
        // add hooks
        $this->add_hooks();
    }

    function setup() {
        $this->access_token = defined('FB_ACCESS_TOKEN') ? FB_ACCESS_TOKEN : null;
        $this->pixel_id = defined('FB_PIXEL_ID') ? intval(FB_PIXEL_ID) : null;
    }

    function init() {
        try {
            // check if user is logged in
            if (!is_user_logged_in()) return;
            
            $this->api = Api::init(null, null, $this->access_token);
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function get_user_data() {
        // set user agent
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];

        // set user ip
        $this->user_ip = WC_Geolocation::get_ip_address();
    }

    function add_hooks() {
        // check if woocommerce is active
        if (class_exists('WooCommerce')) {
            $this->add_woocommerce_hooks();
        }

        // check if dokan is active 
        if (class_exists('WeDevs_Dokan')) {
            $this->add_dokan_hooks();
        }

        // check if yith wishlist is active
        if (class_exists('YITH_WCWL')) {
            $this->add_yith_wishlist_hooks();
        }
    }

    function add_woocommerce_hooks() {
        // add to cart
        add_action('woocommerce_add_to_cart', [$this, 'handle_add_to_cart'], 21, 6);

        // initiate checkout
        add_action('woocommerce_after_checkout_form', [$this, 'handle_initiate_checkout'], 21);

        // handle purchase
        add_action('woocommerce_payment_complete', [$this, 'handle_purchase'], 21);

        // handle product view
        add_action('woocommerce_after_single_product', [$this, 'handle_product_view'], 21);
    }

    function add_dokan_hooks() {
        // handle subscription
        add_action('dokan_vendor_purchased_subscription', [$this, 'handle_subscription'], 21, 1);
    }

    function add_yith_wishlist_hooks() {
        // add to wishlist
        add_action('yith_wcwl_added_to_wishlist', [$this, 'handle_add_to_wishlist'], 21, 1);
    }

    function create_event_user_data() {
        // check if user is logged in
        if (!is_user_logged_in()) return false;

        // get user
        $cur_user_id = get_current_user_id();
        $cur_user = get_userdata($cur_user_id);

        // check if user exists
        if (empty($cur_user)) return false;
        if (!$cur_user->exists()) return false;

        $user_data = [
            'email' => $cur_user->user_email,
            'first_name' => $cur_user->user_firstname,
            'last_name' => $cur_user->user_lastname,
            'external_id' => strval($cur_user_id),
            'city' => get_user_meta($cur_user_id, 'billing_city', true),
            'zip_code' => get_user_meta($cur_user_id, 'billing_postcode', true),
            'country_code' => get_user_meta($cur_user_id, 'billing_country', true),
            'address' => get_user_meta($cur_user_id, 'billing_state', true),
            'phone' => get_user_meta($cur_user_id, 'billing_phone', true),
        ];

        // unset undefined values
        foreach ($user_data as $key => $value) {
            if (empty($value)) unset($user_data[$key]);
        }

        // create user data
        $user_data = new UserData($user_data);

        // set browser data
        $user_data->setClientIpAddress($this->user_ip);
        $user_data->setClientUserAgent($this->user_agent);
        
        return $user_data;
    }

    function create_event_data($event_name) {
        $event_data = new Event();

        // set event name
        $event_data->setEventName($event_name);

        // set basic event data
        $event_data->setEventTime(time());
        $event_data->setEventSourceUrl(home_url($_SERVER['REQUEST_URI']));
        $event_data->setActionSource(ActionSource::WEBSITE);

        // get user data
        $user_data = $this->create_event_user_data();

        // set default user data
        if ($user_data) {
            $event_data->setUserData($user_data);
        }

        return $event_data;
    }

    function create_product_event_content($product_id, $quantity = 1) {
        $product = wc_get_product($product_id);

        // validate product existence
        if (empty($product)) return false;

        $product_data = [
            'product_id' => $product_id,
            'item_price' => $product->get_price(),
            'title' => $product->get_name(),
            'quantity' => $quantity
        ];

        // unset undefined values
        foreach ($product_data as $key => $value) {
            if (empty($value)) unset($product_data[$key]);
        }

        // create custom content data
        $product_content = new Content($product_data);

        return $product_content;
    }

    function handle_add_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
        try {
            // create new event
            $event_data = $this->create_event_data('AddToCart');

            // create custom content data
            $custom_content = $this->create_product_event_content($product_id, $quantity);

            // validate content existence
            if (empty($custom_content)) return;

            // create custom data
            $custom_data = new CustomData();
            $custom_data->setContents([$custom_content]);
            $custom_data->setCurrency(get_woocommerce_currency());

            // validate content existence
            if (empty($custom_data)) return;

            // set custom event data
            $event_data->setCustomData($custom_data);

            // add event
            $this->add_event($event_data);

            // send events
            $this->send_events();
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function handle_add_to_wishlist($product_id) {
        try {
            // create new event
            $event_data = $this->create_event_data('AddToWishlist');

            // create custom content data
            $custom_content = $this->create_product_event_content($product_id);

            // validate content existence
            if (empty($custom_content)) return;

            // create custom data
            $custom_data = new CustomData();
            $custom_data->setContents([$custom_content]);
            $custom_data->setCurrency(get_woocommerce_currency());

            // validate content existence
            if (empty($custom_data)) return;

            // set custom event data
            $event_data->setCustomData($custom_data);

            // add event
            $this->add_event($event_data);

            // send events
            $this->send_events();
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function handle_initiate_checkout() {
        try {
            // if is ajax request, do not trigger event
            if (is_ajax()) return;

            // check if cart is empty
            if (WC()->cart->is_empty()) return;

            // get order items
            $cart_items = WC()->cart->get_cart();

            // validate order items existence
            if (empty($cart_items)) return;

            // create new event
            $event_data = $this->create_event_data('InitiateCheckout');

            // create custom data
            $custom_data = new CustomData();
            $custom_data_items = [];

            // get order products
            foreach ($cart_items as $item => $values) {
                $data_item = $values['data'];

                // get the product ID
                $product_id = $data_item->get_id();

                // validate product id existence
                if (empty($product_id)) continue;

                // get item quantity
                $quantity = $values['quantity'];

                // create custom data
                $custom_content = $this->create_product_event_content($product_id, $quantity);

                // validate content existence
                if (empty($custom_content)) continue;

                $custom_data_items[] = $custom_content;
            }

            // validate content existence
            if (empty($custom_data_items)) return;

            $custom_data->setContents($custom_data_items);
            $custom_data->setCurrency(get_woocommerce_currency());

            // set custom event data
            $event_data->setCustomData($custom_data);

            // add event
            $this->add_event($event_data);

            // send events
            $this->send_events();
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function handle_purchase($order_id) {
        try {
            $order = wc_get_order($order_id);

            // validate order existence
            if (empty($order)) return;
    
            // get order items
            $order_items = $order->get_items();
    
            // validate order items existence
            if (empty($order_items)) return;
    
            // create new event
            $event_data = $this->create_event_data('Purchase');
    
            // create custom data
            $custom_data = new CustomData();
            $custom_data_items = [];
    
            // get order products
            foreach ($order_items as $item_id => $item) {
                // get the product ID
                $product_id = $item->get_product_id();
    
                // validate product id existence
                if (empty($product_id)) continue;
    
                // get item quantity
                $quantity = $item->get_quantity();  
    
                // create custom data
                $custom_content = $this->create_product_event_content($product_id, $quantity);
    
                // validate content existence
                if (empty($custom_content)) continue;
    
                $custom_data_items[] = $custom_content;
            }
    
            // validate content existence
            if (empty($custom_data_items)) return;
    
            $custom_data->setContents($custom_data_items);
            $custom_data->setCurrency(get_woocommerce_currency());
            $custom_data->setValue($order->get_total());
    
            // set custom event data
            $event_data->setCustomData($custom_data);

            // add event
            $this->add_event($event_data);
    
            // send events
            $this->send_events();
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function handle_subscription($vendor_id) {
        try {
            // get vendor subscription
            $vendor_subscription = dokan()->vendor->get($vendor_id)->subscription;

            // check if subscription exists
            if (empty($vendor_subscription)) return false;

            // get product id 
            $product_id = $vendor_subscription->get_id();

            // check if id exists
            if (empty($product_id)) return false;

            // create new event
            $event_data = $this->create_event_data('SubscriptionCreated');

            // create custom content data
            $custom_content = $this->create_product_event_content($product_id);

            // validate content existence
            if (empty($custom_content)) return;

            // create custom data
            $custom_data = new CustomData();
            $custom_data->setContents([$custom_content]);
            $custom_data->setCurrency(get_woocommerce_currency());

            // validate content existence
            if (empty($custom_data)) return;

            // set custom event data
            $event_data->setCustomData($custom_data);

            // add event
            $this->add_event($event_data);

            // send events
            $this->send_events();
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function handle_product_view() {
        try {
            global $post;

            // validate post existence
            if (!isset($post)) return;
            if (empty($post)) return;
    
            // validate post id existence
            if (!isset($post->ID)) return;
            if (empty($post->ID)) return;
    
            // create new event
            $event_data = $this->create_event_data('ViewContent');
    
            // create custom content data
            $custom_content = $this->create_product_event_content($post->ID);
    
            // validate content existence
            if (empty($custom_content)) return;
    
            // create custom data
            $custom_data = new CustomData();
            $custom_data->setContents([$custom_content]);
            $custom_data->setCurrency(get_woocommerce_currency());
    
            // validate content existence
            if (empty($custom_data)) return;
    
            // set custom event data
            $event_data->setCustomData($custom_data);
    
            // add event
            $this->add_event($event_data);
    
            // send events
            $this->send_events();
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function add_event($event) {
        $this->events[] = $event;
    }

    function send_events() {
        try {
            // check if events exist
            if (empty($this->events)) return;

            // create new event request
            $api_request = new EventRequest($this->pixel_id);

            // set events
            $api_request->setEvents($this->events);

            // send request
            $api_request->execute();

            // reset events
            $this->events = [];
        } catch (Exception $err) {
            $this->handle_error($err);
        }
    }

    function handle_error($err) {
        $log = new WC_Logger();

        $log_entry = print_r($err, true);
        $log_entry .= 'Exception Trace: ' . print_r($err->getTraceAsString(), true);

        $log->add('facebook-conversion-api', $log_entry);
    }
}