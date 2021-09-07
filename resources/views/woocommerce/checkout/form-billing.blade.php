{{-- Checkout billing information form

This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.6.0 --}}

<div class="grid space-y-3 p-4 lg:p-6">
  @php do_action('woocommerce_before_checkout_billing_form', $checkout) @endphp

  @if ($fields)
    @foreach ($fields as $key => $field)
      @php woocommerce_form_field($key, $field, $checkout->get_value($key)) @endphp
    @endforeach
  @endif

  @php do_action('woocommerce_after_checkout_billing_form', $checkout) @endphp
</div>
