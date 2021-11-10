@if ($offer_action)
  <button @click.prevent="handleModalOpen($event)" data-offer_id="{{ esc_attr($offer_id) }}"
    data-offer_price="{{ esc_attr($offer_price) }}" data-offer_action="{{ esc_attr($offer_action) }}"
    data-offer_product_id="{{ esc_attr($offer_product_id) }}" {{ $attributes }} x-ref="button-modal">
    {!! $slot ? $slot : __('Send Offer') !!}
  </button>
@endif
