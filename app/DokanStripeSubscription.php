<?php
namespace App;

use Exception;
use function Roots\asset;
use App\ProductSubscription;
use App\StripeWebhookHandler;
use Stripe\Event;
use WeDevs\DokanPro\Modules\Stripe\Helper as StripeHelper;
use WeDevs\DokanPro\Modules\Subscription\Helper as SubscriptionHelper;

class DokanStripeSubscription {
    function __construct() {
        // check dokan pro is active
        if (!function_exists('dokan_pro')) return;

        // check if product subscription module is active
        if (!dokan_pro()->module->is_active('product_subscription')) return;

        // check if stripe module is active
        if (!dokan_pro()->module->is_active('stripe')) return;
        
        $this->handle_stripe_subscription();
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
        }, 21, 2);

        // save the custom field value from Admin coupon settings pages
        add_action('woocommerce_coupon_options_save', function($post_id, $coupon) {
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

            $coupon->save();
        }, 21, 2);

        // add stripe subscription trial coupon type
        add_filter('woocommerce_coupon_discount_types', function($types) {
            $types['dokan_subscripion_stripe_trial'] = __('Stripe Subscription Trial', 'sage');

            return $types;
        }, 21, 1);
    }
}