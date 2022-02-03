@php do_action('dokan_dashboard_wrap_start') @endphp
@php do_action('dokan_dashboard_content_before') @endphp

<div class="space-y-4">
  <h1 class="text-2xl text-center sm:text-left">Credit Card Details</h1>

  @if ($display_success_message)
    <div class="dokan-alert dokan-alert-success">
      Your card details have been successfully updated!
    </div>
  @endif

  @if (dokan_is_seller_enabled(get_current_user_id()))
  <p class="dokan-alert dokan-alert-info">Below is the card we have on file for your vendor subscription. To update the card click on "Update Card Details".</p>
    @if ($display_stripe_button)
      <div class="bg-white shadow-lg p-4 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <p>Payment method: <span class="py-2 px-4 rounded-full font-mono bg-gray-200 text-gray-700 text-sm">XXXX-{{ $card_last_digits }}</span></p>
        <a class="inline-block w-full sm:w-auto px-6 py-3 bg-black text-white text-center" href="/update-stripe-payment-details">Update Card Details</a>
      </div>
    @else
      <div class="dokan-alert dokan-alert-danger">
        There is no record of your card details used to purchase a vendor subscription. Please contact <a class="underline" href="mailto:support@bidstitch.com">support@bidstitch.com</a> for help.
      </div>
    @endif
  @else
    {!! dokan_seller_not_enabled_notice() !!}
  @endif
</div>

@php do_action('dokan_dashboard_content_after') @endphp
@php do_action('dokan_dashboard_wrap_end') @endphp