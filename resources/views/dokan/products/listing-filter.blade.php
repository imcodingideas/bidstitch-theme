<form method="get" class="w-full sm:w-auto">
  @php wp_nonce_field('dokan_product_search', 'dokan_product_search_nonce') @endphp
  <div class="flex space-x-2 w-full justify-between sm:justify-start sm:w-auto">
    <div class="relative w-full">
      <input class="h-10 w-full sm:w-auto shadow-sm rounded-sm border-0 focus:ring-0 pr-12" type="text"
        name="{{ $search->name }}" placeholder="{{ $search->label }}" value="{{ $search->value }}">
      <a class="absolute right-0 top-0 h-full w-12 flex items-center justify-center group" aria-label="Clear search"
        href="{{ dokan_get_navigation_url($is_auction ? 'auction' : 'products') }}">
        <img aria-hidden="true" focusable="false" class="transition-opacity w-5 opacity-60 group-hover:opacity-80"
          src="@asset('images/x-circle.svg')" alt="x-circle" />
      </a>
    </div>
    <button class="btn btn--black px-2 flex h-10 w-auto" type="submit">{{ _e('Search', 'sage') }}</button>
  </div>
</form>
