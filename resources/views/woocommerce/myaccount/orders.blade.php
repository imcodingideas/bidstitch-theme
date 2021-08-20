@php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined('ABSPATH') || exit();

do_action('woocommerce_before_account_orders', $has_orders);
@endphp
<div class="grid gap-y-12">
  <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
    {{ _e('Order history', 'sage') }}
  </h1>
  @if ($has_orders)
    <div class="grid gap-y-12">
      @foreach ($customer_orders->orders as $customer_order)
        @include('woocommerce.myaccount.orders-item')
      @endforeach
    </div>

    @php do_action('woocommerce_before_account_orders_pagination') @endphp

    @if (1 < $customer_orders->max_num_pages)
      <div class="flex space-x-4">
        @if (1 !== $current_page)
          <a class="btn btn--white btn--sm" href="{{ esc_url(wc_get_endpoint_url('orders', $current_page - 1)) }}">
            {!! esc_html_e('Previous', 'woocommerce') !!}
          </a>
        @endif
        @if (intval($customer_orders->max_num_pages) !== $current_page)
          <a class="btn btn--black btn--sm" href="{{ esc_url(wc_get_endpoint_url('orders', $current_page + 1)) }}">
            {!! esc_html_e('Next', 'woocommerce') !!}
          </a>
        @endif
      </div>
    @endif
</div>
@else
<div class="flex flex-wrap space-y-4">
  <h2 class="w-full">{!! esc_html_e('No order has been made yet.', 'woocommerce') !!}</h2>
  <a class="btn btn--black btn--sm"
    href="{{ esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) }}">
    {!! esc_html_e('Browse products', 'woocommerce') !!}
  </a>
</div>
@endif

@php do_action( 'woocommerce_after_account_orders', $has_orders ) @endphp
