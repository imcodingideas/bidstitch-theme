<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Roots\Acorn\View\Composer;
use Stripe\StripeClient;
use Stripe\Exception\InvalidRequestException;
use WeDevs\DokanPro\Modules\Stripe\Helper as StripeHelper;

class DokanSubscriptionProductSubscriptionPluginNew extends Composer
{
    protected $customer_id;
    protected $subscription_id;
    protected $has_subscription;
    protected $card_last_digits;

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
        $this->customer_id = get_user_meta($user_id, 'dokan_stripe_customer_id', true);
        $this->subscription_id = get_user_meta($user_id, '_stripe_subscription_id', true);
        $this->has_subscription = !empty($this->customer_id) && !empty($this->subscription_id);

        // Get current card number
        if ($this->has_subscription) {
            $stripe = new StripeClient(StripeHelper::get_secret_key());

            try {
                $payment_methods = $stripe->paymentMethods->all([
                    'customer' => $this->customer_id,
                    'type' => 'card',
                ]);

                $this->card_last_digits = $payment_methods->data[0]->card->last4;
            } catch (InvalidRequestException $e) {
                $this->card_last_digits = null;
                $this->has_subscription = false;
            }
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
        return $this->card_last_digits ?? null;
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