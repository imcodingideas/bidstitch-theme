{{-- Review order table

This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 5.2.0 --}}

@php do_action('woocommerce_checkout_before_order_review') @endphp

<div class="woocommerce-checkout-review-order-table">
  {{-- Order Items --}}
  @if ($products)
    @php do_action('woocommerce_review_order_before_cart_contents') @endphp

    @foreach ($products as $product)
      <div class="grid grid-cols-12 gap-x-2 border-b p-4 lg:p-6">
        <div class="flex space-x-4 content-start items-start col-span-7">
          {!! $product->thumbnail !!}

          <div class="grid gap-y-1">
            <h4>{{ $product->name }}</h4>

            @if ($product->data)
              @foreach ($product->data as $item)
                <p class="text-sm text-gray-500">
                  <span class="font-bold">{{ $item->key }}:</span>
                  <span>{{ $item->value }}</span>
                </p>
              @endforeach
            @endif
          </div>
        </div>

        <div class="col-span-5 text-right">
          {!! $product->subtotal !!}
        </div>
      </div>
    @endforeach

    @php do_action('woocommerce_review_order_before_cart_contents') @endphp
  @endif

  {{-- Coupon Form --}}
  <div class="grid space-y-4 border-b p-4 lg:p-6">
    @include('woocommerce.checkout.form-coupon')
  </div>

  <div class="grid space-y-4 border-b p-4 lg:p-6">
    {{-- Subtotal --}}
    @php do_action('woocommerce_review_order_before_order_subtotal') @endphp

    <div class="flex space-x-4 text-sm justify-between fee">
      <dt class="text-gray-600">{{ _e('Subtotal', 'sage') }}</dt>
      <dd class="flex flex-col items-end">{!! wc_cart_totals_subtotal_html() !!}</dd>
    </div>

    @php do_action('woocommerce_review_order_after_order_subtotal') @endphp

    {{-- Applied Coupons --}}
    @foreach ($coupons as $code => $coupon)
      <div class="flex space-x-4 text-sm justify-between">
        <div class="flex space-x-2 items-center">
          <dt class="text-gray-600">{{ _e('Discount', 'sage') }}</dt>
          <span
            class="rounded-full bg-gray-200 text-xs text-gray-600 py-0.5 px-2 tracking-wide">{{ $coupon->code }}</span>
        </div>

        <dd class="flex space-x-1">{!! wc_cart_totals_coupon_html($coupon) !!}</dd>
      </div>
    @endforeach

    {{-- Fees --}}
    @foreach ($fees as $fee)
      <div class="flex space-x-4 text-sm justify-between fee">
        <dt class="text-gray-600">{{ $fee->name }}</dt>
        <dd class="flex flex-col items-end">{!! wc_cart_totals_fee_html($fee) !!}</dd>
      </div>
    @endforeach

    {{-- Taxes --}}
    @if ($has_tax_totals)
      @if ($has_itemized_tax_totals)
        @foreach ($taxes as $code => $tax)
          <div class="flex space-x-4 text-sm justify-between tax-rate tax-rate-{{ esc_attr(sanitize_title($code)) }}">
            <dt class="text-gray-600">{{ $tax->label }}</dt>
            <dd class="flex flex-col items-end">{!! wp_kses_post($fee->formatted_amount) !!}</dd>
          </div>
        @endforeach
      @else
        <div class="flex space-x-4 text-sm justify-between tax-total">
          <dt class="text-gray-600">{{ esc_html($region_taxes) }}</dt>
          <dd class="flex flex-col items-end">{!! wc_cart_totals_taxes_total_html() !!}</dd>
        </div>
      @endif
    @endif

    {{-- Shipping --}}
    @if ($needs_shipping)
      @if ($shipping)
        <div class="flex space-x-4 text-sm justify-between tax-total">
          <dt class="text-gray-600">{{ _e('Shipping', 'sage') }}</dt>
          <dd class="flex flex-col items-end">{!! $shipping !!}</dd>
        </div>
      @endif
    @endif

    {{-- Total --}}
    @php do_action('woocommerce_review_order_before_order_total') @endphp

    <div class="flex space-x-4 justify-between order-total text-sm">
      <dt>{{ _e('Total', 'sage') }}</dt>
      <dd class="flex flex-col items-end">{!! wc_cart_totals_order_total_html() !!}</dd>
    </div>

    @php do_action('woocommerce_review_order_after_order_total') @endphp
  </div>

  <div class="grid space-y-3 p-4 lg:p-6">
    {{-- Terms --}}
    @include('woocommerce.checkout.terms')

    {{-- Order Submit --}}
    <div class="grid">
      <noscript>
        <p>
          {{ _e('Since your browser does not support JavaScript, or it is disabled, please ensure you click the "Update Totals" button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'sage') }}
        </p>
        <button type="submit" class="btn btn--black btn--md justify-center" name="woocommerce_checkout_update_totals"
          value="{{ esc_attr_e('Update totals', 'sage') }}">{{ _e('Update totals', 'sage') }}</button>
      </noscript>

      @php do_action('woocommerce_review_order_before_submit') @endphp

      <button type="submit" class="btn btn--black btn--md justify-center" name="woocommerce_checkout_place_order"
        id="place_order" value="{{ esc_attr($order_button_text) }}"
        data-value="{{ esc_attr($order_button_text) }}">{{ esc_attr($order_button_text) }}</button>

      @php do_action('woocommerce_review_order_after_submit') @endphp

      @php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce') @endphp
    </div>
  </div>
</div>

@php do_action('woocommerce_checkout_after_order_review') @endphp
