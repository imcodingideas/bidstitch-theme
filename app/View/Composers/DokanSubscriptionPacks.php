<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use DokanPro\Modules\Subscription\Helper;

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

        foreach($posts as $post) {
            $pack = dokan()->subscription->get($post->ID);

            $price = $pack->get_price();
            $is_recurring  = $pack->is_recurring();
            $recurring_interval = $pack->get_recurring_interval();
            $recurring_period = $pack->get_period_type();

            $payload[] = (object) [
                'id' => $post->ID,
                'title' => $post->post_title,
                'content' => esc_html($post->post_content),
                'price' => $price > 0 ? wc_price($pack->get_price()) : '',
                'is_recurring' => $is_recurring,
                'recurring_label' => $is_recurring ? $this->get_recurring_label($recurring_interval, $recurring_period) : '',
            ];
        }

        return $payload;
    }
}
