<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanSubscriptionProductSubscriptionPluginNew extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.subscription.product_subscription_plugin_new'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'stripe_button' => $this->stripe_button(),
        ];
    }

    protected function stripe_button()
    {
        $user_id = get_current_user_id();
        $customer_id_meta = get_user_meta($user_id, 'dokan_stripe_customer_id');
        $subscription_id_meta = get_user_meta($user_id, '_stripe_subscription_id');
        return !empty($customer_id_meta) & !empty($subscription_id_meta);
    }
}