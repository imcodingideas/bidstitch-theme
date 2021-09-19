{{-- Output a single payment method

This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see         https://docs.woocommerce.com/document/template-structure/
@package     WooCommerce\Templates
@version     3.5.0 --}}

<div class="grid space-y-3 p-4 border-b lg:p-6">
  <span class="text-sm font-medium text-gray-700">{{ _e('Payment method', 'sage') }}</span>

  <div class="grid space-y-3">
    @if ($available_gateways)
      <div class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($available_gateways as $gateway)
          <label
            class="cursor-pointer bg-white rounded border flex focus:outline-none items-center text-sm leading-none px-2 py-4 space-x-2 lg:space-x-4 lg:px-4">
            <x-form-radio id="payment_method_{{ esc_attr($gateway->id) }}"
              class="cursor-pointer checkout__paymentmethod__input checkout__paymentmethod__input--{{ esc_attr($gateway->id) }}"
              name="payment_method" value="{{ esc_attr($gateway->id) }}"
              data-order_button_text="{{ esc_attr($gateway->order_button_text) }}"
              isChecked="{{ $gateway->chosen ? 'checked' : '' }}" />

            <span>{{ $gateway->get_title() }}</span>
          </label>
        @endforeach
      </div>

      <div class="flex w-full">
        @foreach ($available_gateways as $gateway)
          @if ($gateway->has_fields() || $gateway->get_description())
            <div
              class="w-full flex-col checkout__paymentmethod__content payment_method_{{ esc_attr($gateway->id) }} {{ $gateway->chosen ? 'fiex' : 'hidden' }}">
              {!! $gateway->payment_fields() !!}
            </div>
          @endif
        @endforeach
      </div>
    @else
      <div class="bg-red-50 text-red-800 p-2">
        {{ $payment_unavailable_notice }}
      </div>
    @endif
  </div>
</div>
