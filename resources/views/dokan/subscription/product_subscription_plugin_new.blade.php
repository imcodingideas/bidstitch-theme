@php do_action('dokan_dashboard_wrap_start') @endphp

@include('dokan.settings.header')

<div class="grid space-y-8">
  @php do_action('dokan_dashboard_content_before') @endphp
  @php do_action('dokan_subcription_content_before') @endphp

  @php do_action('dokan_subscription_content_inside_before') @endphp

  @if (dokan_is_seller_enabled(get_current_user_id()))
    <div>
      {!! do_shortcode('[dps_product_pack]') !!}

      @if ($display_stripe_button || $display_success_message)
        <div class="-mt-8 mb-6 space-y-3">

          @if ($display_success_message)
            <div class="px-6 py-3 border border-green-500 bg-green-100 text-center">
              Your card details have been successfully updated!
            </div>
          @endif

          @if ($display_stripe_button)
            <div class="bg-white shadow-lg p-4 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
              <p>Payment method: <span class="font-mono text-gray-700">XXXX-{{ $card_last_digits }}</span></p>
              <a class="inline-block w-full sm:w-auto px-6 py-3 bg-black text-white text-center" href="/update-stripe-payment-details">Update Card Details</a>
            </div>
          @endif

        </div>
      @endif
    </div>
  @else
    {!! dokan_seller_not_enabled_notice() !!}
  @endif

  @php do_action('dokan_subscription_content_inside_after') @endphp

  @php do_action('dokan_dashboard_content_after') @endphp
  @php do_action('dokan_subscription_content_after') @endphp
</div>

@php do_action('dokan_dashboard_wrap_end') @endphp
