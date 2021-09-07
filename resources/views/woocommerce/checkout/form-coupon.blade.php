{{-- Checkout coupon form

This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.4.4 --}}

@if (wc_coupons_enabled())
  <div class="space-y-2">
    <x-form-label for="checkout__coupon__input">{{ _e('Discount Code', 'sage') }}</x-form-label>

    <div class="flex space-x-2 w-full justify-between">
      <x-form-input id="checkout__coupon__input" type="text" class="checkout__coupon__input"
        placeholder="{{ esc_attr_e('Discount code', 'sage') }}" value="" />

      <button type="button" class="btn btn--black btn--sm checkout__coupon__button whitespace-nowrap w-36 justify-center"
        value="{{ esc_attr_e('Apply discount', 'sage') }}">{{ _e('Apply', 'sage') }}</button>
    </div>

    <div class="checkout__coupon__message p-2 hidden"></div>
  </div>
@endif
