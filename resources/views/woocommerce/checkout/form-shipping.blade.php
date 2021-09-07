{{-- Checkout shipping information form

This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.6.0 --}}

<div class="grid space-y-6 p-4 lg:p-6">
  <div class="grid space-y-6 woocommerce-shipping-fields">
    @if ($needs_shipping_address)
      <div class="flex items-center space-x-4" id="ship-to-different-address">
        <x-form-checkbox
          class="checkout__shipping__input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
          id="ship-to-different-address-checkbox" name="ship_to_different_address" value="1"
          defaultChecked="{{ $shipping_input_checked }}" />

        <x-form-label for="ship-to-different-address-checkbox">
          {{ _e('Ship to a different address?', 'sage') }}
        </x-form-label>
      </div>

      <div class="checkout__shipping__content {{ $shipping_input_checked ? 'flex' : 'hidden' }}">
        @php do_action('woocommerce_before_checkout_shipping_form', $checkout) @endphp

        <div class="grid space-y-3 w-full">
          @foreach ($checkout->get_checkout_fields('shipping') as $key => $field)
            {!! woocommerce_form_field($key, $field, $checkout->get_value($key)) !!}
          @endforeach
        </div>

        @php do_action('woocommerce_after_checkout_shipping_form', $checkout) @endphp
      </div>
    @endif
  </div>
  <div class="grid space-y-3">
    <div class="w-full woocommerce-additional-fields">
      @php do_action('woocommerce_before_order_notes', $checkout) @endphp

      @if ($has_order_notes)
        @foreach ($checkout->get_checkout_fields('order') as $key => $field)
          {!! woocommerce_form_field($key, $field) !!}
        @endforeach
      @endif

      @php do_action('woocommerce_after_order_notes', $checkout) @endphp
    </div>
  </div>
</div>
