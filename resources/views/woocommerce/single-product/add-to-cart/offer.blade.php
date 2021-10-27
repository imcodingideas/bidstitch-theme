@if ($user_can_offer)
  <div class="block mb-8" x-data="offerForm()">
    {{-- Offer Form --}}
    @include('forms.offer')

    {{-- Open Offers --}}
    @if ($current_user_has_offers)
      {{-- Manage Open Offers --}}
      @if ($sent_offers_link)
        <a href="{!! esc_url($sent_offers_link) !!}"
          class="btn btn--black flex font-bold justify-center py-2 text-lg uppercase w-full">
          {{ _e('View Offers', 'sage') }}
        </a>
      @endif
      
      {{-- Buyer Counteroffer --}}
      @if ($buyer_counteroffer_data)
        <x-offer-form-button class="hidden" x-ref="action_init" x-init="$nextTick(() => handleInitialMount())"
          offer_action="buyercountered-offer" offer_id="{{ esc_attr($buyer_counteroffer_data->offer_id) }}"
          offer_product_Id="{{ esc_attr($buyer_counteroffer_data->offer_product_id) }}"
          offer_price="{{ esc_attr($buyer_counteroffer_data->offer_price) }}">asd</x-offer-form-button>
      @endif
    @else
      {{-- Create Offer --}}
      @if ($current_user_can_create_offer)
        <x-offer-form-button offer_action="publish" offer_product_Id="{{ esc_attr($product_id) }}"
          class="btn btn--black flex font-bold justify-center py-2 text-lg uppercase w-full">
          {{ _e('Send Offer', 'sage') }}
        </x-offer-form-button>
      @endif
    @endif
  </div>
@endif
