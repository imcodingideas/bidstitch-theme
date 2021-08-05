<div class="clear flex items-center justify-between w-full mb-12">
  <div class="">
    <div class="flex items-center space-x-5">
      <div class="">
        <a href="{{ $store_url }}" class="">
          <img src="{{ esc_url($store_user->get_avatar()) }}" alt="{{ esc_attr($store_user->get_shop_name()) }}" size="64" class="h-28 rounded-full w-28">
        </a>
      </div>
      <div class="flex flex-col space-y-3">
        <h3 class="flex items-center space-x-3">
          <span class="font-medium text-3xl">{{ $store_name }}</span>
          <span class="text-red-600"> {{ $store_instagramhandle }}</span>
        </h3>
        <ul class="text-gray-500">
          <div class="">
            <li class="">{{ $product_count }} {{ _e(' AVAILABLE LISTINGS', 'sage') }}</li>
            <li class="">{{ $store_total_sales }} {{ _e('SOLD', 'sage') }}</li>
          </div>
          <li class="">{!! wp_kses_post(dokan_get_store_rating($vendor_id)) !!}</li>

        </ul>
      </div>
    </div>
  </div>
  <div class="flex items-center space-x-5">
    @if (is_user_logged_in())
      dokan_follow_store_get_template( 'follow-button', $args_btn_follow );
    @else
      <a href="{{ home_url('/log-in') }}" class="btn btn--white px-8 py-2 uppercase">{{ _e('Follow Store', 'sage') }}</a>
    @endif
    <a href="{{ $store_url }}" class="btn btn--white px-8 py-2 uppercase">{{ _e('View more', 'sage') }}</a>
  </div>
</div>
