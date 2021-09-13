<div class="grid space-y-8 justify-items-center seller-listing-content mt-8 lg:mt-16">
  @if ($sellers)
    <ul class="w-full grid gap-8 md:gap-12 grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
      @foreach ($sellers as $seller)
        <li>
          <div class="space-y-4 text-center">
            <a href="{{ esc_url($seller->store_url) }}">
              <img src="{{ esc_url($seller->store_avatar) }}" alt="{{ esc_attr($seller->store_name) }}"
                class="mx-auto h-20 w-20 rounded-full lg:w-24 lg:h-24">
            </a>
            <div class="space-y-2">
              <div class="text-xs font-medium lg:text-sm">
                <a href="{{ esc_url($seller->store_url) }}">
                  <h3 class="capitalize">{{ esc_attr($seller->store_name) }}</h3>
                </a>
              </div>
            </div>
          </div>
        </li>
      @endforeach
    </ul>

    @if ($pagination)
      <div class="pagination-wrap">
        <ul class="pagination mt-0 mb-0">
          @foreach ($pagination as $link)
            <li>{!! $link !!}</li>
          @endforeach
        </ul>
      </div>
    @endif
  @endif
</div>
