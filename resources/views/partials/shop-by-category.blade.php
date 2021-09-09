<section id="shop_by_category">
  <div class="container py-8 lg:py-16">
    <div class="grid space-y-8">
      <div class="flex space-x-4 justify-between items-center">
        <h3 class="text-xl md:text-3xl font-bold uppercase">{{ _e('Shop by Category', 'sage') }}</h3>
        <a class="hidden md:flex"
          href="{{ esc_url(wc_get_page_permalink('shop')) }}">{{ _e('Browse all categories', 'sage') }}</a>
      </div>
      <div class="grid grid-cols-2 gap-x-3 gap-y-3 md:gap-y-6 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-6">
        @foreach ($categories as $category)
          <a href="{{ esc_url($category->link) }}"
            class="relative w-full h-48 md:h-72 rounded-lg p-6 flex flex-col overflow-hidden hover:opacity-75 xl:w-auto">
            <span aria-hidden="true" class="absolute inset-0">
              @if ($category->thumbnail)
                <img src="{{ esc_url($category->thumbnail) }}" alt="" class="w-full h-full object-center object-cover">
              @else
                <span class="absolute bg-gray-200 h-full w-full p-8"></span>
              @endif
            </span>
            <span aria-hidden="true"
              class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-gray-800 opacity-70"></span>
            <span
              class="relative mt-auto text-center text-base font-bold text-white md:text-xl">{{ $category->name }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
