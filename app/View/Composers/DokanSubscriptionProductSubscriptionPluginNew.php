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
        $display_stripe_button = $this->display_stripe_button();
        $display_success_message = $this->display_success_message();

        return [
            'display_stripe_button' => !$display_success_message && $display_stripe_button,
            'display_success_message' => $display_success_message,
        ];
    }

    protected function display_stripe_button()
    {
        $user_id = get_current_user_id();
        $customer_id_meta = get_user_meta($user_id, 'dokan_stripe_customer_id');
        $subscription_id_meta = get_user_meta($user_id, '_stripe_subscription_id');
        return !empty($customer_id_meta) & !empty($subscription_id_meta);
    }

    protected function display_success_message()
    {
        return !empty($_GET['session_id']);
    }
}