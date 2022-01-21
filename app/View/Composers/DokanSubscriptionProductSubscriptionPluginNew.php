<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Roots\Acorn\View\Composer;
use Stripe\StripeClient;
use WeDevs\DokanPro\Modules\Stripe\Helper as StripeHelper;

class DokanSubscriptionProductSubscriptionPluginNew extends Composer
{
    protected $customer_id;
    protected $subscription_id;
    protected $has_subscription;

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.subscription.product_subscription_plugin_new'];

    /**
     * Compose the view before rendering.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $user_id = get_current_user_id();
        $customer_id_meta = get_user_meta($user_id, 'dokan_stripe_customer_id');
        $subscription_id_meta = get_user_meta($user_id, '_stripe_subscription_id');

        $this->has_subscription = !empty($customer_id_meta) && !empty($subscription_id_meta);

        if ($this->has_subscription) {
            $this->customer_id = $customer_id_meta[0];
            $this->subscription_id = $subscription_id_meta[0];
        }

        parent::compose($view);
    }

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $card_last_digits = $this->card_last_digits();
        $display_stripe_button = $this->display_stripe_button();
        $display_success_message = $this->display_success_message();

        return [
            'card_last_digits' => $card_last_digits,
            'display_stripe_button' => $display_stripe_button,
            'display_success_message' => $display_success_message,
        ];
    }

    protected function card_last_digits()
    {
        $stripe = new StripeClient(StripeHelper::get_secret_key());

        $payment_methods = $stripe->paymentMethods->all([
            'customer' => $this->customer_id,
            'type' => 'card',
        ]);

        return $payment_methods->data[0]->card->last4;
    }

    protected function display_stripe_button()
    {
        return $this->has_subscription;
    }

    protected function display_success_message()
    {
        return !empty($_GET['status']) && $_GET['status'] === 'success';
    }
}