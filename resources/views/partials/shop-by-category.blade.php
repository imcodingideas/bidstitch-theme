<section id="shop_by_category">
  <div class="container py-8">
    <div class="grid space-y-4">
      <div class="flex space-x-4 justify-between items-center">
        <h2 class="">{{ _e('Shop by Category', 'sage') }}</h2>
        <a class="hidden md:flex"
          href="{{ esc_url(wc_get_page_permalink('shop')) }}">{{ _e('Browse all categories', 'sage') }}</a>
      </div>
      <div class="flex space-x-4">
        @if ($categories)
          @foreach ($categories as $category)
          <div class="">
            <a href="{{ esc_url($category->link) }}"
              class="relative flex flex-col">
              @if ($category->thumbnail)
                  {{-- <img src="{{ esc_url($category->thumbnail) }}" alt="" class="w-full h-full object-center object-cover"> --}}
                  <img src="https://bidstitchprod.s3.amazonaws.com/uploads/2021/04/banner-pro-1.png" alt="" class="w-full h-full object-center object-cover border shadow-lg rounded-lg p-3">
                @else
                  <span class="absolute bg-gray-200 h-full w-full p-8"></span>
                @endif
              <p class="relative mt-2 text-center text-base capitalize">{{ $category->name }}</p>
            </a>
          </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
</section>