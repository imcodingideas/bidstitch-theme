{{-- Checkout Payment Section

This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see     https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.5.3 --}}

@if (!is_ajax())
  @php do_action('woocommerce_review_order_before_payment') @endphp
@endif

<div class="woocommerce-checkout-payment checkout__paymentmethod__wrapper" id="payment">
  {{-- Shipping Method --}}
  @include('woocommerce.checkout.shipping')

  {{-- Payment Method --}}
  <div class="wc_payment_methods payment_methods methods">
    @if ($needs_payment)
      @include('woocommerce.checkout.payment-method')
    @endif
  </div>
</div>

@if (!is_ajax())
  @php do_action('woocommerce_review_order_after_payment') @endphp
@endif
