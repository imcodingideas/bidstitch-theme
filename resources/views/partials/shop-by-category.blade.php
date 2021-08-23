{{-- old: ss-shop-by-category --}}
<section class="shop-by-category py-12" id="new_home_category_button">
  <div class="container mx-auto">
    <div class="wrapper-section">
      <div class="inner-section">
        <div class="px-4 sm:px-6 sm:flex sm:items-center sm:justify-between lg:px-8 xl:px-0">
          <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Shop by Category</h2>
          <a href="<?php echo wc_get_page_permalink( 'shop' ) ?>" class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-500 sm:block">Browse all categories<span aria-hidden="true"> &rarr;</span></a>
        </div>
        <div class="mt-4 flow-root">
          <div class="-my-2">
            <div class="box-content py-2 relative overflow-x-auto xl:overflow-visible">
              <div class="absolute min-w-screen-xl px-4 flex space-x-8 sm:px-6 lg:px-8 xl:relative xl:px-0 xl:space-x-0 xl:grid xl:grid-cols-6 xl:gap-x-8">
                @if ($categories)
                  @foreach ($categories as $category)
                      <a href="{{ $category['link'] }}" class="relative w-56 h-80 rounded-lg p-6 flex flex-col overflow-hidden hover:opacity-75 xl:w-auto">
                        <span aria-hidden="true" class="absolute inset-0">
                          <img src="{{ $category['image'] }}" alt="" class="w-full h-full object-center object-cover">
                        </span>
                        <span aria-hidden="true" class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-gray-800 opacity-50"></span>
                        <span class="relative mt-auto text-center text-xl font-bold text-white">{{ $category['name'] }}<br>{{ $category['string_category'] }}</span>
                      </a>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
