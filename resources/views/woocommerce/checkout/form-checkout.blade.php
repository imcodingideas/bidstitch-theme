{{-- Checkout Form

This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce\Templates
@version 3.5.0 --}}

<div class="min-h-screen bg-gray-100">
  <div class="container py-8 lg:py-16">
    @php do_action('woocommerce_before_checkout_form', $checkout) @endphp

    @if ($user_can_checkout)
      <form class="checkout woocommerce-checkout" name="checkout" method="post"
        action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
        {{-- Notices --}}
        <div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">
          {!! wc_print_notices() !!}
        </div>

        <div class="grid grid-cols-1 gap-y-6 md:grid-cols-12 gap-x-8 lg:gap-x-16 items-start">
          <div class="grid space-y-6 md:col-span-6 xl:col-span-7">
            {{-- Billing & Shipping --}}
            @if ($has_checkout_fields)
              @php do_action('woocommerce_checkout_before_customer_details') @endphp

              {{-- Billing --}}
              <div class="grid space-y-3">
                <h3 class="font-bold text-xl">{{ _e('Billing details', 'sage') }}</h3>

                <div class="bg-white shadow rounded">
                  @include('woocommerce.checkout.form-billing')
                </div>
              </div>

              @if ($user_can_register_account)
                {{-- Account --}}
                <div class="grid space-y-3">
                  <h3 class="font-bold text-xl">{{ _e('Account details', 'sage') }}</h3>

                  <div class="bg-white shadow rounded">
                    @include('woocommerce.checkout.form-account')
                  </div>
                </div>
              @endif

              {{-- Shipping --}}
              <div class="grid space-y-3">
                <h3 class="font-bold text-xl">{{ _e('Shipping details', 'sage') }}</h3>

                <div class="bg-white shadow rounded">
                  @include('woocommerce.checkout.form-shipping')
                </div>
              </div>

              @php do_action('woocommerce_checkout_after_customer_details') @endphp
            @endif
            {{-- Payment --}}
            <div class="grid space-y-3">
              <h3 class="font-bold text-xl">{{ _e('Payment details', 'sage') }}</h3>

              <div class="bg-white shadow rounded">
                @include('woocommerce.checkout.payment')
              </div>
            </div>
          </div>

          {{-- Order Review --}}
          <div class="grid md:sticky md:top-28 lg:top-40 md:col-span-6 xl:col-span-5">
            <div class="grid space-y-3">
              <h3 class="font-bold text-xl">{{ _e('Order Summary', 'sage') }}</h3>

              <div id="order_review" class="shadow bg-white rounded woocommerce-checkout-review-order">
                @php do_action('woocommerce_checkout_order_review') @endphp
              </div>
            </div>
          </div>
        </div>
      </form>
    @else
      <div class="space-y-3">
        <p>
          {{ esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'sage'))) }}
        </p>

        <a class="btn btn--sm btn--black"
          href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) }}">{{ _e('Click Here to Log In') }}</a>
      </div>
    @endif

    @php do_action('woocommerce_after_checkout_form', $checkout) @endphp
  </div>
</div>
