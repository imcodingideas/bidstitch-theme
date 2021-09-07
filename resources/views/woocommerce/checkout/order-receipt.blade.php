{{-- Checkout Order Receipt Template

This template can be overridden by copying it to yourtheme/woocommerce/checkout/order-receipt.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.2.0 --}}

<ul class="order_details">
  <li class="order">
    {{ _e('Order number:', 'sage') }}
    <strong>{{ esc_html($order->get_order_number()) }}</strong>
  </li>

  <li class="date">
    {{ _e('Date:', 'sage') }}
    <strong>{{ esc_html(wc_format_datetime($order->get_date_created())) }}</strong>
  </li>

  <li class="total">
    {{ _e('Total', 'sage') }}
    <strong>{{ wp_kses_post($order->get_formatted_order_total()) }}</strong>
  </li>

  @if ($order->get_payment_method_title())
    <li class="method">
      {{ _e('Payment method', 'sage') }}
      <strong>{{ wp_kses_post($order->get_payment_method_title()) }}</strong>
    </li>
  @endif
</ul>

@php do_action('woocommerce_receipt_' . $order->get_payment_method(), $order->get_id()) @endphp

<div class="clear"></div>
