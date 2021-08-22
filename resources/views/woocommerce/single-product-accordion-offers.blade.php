@if ($should_be_displayed)
  <div class="single-product-accordion__tab-item single-product-accordion__tab-offers" id="tab-offers">
    <div class="single-product-accordion__tab-top text-lg uppercase border-b pb-2 mb-2 font-bold tracking-widest cursor-pointer" data-tab="#tab-offers">
      <p>{{ _e('Pending offers', 'sage') }}</p>
    </div>
    <div class="single-product-accordion__tab-content hidden prose py-3">

      @if (count($offers))
        @foreach ($offers as $offer)
          @php
          extract($offer)
          @endphp

          <div class="make_offer_item content-box child-offer">
            <div class="avatar_offer img-ava">
              @if (!empty($avatar[0]) && !empty(wp_get_attachment_url($avatar[0])))
                <img src="{{ wp_get_attachment_url($avatar[0]) }}" alt="{{ _e('Avatar', 'sage') }}" width="50" height="50">
              @else
                <img src="{{ esc_url(get_avatar_url($user->ID)) }}" alt="{{ _e('Avatar', 'sage') }}" width="50" height="50">
              @endif
            </div>
            <div class="info_offer noti">

              <p class="text"><a href="{{ $user_profile_link }}"><span class="bold">{{ '@' . $user->display_name }}</span></a>
                {{ _e('offered ', 'sage') }}
                {!! get_woocommerce_currency_symbol() !!}
                {{ $offer_price_per }}
                {{ _e(' for this item', 'sage') }}
              </p>
              <p class="time-log">{{ $time_elapsed_string }}</p>
            </div>

            <div class="btn action_offer">
              @if ($post_status == 'publish')
                @include('woocommerce.single-product-accordion-offers-accept-decline-offer')
              @elseif ($post_status == 'accepted-offer')
                <div class="acc">
                  <div class="woocommerce-offer-post-status-grid-icon accepted" title="{{ _e('Offer Status: Accepted', 'sage') }}">{{ _e('Accepted', 'sage') }}</div>
                </div>

              @elseif ($post_status == 'declined-offer')
                <div class="acc">
                  <div class="woocommerce-offer-post-status-grid-icon declined" title=" {{ _e('Offer Status: Declined', 'sage') }}">{{ _e('Declined', 'sage') }}</div>
                </div>
              @endif
            </div>
          </div>
        @endforeach

      @else
        <p>{{ _e('No offers found!', 'sage') }}</p>
      @endif
    </div>
  </div>
@endif
