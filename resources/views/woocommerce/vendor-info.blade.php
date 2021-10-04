<div
  class="clear grid space-y-4 bg-gradient-to-r from-white via-gray-100 to-white py-8 my-8 border-t border-b md:py-12 md:my-12">
  <div class="grid items-center justify-between w-full space-y-3 md:flex md:space-y-0">
    <div class="flex items-start space-x-3 md:space-x-6 md:align-center">
      <a href="{{ $store_url }}" class="block bg-gray-100">
        <img src="{{ esc_url($store_user->get_avatar()) }}" alt="{{ esc_attr($store_user->get_shop_name()) }}"
          class="shadow-sm rounded-sm h-32 w-32">
      </a>
      <div class="grid space-y-2 justify-items-start">
        <h3 class="grid space-y-1">
          <span class="font-bold md:text-xl">{{ $store_name }}</span>
          <span class="text-gray-800 text-sm"> {{ $store_instagramhandle }}</span>
        </h3>
        <ul class="text-gray-600 text-sm">
          <li>{{ $product_count }} {{ _e('Available Listings', 'sage') }}</li>
          <li>{{ $store_total_sales }} {{ _e('Sold', 'sage') }}</li>
          {{-- hide reviews until functional --}}
          {{-- <li>{!! wp_kses_post(dokan_get_store_rating($vendor_id)) !!}</li> --}}
        </ul>
        <x-user-chat-button message="Message Seller" receiver="{{ $vendor_id }}"
          class="btn btn--white text-xs px-2 py-1" />
      </div>
    </div>
    <div class="flex items-center space-x-3 md:space-x-6">
      @if (is_user_logged_in())
        @php dokan_follow_store_get_template('follow-button', $args_btn_follow) @endphp
      @else
        <a href="{{ home_url('/log-in') }}"
          class="btn btn--white px-4 py-2 uppercase md:px-8">{{ _e('Follow', 'sage') }}</a>
      @endif
      <a href="{{ $store_url }}"
        class="btn btn--white px-4 py-2 uppercase md:px-8">{{ _e('View more', 'sage') }}</a>
    </div>
  </div>
</div>
