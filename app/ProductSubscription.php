<?php
namespace App;

use WeDevs\DokanPro\Modules\Stripe\Subscriptions\ProductSubscription as DokanProductSubscription;
use WeDevs\DokanPro\Modules\Stripe\Helper as StripeHelper;
use DokanPro\Modules\Subscription\Helper as SubscriptionHelper;
use Stripe\StripeClient;
use Stripe\Product;
use Stripe\Subscription;
use WP_Error;
use WC_Coupon;
use WC_Order;
use Exception;

class ProductSubscription extends DokanProductSubscription {
    public function __construct() {
        // setup parent constructor
        StripeHelper::bootstrap_stripe();
        $this->order = null;

        // create stripe client
        $this->stripe = $this->create_stripe_client();
    }

    // create stripe client
    public function create_stripe_client() {
        // validate stripe keys
        $valid_stripe_keys = StripeHelper::are_keys_set();
        if (!$valid_stripe_keys) return null;

        // set stripe client
        return new StripeClient(StripeHelper::get_secret_key());
    }

    // setup subscription data
    // structure taken from parent method
    public function setup_subscription() { 
        // get vendor id
        $vendor_id = get_current_user_id();

        // get dokan subscription product
        $dokan_subscription = dokan()->subscription->get($this->product_id);

        // check if is recurring subscription
        if (!$dokan_subscription->is_recurring()) return;

        // get product and stripe product
        $dokan_product = $dokan_subscription->get_product();
    
        // get stripe product
        $stripe_product = $this->get_or_create_stripe_product($dokan_product);

        // check if product has error
        if (is_wp_error($stripe_product)) return $stripe_product;

        // set stripe product id
        $this->stripe_product_id = $stripe_product->id;

        // create subscription args
        $subscription_args = [
            'items' => [
                [
                    'price_data' => [
                        'currency' => strtolower(get_woocommerce_currency()),
                        'product' => $this->stripe_product_id,
                        'recurring' => [
                            'interval' => $dokan_subscription->get_period_type(),
                            'interval_count' => $dokan_subscription->get_recurring_interval(),
                        ],
                        'unit_amount' => StripeHelper::get_stripe_amount($this->get_total()),
                    ],
                ],
            ],
            'metadata' => [],
        ];

        // get coupon
        $order_coupon = $this->get_coupon();

        // check if has coupon
        if (!empty($order_coupon)) {
            // add coupon to subscription args
            $subscription_args = $this->add_coupon_args($subscription_args, $order_coupon);
        }
        // if does not have coupon, check if product is trial
        elseif ($this->is_trial_product_subscription($dokan_subscription, $vendor_id)) {
            // set trial end
            $subscription_args['trial_end'] = $this->get_trial_days($dokan_subscription->get_trial_period_length());
        }

        // create subscription
        // from parent class
        $subscription = $this->maybe_create_subscription($subscription_args);

        // check if subscription has error
        if (is_wp_error($subscription)) return $subscription;

        // check if subscription is invalid
        if (empty($subscription->id))
            return new WP_Error('subscription_not_created', __('Unable to create subscription', 'dokan'));

        // update user subscription data
        $this->update_user_subscription_data($dokan_product, $vendor_id, $subscription, $dokan_subscription);

        return $subscription;
    }

    // get trial end date for subscription
    public function get_trial_days($trial_period_days) {
        try {
            $date_time = dokan_current_datetime()->modify( "+ {$trial_period_days} days" );
            return $date_time->getTimestamp();
        } catch (Exception $exception) {
            return time();
        }
    }

    // add coupon to subscription args
    public function add_coupon_args($subscription_args, $order_coupon) {
        // check if is trial coupon
        $is_trial_coupon = $this->is_trial_coupon($order_coupon);

        // if is trial coupon set trial data
        if ($is_trial_coupon) {
            // get trial coupon days
            $trial_coupon_days = $this->get_coupon_trial_days($order_coupon);
            
            // check for trial coupon day existence
            if (!empty($trial_coupon_days)) {
                // set trial end
                $subscription_args['trial_end'] = $this->get_trial_days($trial_coupon_days);
            }
        }
        // if is regular coupon, set discount
        else {
            $stripe_coupon = $this->get_or_create_stripe_coupon($order_coupon);

            // check for stripe coupon existence
            if (!empty($stripe_coupon)) {
                // set stripe coupon
                $subscription_args['coupon'] = $stripe_coupon->id;
                
                // set proration behavior
                $subscription_args['proration_behavior'] = 'none';

                // set price to subtotal since coupon will be applied
                $subscription_args['items'][0]['price_data']['unit_amount'] = StripeHelper::get_stripe_amount($this->get_subtotal());
            }
        }

        // check if is referral coupon
        if ($this->is_referral_coupon($order_coupon)) {
            // set referral data on subscription meta
            $subscription_args['metadata']['referral_coupon_id'] = $order_coupon->get_id();
            $subscription_args['metadata']['referral_coupon_code'] = $order_coupon->get_code();
        }

        return $subscription_args;
    }

    // check if is trial product subscription
    public function is_trial_product_subscription($dokan_subscription, $vendor_id) {
        // check if subscriber has used trial
        if (SubscriptionHelper::has_used_trial_pack($vendor_id)) return false;

        // check if dokan subscription is trial
        if (!$dokan_subscription->is_trial()) return false;

        return true;
    }

    // update user subscription data
    public function update_user_subscription_data($product_pack, $vendor_id, $subscription, $dokan_subscription) {
        // check for product pack existence
        if (empty($product_pack)) return;

        // check if product type is product pack
        if ('product_pack' != $product_pack->get_type()) return;

        update_user_meta($vendor_id, 'can_post_product', '1');
        update_user_meta($vendor_id, '_stripe_subscription_id', $subscription->id);
        update_user_meta($vendor_id, 'product_package_id', $product_pack->get_id());
        update_user_meta($vendor_id, 'product_no_with_pack', get_post_meta($product_pack->get_id(), '_no_of_product', true));
        update_user_meta($vendor_id, 'product_pack_startdate', dokan_current_datetime()->format('Y-m-d H:i:s'));
        update_user_meta($vendor_id, '_customer_recurring_subscription', 'active');
        update_user_meta($vendor_id, 'dokan_has_active_cancelled_subscrption', false);
        update_user_meta($vendor_id, 'product_pack_enddate', $dokan_subscription->get_product_pack_end_date());

        // need to remove these meta data. Update it on webhook reponse
        $this->setup_commissions($product_pack, $vendor_id);
        do_action('dokan_vendor_purchased_subscription', $vendor_id);
    }

    // get the stripe coupon
    // if none exists, create one
    public function get_or_create_stripe_product($product) {
        try {
            // check for product pack existence
            if (empty($product)) 
                throw new Exception('Invalid product');

            // get existing stripe product id
            $stripe_product_id = get_post_meta($product->get_id(), '_dokan_stripe_product_id', true);
            
            // get existing stripe product
            $stripe_product = $this->get_stripe_product($stripe_product_id);
            
            // check if stripe product exists
            if (empty($stripe_product)) {
                $stripe_product = $this->create_stripe_product($product);
            }
            
            return $stripe_product;
        } catch (Exception $exception) {
            return new WP_Error('stripe_api_error', $exception->getMessage());
        }
    }

    // create stripe product from dokan product
    public function create_stripe_product($product) {
        // check for product pack existence
        if (empty($product)) 
            throw new Exception('Invalid product');

        // get product pack title
        $pack_title = $product->get_title();

        // get product pack id
        $pack_id = $product->get_id();

        // set stripe product name
        $product_name = "Vendor Subscription: $pack_title #$pack_id";

        // create product 
        $stripe_product = $this->stripe->products->create([
            'name' => $product_name,
            'type' => 'service',
        ]);

        // update WC product with new stripe product
        update_post_meta($pack_id, '_dokan_stripe_product_id', $stripe_product->id);

        return $stripe_product;
    }

    // get stripe product
    public function get_stripe_product($stripe_product_id) {
        try {
            // validate product pack id existence
            if (empty($stripe_product_id)) return null;

            // get stripe product
            return $this->stripe->products->retrieve($stripe_product_id);
        } catch (Exception $exception) {
            return null;
        }
    }

    // get total
    public function get_total() {
        // check if is order coupon
        if ($this->order instanceof WC_Order)
            return $this->order->get_total();

        // get cart coupon
        return WC()->cart->get_total();
    }

    // get subtotal
    public function get_subtotal() {
        // check if is order coupon
        if ($this->order instanceof WC_Order)
            return $this->order->get_subtotal();

        // get cart coupon
        return WC()->cart->get_subtotal();
    }

    // get coupon
    public function get_coupon() {
        // check if is order coupon
        if ($this->order instanceof WC_Order)
            return $this->get_order_coupon($this->order);

        // get cart coupon
        return $this->get_cart_coupon(WC()->cart);
    }

    // check if is referral coupon
    public function is_referral_coupon($coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // get coupon referral enabled status
        $coupon_referral_enabled = $coupon->get_meta('dokan_stripe_referral_enable');

        // valid coupon referral existence
        if (empty($coupon_referral_enabled)) return false;

        // check if coupon referral is enabled
        if ($coupon_referral_enabled != 'yes') return false;

        return true;
    }
    
    // check if is trial coupon
    public function is_trial_coupon($coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // get coupon type
        $coupon_type = $coupon->get_discount_type();

        // validate coupon type existence
        if (empty($coupon_type)) return false;

        // check if coupon type is stripe trial
        if ($coupon_type != 'dokan_subscripion_stripe_trial') return false;

        return true;
    }

    // check if is trial coupon
    public function get_coupon_trial_days($coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // get coupon trial days
        $coupon_trial_days = $coupon->get_meta('dokan_stripe_trial_days');

        // check if trial days is integer
        if (!is_numeric($coupon_trial_days)) return false;

        // set coupon trial days
        $coupon_trial_days = intval($coupon_trial_days);

        // check if value is greater than 0
        if ($coupon_trial_days <= 0) return false;

        return $coupon_trial_days;
    }

    // get the stripe coupon
    // if none exists, create one
    public function get_or_create_stripe_coupon($coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // get stripe coupon
        $stripe_coupon = $this->get_stripe_coupon($coupon);

        // validate stripe coupon existence
        if (empty($stripe_coupon)) {
            // if stripe coupon does not exist, create it
            $stripe_coupon = $this->create_stripe_coupon($coupon);
        } 
        // update stripe coupon to ensure settings are synced
        else {
            // check if stripe coupon should be updated
            if (!$this->is_stripe_coupon_updated($coupon, $stripe_coupon)) {
                $stripe_coupon = $this->update_stripe_coupon($coupon);
            }
        }

        return $stripe_coupon;
    }

    // check if stripe coupon is up to date
    public function is_stripe_coupon_updated($coupon, $stripe_coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // validate stripe coupon existence
        if (empty($stripe_coupon)) return false;

        // get stripe coupon data from WC coupon
        $stripe_coupon_data = $this->get_stripe_coupon_data($coupon);

        // convert stripe coupon to associative array
        $stripe_coupon_array = (array) $stripe_coupon;

        // set coupon require update status
        $stripe_coupon_is_updated = true;

        // validate coupon fields against stripe coupon 
        foreach ($stripe_coupon_data as $key => $value) {
            // check if propery exists
            if (!isset($stripe_coupon_array[$key])) {
                $stripe_coupon_is_updated = false;
                break;
            }

            // check if values are equivalent
            if ($stripe_coupon_array[$key] != $value) {
                $stripe_coupon_is_updated = false;
                break;
            }
        }

        return $stripe_coupon_is_updated;
    }

    // get order coupon
    public function get_order_coupon($order) {
        // validate order existence
        if (empty($order)) return false;

        // get coupons
        $coupons = $order->get_coupon_codes();
    
        // validate coupon existence
        if (empty($coupons)) return false;
    
        // validate coupons type
        if (!is_array($coupons)) return false;
    
        // since only one coupon is allowed for subscription products
        // get the first coupon
    
        // check if coupon is set
        if (!isset($coupons[0])) return false;
    
        $target_coupon = new WC_Coupon($coupons[0]);
    
        return $target_coupon;
    }

    // get cart coupon
    public function get_cart_coupon($cart) {
        // validate order existence
        if (empty($cart)) return false;

        // get coupons
        $coupons = $cart->get_coupons();
    
        // validate coupon existence
        if (empty($coupons)) return false;
    
        // validate coupons type
        if (!is_array($coupons)) return false;

        $target_coupon = false;
    
        // since only one coupon is allowed for subscription products
        // get the first coupon
        foreach($coupons as $coupon) {
            if ($coupon) {
                $target_coupon = $coupon;
                break;
            }
        }
    
        return $target_coupon;
    }

    // get data to create/update stripe coupon
    // from woocommerce coupon
    public function get_stripe_coupon_data($coupon) {
        // get discount type
        $discount_type = $coupon->get_discount_type();

        // set default coupon payload
        $payload = [
            'duration' => 'once',
            'id' => $coupon->get_id(),
            'name' => $coupon->get_code(),
        ];

        // check if is percent discount
        if ($discount_type == 'percent') {
            $payload = array_merge($payload, [
                'percent_off' => intval($coupon->get_amount()),
            ]);
        }

        // check if fixed discount
        if ($discount_type == 'fixed_cart' || $discount_type == 'fixed_product') {
            $payload = array_merge($payload, [
                'amount_off' => StripeHelper::get_stripe_amount($coupon->get_amount()),
                'currency' => strtolower(get_woocommerce_currency()),
            ]);
        }

        return $payload;
    }

    // create stripe coupon
    public function create_stripe_coupon($coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // get stripe coupon data
        $stripe_coupon_data = $this->get_stripe_coupon_data($coupon);

        // get stripe coupon
        $stripe_coupon = $this->stripe->coupons->create($stripe_coupon_data);

        // validate stripe coupon existence
        if (empty($stripe_coupon)) return false;

        return $stripe_coupon;
    }

    // get stripe coupon
    public function get_stripe_coupon($coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // get coupon id
        $coupon_id = $coupon->get_id();
        
        // get stripe coupon
        $stripe_coupon = $this->stripe->coupons->retrieve($coupon_id);
        
        // validate stripe coupon existence
        if (empty($stripe_coupon)) return false;

        return $stripe_coupon;
    }

    // update stripe coupon
    public function update_stripe_coupon($coupon) {
        // validate coupon existence
        if (empty($coupon)) return false;

        // get coupon id
        $coupon_id = $coupon->get_id();
        
        // delete stripe coupon since pricing properties cannot be updated
        // note that deleted coupons remain active on invoices/subscriptions
        // see https://stripe.com/docs/api/coupons/delete
        $this->stripe->coupons->delete($coupon_id);

        // recreate stripe coupon
        $stripe_coupon = $this->create_stripe_coupon($coupon);
        
        // validate stripe coupon existence
        if (empty($stripe_coupon)) return false;

        return $stripe_coupon;  
    }
}