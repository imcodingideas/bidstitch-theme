<?php
namespace App;

use Exception;
use function Roots\asset;
use App\ProductSubscription;
use App\StripeWebhookHandler;
use Stripe\Event;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session;
use WeDevs\DokanPro\Modules\Stripe\Helper as StripeHelper;
use WeDevs\DokanPro\Modules\Subscription\Helper as SubscriptionHelper;
use WC_Coupon;

class DokanStripeSubscription {
    function __construct() {
        // check dokan pro is active
        if (!function_exists('dokan_pro')) return;

        // check if product subscription module is active
        if (!dokan_pro()->module->is_active('product_subscription')) return;

        // check if stripe module is active
        if (!dokan_pro()->module->is_active('stripe')) return;

        $this->handle_stripe_subscription();
        $this->handle_stripe_cc_update();
        $this->handle_stripe_coupons();
    }

    function handle_stripe_subscription() {
        // get stripe product subscrption instance
        $stripe_product_subscription_instance = dokan_pro()->module->stripe->product_subscription;

        // remove existing process subscription process action
        remove_action('dokan_process_subscription_order', [$stripe_product_subscription_instance, 'process_subscription'], 10, 3);

        // create new stripe product subscription instance
        $product_subscription = new ProductSubscription();

        // replace existing process subscription process action
        add_action('dokan_process_subscription_order', [$product_subscription, 'process_subscription'], 10, 3);
    }

    public function handle_stripe_cc_update() {
        // Add redirect page
        add_action('init', function() {
            add_rewrite_endpoint('update-stripe-payment-details', EP_ROOT);
        });

        add_filter('request', function($query_vars) {
            if (isset($query_vars['update-stripe-payment-details'])) {
                $query_vars['update-stripe-payment-details'] = true;
            }

            return $query_vars;
        });

        add_action('template_include', function($template) {
            if (get_query_var('update-stripe-payment-details')) {
                $this->stripe_checkout_redirect();
            }

            return $template;
        });

        // Add webhook handler - currently we only handle one
        add_action('rest_api_init', function() {
            register_rest_route('bidstitch/v1', '/stripe', [
                'methods' => 'POST',
                'callback' => [$this, 'stripe_set_payment_method'],
                'permission_callback' => function() {
                    return true;
                }
            ]);
        });
    }

    protected function stripe_checkout_redirect() {
        // Get user's Stripe info
        $user_id = get_current_user_id();
        $customer_id_meta = get_user_meta($user_id, 'dokan_stripe_customer_id');
        $subscription_id_meta = get_user_meta($user_id, '_stripe_subscription_id');

        if (empty($customer_id_meta) || empty($subscription_id_meta)) {
            return;
        }

        $customer_id = $customer_id_meta[0];
        $subscription_id = $subscription_id_meta[0];

        // Set up Stripe session
        Stripe::setApiKey(StripeHelper::get_secret_key());

        $cancel_url = dokan_get_navigation_url('subscription');
        $success_url = add_query_arg('status', 'success', $cancel_url);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'setup',
            'customer' => $customer_id,
            'setup_intent_data' => [
              'metadata' => [
                'customer_id' => $customer_id,
                'subscription_id' => $subscription_id,
              ],
            ],
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
        ]);

        wp_redirect($session->url, 301);
        exit();
    }

    public function stripe_set_payment_method($data) {
        // Handle completed checkout & get Stripe setup intent
        $event = $data->get_json_params();

        if ($event['type'] !== 'checkout.session.completed') {
            return;
        }

        // Update default payment method for this customer ID.
        // NOTE: using Subscription::update() fires customer.subscription.updated which is
        // intercepted by Dokan and treated as if a new subscription has been purchased.
        $stripe = new StripeClient(StripeHelper::get_secret_key());
        $setup_intent_id = $event['data']['object']['setup_intent'];
        $setup_intent = $stripe->setupIntents->retrieve($setup_intent_id, []);
        $customer_id = $event['data']['object']['customer'];
        $payment_method = $setup_intent->payment_method;

        $result = $stripe->customers->update($customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $payment_method,
            ],
        ]);

        if (!$result) {
            error_log("Failed to update payment method for Stripe customer $customer_id");
        }
    }

    function handle_stripe_coupons() {
        // enqueue scripts
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_script(
                'sage/admin-coupon-validation.js',
                asset('scripts/admin-coupon-validation.js')->uri(),
                ['jquery'],
                null,
                true
            );
        });

        // add a custom field to Admin coupon settings pages
        add_action('woocommerce_coupon_options', function($coupon_get_id, $coupon) {
            // set stripe subscription trial days
            woocommerce_wp_text_input([
                'id' => 'dokan_stripe_trial_days',
                'label' => __('Stripe subscription number of trial days', 'sage'),
                'type' => 'number',
                'value' => $coupon ? $coupon->get_meta('dokan_stripe_trial_days') : '0',
                'placeholder' => '',
                'description' => __('Number of days for stripe subscription trial', 'sage'),
                'desc_tip' => true,
            ]);

            // enable stripe referral
            woocommerce_wp_checkbox([
                'id' => 'dokan_stripe_referral_enable',
                'label' => __('Stripe subscription referral enabled', 'sage'),
                'placeholder' => '',
                'value' => $coupon ? $coupon->get_meta('dokan_stripe_referral_enable') : 'no',
                'description' => __('Stripe referral code tracking', 'sage'),
                'desc_tip' => true,
            ]);

            // enable coupon auto apply
            woocommerce_wp_checkbox([
                'id' => 'dokan_stripe_coupon_auto_apply_enable',
                'label' => __('Auto apply', 'sage'),
                'placeholder' => '',
                'value' => $coupon ? $coupon->get_meta('dokan_stripe_coupon_auto_apply_enable') : 'no',
                'description' => __('When checked, the coupon code will be automatically applied.', 'sage'),
                'desc_tip' => true,
            ]);
        }, 21, 2);

        // save the custom field value from Admin coupon settings pages
        add_action('woocommerce_coupon_options_save', function($post_id, $coupon) {
            $coupon = new WC_Coupon($post_id);

            // check if trial days are set
            if (!isset($_POST['dokan_stripe_trial_days'])) {
                $stripe_trial_days = '0';
            } else {
                $stripe_trial_days = wc_clean($_POST['dokan_stripe_trial_days']);
            }

            $coupon->update_meta_data('dokan_stripe_trial_days', $stripe_trial_days);

            // check if stripe referral is set
            if (!isset($_POST['dokan_stripe_referral_enable'])) {
                $stripe_referral_enabled = 'no';
            } else {
                $stripe_referral_enabled = wc_clean($_POST['dokan_stripe_referral_enable']);
            }

            $coupon->update_meta_data('dokan_stripe_referral_enable', $stripe_referral_enabled);

            // check if auto apply is set
            if (!isset($_POST['dokan_stripe_coupon_auto_apply_enable'])) {
                $stripe_coupon_auto_apply_enabled = 'no';
            } else {
                $stripe_coupon_auto_apply_enabled = wc_clean($_POST['dokan_stripe_coupon_auto_apply_enable']);
            }

            $coupon->update_meta_data('dokan_stripe_coupon_auto_apply_enable', $stripe_coupon_auto_apply_enabled);

            $coupon->save();
        }, 11, 2);

        // add stripe subscription trial coupon type
        add_filter('woocommerce_coupon_discount_types', function($types) {
            $types['dokan_subscripion_stripe_trial'] = __('Stripe Subscription Trial', 'sage');

            return $types;
        }, 21, 1);

        // automatically apply coupon if stripe subscription product is in cart
        add_action('woocommerce_before_checkout_form', function() {
            // get cart items and check if product is subscription
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                // get product id
                $product_id = $cart_item['product_id'];

                // get product
                $product = wc_get_product($product_id);

                // check if product exists
                if (empty($product)) break;

                // check if product type is subscription
                if ('product_pack' != $product->get_type()) break;

                $auto_apply_coupons = get_posts([
                    'post_type' => 'shop_coupon',
                    'posts_per_page' => 1,
                    'post_status' => 'publish',
                    'meta_query' => [
                        // check if auto apply is enabled
                        [
                            'key' => 'dokan_stripe_coupon_auto_apply_enable',
                            'value' => 'yes'
                        ],
                        // check if coupon is attached to product
                        [
                            'key' => 'product_ids',
                            'value' => (string) $product_id,
                            'compare' => 'IN',
                        ],
                    ]
                ]);

                // check if auto apply coupons exist
                if (empty($auto_apply_coupons)) break;

                // get target coupon post
                $target_coupon_post = $auto_apply_coupons[0];

                // get target coupon object
                $target_coupon = new WC_Coupon($target_coupon_post->ID);

                // get coupon code
                $target_coupon_code = $target_coupon->get_code();

                // check if coupon has already been applied
                if (WC()->cart->has_discount($target_coupon_code)) break;

                // check if coupon is valid
                if (!$target_coupon->is_valid()) break;

                // if coupon has not been applied, apply it
                WC()->cart->apply_coupon($target_coupon_code);
            }
        }, 21);

    }
}