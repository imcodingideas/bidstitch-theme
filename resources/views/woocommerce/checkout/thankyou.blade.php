{{-- Thankyou page

This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.7.0 --}}

<div class="woocommerce-order">
  <div class="container py-8">
    @if ($order)
      <div class="space-y-4 lg:space-y-6">
        @php do_action('woocommerce_before_thankyou', $order->get_id()) @endphp

        @if ($order->has_status('failed'))
          <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
            {{ _e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'sage') }}
          </p>

          <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
            <a href="{{ esc_url($order->get_checkout_payment_url()) }}"
              class="btn btn--sm btn--black">{{ _e('Pay', 'sage') }}</a>

            @if (is_user_logged_in())
              <a href="{{ esc_url(wc_get_page_permalink('myaccount')) }}"
                class="btn btn--sm btn--black">{{ _e('My account', 'sage') }}</a>
            @endif
          </p>
        @else
          <div class="space-y-1">
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
              {{ _e('Thank you. Your order has been received.', 'sage') }}</p>

            @if ($is_trial_subscription_order)
              <h2 class="text-xl font-bold">{{ _e('Your card will not be charged during the trial period.', 'sage') }}
              </h2>
            @endif
          </div>

          <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
            <li class="woocommerce-order-overview__order order">
              {{ _e('Order number:', 'sage') }}
              <strong>{{ $order->get_order_number() }}</strong>
            </li>

            <li class="woocommerce-order-overview__date date">
              {{ _e('Date:', 'sage') }}
              <strong>{{ wc_format_datetime($order->get_date_created()) }}</strong>
            </li>

            <li class="woocommerce-order-overview__email email">
              {{ _e('Email:', 'sage') }}
              <strong>{{ $order->get_billing_email() }}</strong>
            </li>

            <li class="woocommerce-order-overview__total total">
              @if ($is_trial_subscription_order)
                {{ _e('Total After Trial End:', 'sage') }}
              @else
                {{ _e('Total:', 'sage') }}
              @endif

              <strong>{!! $order->get_formatted_order_total() !!}</strong>
            </li>

            @if ($order->get_payment_method_title())
              <li class="woocommerce-order-overview__payment-method method">
                {{ _e('Payment method:', 'sage') }}
                <strong>{{ wp_kses_post($order->get_payment_method_title()) }}</strong>
              </li>
            @endif
          </ul>
        @endif

        @php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()) @endphp

        <div class="space-y-1">
          @if ($is_trial_subscription_order)
            <h2 class="text-xl font-bold">{{ _e('Upcoming Payment Details (After Trial End)', 'sage') }}</h2>
          @endif

          @php do_action('woocommerce_thankyou', $order->get_id()) @endphp
        </div>
      </div>
    @else
      <p>{{ _e('Thank you. Your order has been received.', 'sage') }}</p>
    @endif
  </div>
</div>

<div class="clear"></div>
