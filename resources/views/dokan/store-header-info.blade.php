<div class="profile-info flex flex-col space-y-2">
  @if (!empty($shop_name) && 'default' !== $profile_layout)
    <div class="flex justify-center sm:justify-start">
      <h1 class="store-name">
        {{ $shop_name }}
      </h1>
      <div class="flex">
        @if (true || $founder == 'true')
          <img class="w-5 ml-4" src="@asset('images/crown.svg')" alt="crown" />
        @endif
        @if (true || $igverified == 'true')
          <img class="w-5 ml-4" src="@asset('images/instagram.svg')" alt="instagram" />
        @endif
      </div>
    </div>
    <p class="vendorshophandle text-center sm:text-left">{{ $vendor_name }}</p>
  @endif

  {{-- <div class="dokan-store-rating mb-show dokan-store-rating-mb ml-6">
    {!! $store_rating !!}
  </div> --}}
  <div class="hidden items-center md:flex space-x-4">
    @if (is_user_logged_in())
      @php dokan_follow_store_get_template( 'follow-button', $args_btn_follow ) @endphp
    @else
      <p>
        <a href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) }}"
          class="login_btn vender_action_btn">
          <img class="w-4" src="@asset('images/heart-regular.svg')" alt="heart" />
        </a>
      </p>
    @endif
  </div>
  <div class="dokan-store-des text-center sm:text-left">
    {{ $dokan_store_des }}
  </div>

  @if ($countryname)
    <div class="dokan-store-address text-center sm:text-left">
      <p class="dokan-store-address-label">{{ _e('Location', 'sage') }}</p>
      <p class="dokan-store-address-info"></i>
        {{ $countryname }}
      </p>
    </div>
  @endif

</div>
