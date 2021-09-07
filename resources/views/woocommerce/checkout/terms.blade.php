{{-- Checkout terms and conditions area.

@package WooCommerce\Templates
@version 3.4.0 --}}

@if ($has_terms)
  @php do_action('woocommerce_checkout_before_terms_and_conditions') @endphp

  <div class="grid space-y-3 woocommerce-terms-and-conditions-wrapper">
    @php do_action('woocommerce_checkout_terms_and_conditions') @endphp

    @if (wc_terms_and_conditions_checkbox_enabled())
      <div class="flex space-x-2 items-center">
        <x-form-checkbox class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms"
          id="terms" isChecked="{{ $shipping_input_checked ? 'checked' : '' }}" required />

        <x-form-label for="terms" class="inline woocommerce-form__label woocommerce-form__label-for-checkbox checkbox"
          required>
          <span>{{ wc_terms_and_conditions_checkbox_text() }}</span>
        </x-form-label>

        <input type="hidden" name="terms-field" value="1" />
      </div>
    @endif
  </div>

  @php do_action('woocommerce_checkout_after_terms_and_conditions') @endphp
@endif
