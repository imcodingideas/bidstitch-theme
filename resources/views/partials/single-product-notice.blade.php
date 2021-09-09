<section class="bg-gradient-to-r from-white via-gray-100 to-white">
  <div class="container py-12 lg:py-16">
    <div class="max-w-4xl mx-auto text-center space-y-6 sm:space-y-8">
      <h2 class="text-xl font-extrabold tracking-tight text-gray-900 sm:text-4xl space-y-3">
        <span class="block text-sm sm:text-lg">{{ _e('Ready to dive in?', 'sage') }}</span>
        <span class="block">{{ $single_product_notice }}</span>
      </h2>
      <div class="flex justify-center space-x-3">
        <div class="inline-flex rounded-md shadow">
          <a href="{{ $shop_page_url }}" class="btn btn--black text-sm px-3 py-1 sm:px-6 sm:py-2 sm:text-base">
            {{ _e('Shop now', 'sage') }}
          </a>
        </div>
        <div class="inline-flex">
          <a href="{{ esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . '#register') }}"
            class="btn btn--white text-sm px-3 py-1 sm:px-6 sm:py-2 sm:text-base">
            {{ _e('Start Selling', 'sage') }}
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
