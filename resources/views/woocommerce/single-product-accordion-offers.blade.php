@if ($should_be_displayed)
  <div class="single-product-accordion__tab-item" id="tab-offers">
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
                <img src="<?php echo esc_url(get_avatar_url($user->ID)); ?>" alt="<?php _e('Avatar', 'sage'); ?>" width="50" height="50">
              @endif
            </div>
            <div class="info_offer noti">

              <p class="text"><a href="<?php echo $user_profile_link; ?>"><span class="bold">@<?php echo $user->display_name; ?></span></a> <?php
                _e('offered ', 'sage');
                echo get_woocommerce_currency_symbol();
                echo $offer_price_per;
                _e(' for this item', 'sage');
                ?></p>
              <p class="time-log"><?php echo $time_elapsed_string; ?></p>
            </div>

            <div class="btn action_offer">
              <?php if ($post_status == 'publish') { ?>
              <div class="dec decline-offer-link">
                <button class="decline woocommerce-offer-post-action-link woocommerce-offer-post-action-link-decline" data-target="<?php echo $id_offer; ?>">
                  <div class="div-loadmore">
                    <i class="fas fa-spinner fa-spin"></i>
                  </div>
                  <?php _e('DECLINE', 'sage'); ?>
                </button>
              </div>
              <div class="acc accept-offer-link">
                <button class="accept woocommerce-offer-post-action-link woocommerce-offer-post-action-link-accept" data-target="<?php echo $id_offer; ?>">
                  <div class="div-loadmore">
                    <i class="fas fa-spinner fa-spin"></i>
                  </div>
                  <?php _e('ACCEPT', 'sage'); ?>
                </button>
              </div>
              <?php } elseif ($post_status == 'accepted-offer') { ?>
              <div class="acc">
                <div class="woocommerce-offer-post-status-grid-icon accepted" title="<?php _e('Offer Status: Accepted', 'sage'); ?>"><?php _e('Accepted', 'sage'); ?></div>
              </div>

              <?php } elseif ($post_status == 'declined-offer') { ?>
              <div class="acc">
                <div class="woocommerce-offer-post-status-grid-icon declined" title=" <?php _e('Offer Status: Declined', 'sage'); ?>"><?php _e('Declined', 'sage'); ?></div>
              </div>
              <?php } ?>
            </div>
          </div>
        @endforeach

      @else
        <p>{{ _e('No offers found!', 'sage') }}</p>
      @endif
    </div>
  </div>
@else
  nothing....
@endif
