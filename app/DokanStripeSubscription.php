<?php
namespace App;

use Exception;
use function Roots\asset;
use App\ProductSubscription;
use App\StripeWebhookHandler;
use Stripe\Event;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Subscription;
use Stripe\Checkout\Session;
use WeDevs\DokanPro\Modules\Stripe\StripeConnect;
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
        // Fire before loading subscriptions page
        add_action('dokan_load_custom_template', [$this, 'handle_stripe_cc_update_process']);
    }

    public function handle_stripe_cc_update_process($query_vars) {
        // Subscriptions page only
        if (!isset($query_vars['subscription'])) {
            return $query_vars;
        }

        // Set up a Stripe checkout session
        $this->stripe_setup_checkout();

        if (!empty($_GET['session_id'])) {
            // Retrieve a Stripe checkout session & set payment method
            $this->stripe_set_payment_method();
        }
    }

    protected function stripe_setup_checkout() {
        // Set up a Stripe checkout session
        $cancel_url = dokan_get_navigation_url('subscription');
        $success_url = add_query_arg('session_id', '{CHECKOUT_SESSION_ID}', $cancel_url);

        // Get user & system Stripe info
        $user_id = get_current_user_id();
        $customer_id_meta = get_user_meta($user_id, 'dokan_stripe_customer_id');
        $subscription_id_meta = get_user_meta($user_id, '_stripe_subscription_id');

        if (empty($customer_id_meta) || empty($subscription_id_meta)) {
            return $query_vars;
        }

        $customer_id = $customer_id_meta[0];
        $subscription_id = $subscription_id_meta[0];

        // Set up Stripe session
        $stripe = new StripeConnect();
        Stripe::setApiKey($stripe->secret_key);

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
            // TODO: figure out success/failure messages/redirects
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
        ]);

        // Pull in Stripe JS
        $stripe_js = <<<STRIPE_JS
            const stripe = Stripe('{$stripe->publishable_key}');
            const checkoutButton = document.getElementById('bidstitch-update-cc-button');

            checkoutButton.addEventListener('click', function() {
                stripe.redirectToCheckout({
                    sessionId: '{$session->id}'
                }).then(function (result) {
                    console.log(result);
                    // If `redirectToCheckout` fails due to a browser or network
                    // error, display the localized error message to your customer
                    // using `result.error.message`.
                });
            });
        STRIPE_JS;

        wp_enqueue_script('stripe', 'https://js.stripe.com/v3/', [], [], true);
        wp_add_inline_script('stripe', $stripe_js);
    }

    protected function stripe_set_payment_method() {
        $stripe = new StripeConnect();
        $stripe_client = new StripeClient($stripe->secret_key);
        // Get setup intent from session
        $session = $stripe_client->checkout->sessions->retrieve($_GET['session_id'], []);
        $setup_intent_id = $session->setup_intent;
        $setup_intent = $stripe_client->setupIntents->retrieve($setup_intent_id, []);
        // Update as this subscription's default
        Subscription::update($setup_intent->metadata->subscription_id, [
            'default_payment_method' => $setup_intent->payment_method,
        ]);
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