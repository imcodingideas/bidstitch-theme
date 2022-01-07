<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use DokanPro\Modules\Subscription\Helper;

use WC_Coupon;

class DokanSubscriptionPacks extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.seller-registration-form'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'subscription_packs' => $this->get_subscription_packs(),
        ];
    }

    function get_recurring_label($recurring_interval, $recurring_period) {
        $available_recurring_period = Helper::get_subscription_period_strings();

        if ($recurring_interval === 1) {
            if (isset($available_recurring_period[$recurring_period])) {
                $label = $available_recurring_period[$recurring_period];

                return "/ $label";
            }

            return '';
        }

        return "every $recurring_interval $recurring_period(s)";
    }

    // from plugin: dokan-pro/modules/subscription/includes/classes/Registration.php
    // generate_form_fields
    public function get_subscription_packs() {
        $subscription_packs = dokan()->subscription->all();

        $posts = $subscription_packs->get_posts();

        if (empty($posts)) return;

        $payload = [];
        $post_ids = [];

        foreach($posts as $post) {
            $post_ids[] = $post->ID;
        }

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
                    'value' => implode(',', $post_ids),
                    'compare' => 'IN',
                ],
            ]
        ]);

        foreach($posts as $post) {
            $pack = dokan()->subscription->get($post->ID);

            foreach ($auto_apply_coupons as $coupon_post) {
                $coupon = new WC_Coupon($coupon_post->ID);

                if (in_array($post->ID, $coupon->get_product_ids())) {
                    $price = 0;
                }
            }

            $is_recurring  = $pack->is_recurring();
            $recurring_interval = $pack->get_recurring_interval();
            $recurring_period = $pack->get_period_type();

            $payload[] = (object) [
                'id' => $post->ID,
                'title' => $post->post_title,
                'content' => esc_html($post->post_content),
                'price' => $price > 0 ? wc_price($price) : '',
                'is_recurring' => $is_recurring,
                'recurring_label' => $is_recurring ? $this->get_recurring_label($recurring_interval, $recurring_period) : '',
            ];
        }

        return $payload;
    }
}
