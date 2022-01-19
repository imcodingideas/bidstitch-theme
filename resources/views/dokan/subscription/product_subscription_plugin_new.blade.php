@php do_action('dokan_dashboard_wrap_start') @endphp

@include('dokan.settings.header')

<div class="grid space-y-8">
  @php do_action('dokan_dashboard_content_before') @endphp
  @php do_action('dokan_subcription_content_before') @endphp

  @php do_action('dokan_subscription_content_inside_before') @endphp

  @if (dokan_is_seller_enabled(get_current_user_id()))
    <div>
      {!! do_shortcode('[dps_product_pack]') !!}

      @if ($stripe_button)
        <div class="-mt-8 mb-6">
          <button class="w-full sm:w-auto px-6 py-3 bg-black text-white" id="bidstitch-update-cc-button">Update Card Details</button>
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
